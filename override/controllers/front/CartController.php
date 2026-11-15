<?php
/**
 * Copyright 2026 Arte e Informatica di Loris Modena e C. s.a.s.
 *
 * @author    Tecnoacquisti.com <helpdesk@tecnoacquisti.com>
 * @copyright 2026 Arte e Informatica di Loris Modena e C. s.a.s.
 * @license   https://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Reject malformed quantities before cart initialization or mutation.
 */
class CartController extends CartControllerCore
{
    /**
     * Keep native token, ownership, stock and pricing checks in the parent.
     * The return type is inherited from the untyped legacy core contract.
     *
     * @return mixed The original initialization result for valid requests
     */
    public function init()
    {
        if (Module::isEnabled('tecinputguard')) {
            // Match Tools::getValue precedence without stripping control bytes.
            $quantity = $_POST['qty'] ?? $_GET['qty'] ?? 1;
            $token = $_POST['token'] ?? $_GET['token'] ?? '';
            $valid = is_int($quantity) || is_string($quantity);
            if ($valid) {
                $quantity = (string) $quantity;
                $valid = preg_match('/\A[0-9]{1,10}\z/D', $quantity) === 1;
                if ($valid) {
                    $valid = strlen($quantity) < 10 || strcmp($quantity, '2147483647') <= 0;
                }
            }

            if (!$valid || !is_string($token)) {
                http_response_code(400);
                header('Content-Type: text/plain; charset=utf-8');
                header('Cache-Control: no-store');
                header('X-Content-Type-Options: nosniff');
                exit('Invalid cart request.');
            }
        }

        return parent::init();
    }
}
