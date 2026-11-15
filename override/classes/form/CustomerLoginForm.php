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
 * Keep invalid credential types out of IDN conversion and password hashing.
 */
class CustomerLoginForm extends CustomerLoginFormCore
{
    /**
     * Preserve native validation and authentication for all string values.
     * The return type is inherited from the untyped legacy core contract.
     *
     * @param array $params Untrusted form values
     *
     * @return CustomerLoginForm
     */
    public function fillWith(array $params = [])
    {
        if (Module::isEnabled('tecinputguard')) {
            foreach (['email', 'password'] as $field) {
                if (array_key_exists($field, $params) && !is_string($params[$field])) {
                    $params[$field] = '';
                }
            }
        }

        return parent::fillWith($params);
    }
}
