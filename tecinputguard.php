<?php
/**
 * Copyright 2026 Arte e Informatica di Loris Modena e C. s.a.s.
 *
 * @author    Tecnoacquisti.com <helpdesk@tecnoacquisti.com>
 * @copyright 2026 Arte e Informatica di Loris Modena e C. s.a.s.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   1.0.2
 */
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Narrow input guards for the legacy PrestaShop 8.2 login and cart paths.
 */
class TecInputGuard extends Module
{
    /**
     * Describe the module without changing authentication or cart policies.
     */
    public function __construct()
    {
        $this->name = 'tecinputguard';
        $this->tab = 'administration';
        $this->version = '1.0.2';
        $this->author = 'Tecnoacquisti.com';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '8.2.0', 'max' => '8.2.99'];

        parent::__construct();

        $this->displayName = $this->l('Login and cart input guard');
        $this->description = $this->l('Guards PrestaShop 8.2 against invalid login input types (issue #42963) and malformed cart quantities (issue #31570), without editing core files.');
        $this->confirmUninstall = $this->l('Remove the input guards and restore the original core behavior?');
    }

    /**
     * Refuse an installation that cannot activate the required overrides.
     *
     * @return bool
     */
    public function install(): bool
    {
        if (Configuration::get('PS_DISABLE_OVERRIDES')) {
            $this->_errors[] = $this->l('Enable PrestaShop overrides before installing this module.');

            return false;
        }

        return parent::install();
    }
}
