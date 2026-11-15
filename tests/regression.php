<?php
/**
 * Copyright 2026 Arte e Informatica di Loris Modena e C. s.a.s.
 *
 * @license https://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

// Run only from CLI with externally supplied, unmodified core source fixtures.
if (PHP_SAPI !== 'cli' || empty($argv[1])) {
    exit(1);
}

// Select the version of the externally supplied source fixtures.
$coreVersion = $argv[2] ?? '8.2.9';
if (!preg_match('/\A[0-9]+\.[0-9]+\.[0-9]+(?:\.[0-9]+)?\z/D', $coreVersion)) {
    exit(1);
}
define('_PS_VERSION_', $coreVersion);

/** Test double for activation, without database or shop mutation. */
class Module
{
    /** @var bool */
    public static $enabled = true;

    /** Return the test activation state. */
    public static function isEnabled(string $name): bool
    {
        return self::$enabled && $name === 'tecinputguard';
    }
}

/** Capture parameters passed to the unchanged core form implementation. */
class AbstractForm
{
    /** @var array */
    public $received = [];

    /** Preserve the legacy fluent contract. */
    public function fillWith(array $params = [])
    {
        $this->received = $params;

        return $this;
    }
}

/** Minimal parent for exercising the actual CartControllerCore::init method. */
class FrontController
{
    /** @var int */
    public static $calls = 0;

    /** Record that normal initialization was reached. */
    public function init()
    {
        ++self::$calls;
    }
}

/** Use the documented request parameter precedence for isolated tests. */
class Tools
{
    /** Read a test request value, preserving legacy mixed defaults. */
    public static function getValue($key, $default = false)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}

require $argv[1] . '/CustomerLoginForm.php';
require $argv[1] . '/CartController.php';
require dirname(__DIR__) . '/override/classes/form/CustomerLoginForm.php';
require dirname(__DIR__) . '/override/controllers/front/CartController.php';

$checks = 0;
$assert = static function (bool $condition, string $name) use (&$checks): void {
    if (!$condition) {
        throw new RuntimeException($name);
    }
    ++$checks;
};
$form = (new ReflectionClass('CustomerLoginForm'))->newInstanceWithoutConstructor();
$property = new ReflectionProperty('CustomerLoginFormCore', 'IDNConverter');
$property->setAccessible(true);
$property->setValue($form, new class() {
    /** Assert the type boundary without duplicating IDN conversion. */
    public function emailToUtf8(string $value): string
    {
        return $value;
    }
});

foreach (['email', 'password'] as $field) {
    foreach ([[], ['x'], ['a' => ['b' => 'x']], null, false, true, 0, 42, 1.5, new stdClass()] as $value) {
        $values = ['email' => 'review@example.invalid', 'password' => ' keep exact bytes ', 'back' => 'my-account'];
        $values[$field] = $value;
        $result = $form->fillWith($values);
        $assert($result === $form, 'Fluent form contract');
        $assert($form->received[$field] === '', 'Invalid type becomes empty');
        $assert($form->received['back'] === 'my-account', 'Unrelated field preserved');
    }
}
foreach (['', '0', ' white space ', "unicode-\xc3\xa8", "binary\0value", str_repeat('x', 1000)] as $password) {
    $values = ['email' => 'review@example.invalid', 'password' => $password];
    $form->fillWith($values);
    $assert($form->received === $values, 'String credentials preserved byte for byte');
}
$form->fillWith([]);
$assert($form->received === [], 'Absent fields preserved');
Module::$enabled = false;
$form->fillWith(['password' => ['x']]);
$assert($form->received['password'] === ['x'], 'Disabled module delegates unchanged');
Module::$enabled = true;

foreach ([null, '0', '1', '01', '0000000001', '2147483647', 1] as $quantity) {
    $_GET = $quantity === null ? [] : ['qty' => $quantity];
    $_POST = [];
    $cart = new CartController();
    $cart->init();
    $property = new ReflectionProperty('CartControllerCore', 'qty');
    $property->setAccessible(true);
    $assert($property->getValue($cart) === ($quantity === null ? 1 : (int) $quantity), 'Native quantity preserved');
}
$assert(FrontController::$calls === 7, 'Parent initialization called exactly once per request');
echo json_encode(['checks' => $checks, 'passed' => $checks, 'core_fixtures' => $coreVersion, 'scope' => 'Isolated method contracts; not a full shop installation']) . PHP_EOL;
