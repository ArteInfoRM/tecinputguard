# Login and cart input guard

Tecnoacquisti.com® provides narrow input validation for the legacy PrestaShop 8.2 login form and cart controller. This module leaves core files unchanged and uses PrestaShop's native override installation mechanism.

It addresses the malformed-input cases documented in PrestaShop [login issue #42963](https://github.com/PrestaShop/PrestaShop/issues/42963) and [cart issue #31570](https://github.com/PrestaShop/PrestaShop/issues/31570): non-string login credentials and invalid cart quantities are handled before they reach the affected core processing. The module also rejects non-string cart tokens while preserving native token validation.

## Scope and behavior

- Non-string `email` and `password` form values become empty strings before the original login form processes them. Required-field validation, authentication, password hashing and authentication hooks remain in the core.
- Cart `qty` must be an integer or an ASCII decimal string of 1–10 digits, between 0 and 2147483647. Missing quantity retains the native default of 1. Zero reaches native cart validation. Leading zeros are accepted within the length limit. Negative, signed, fractional, scientific notation, whitespace, control bytes, arrays and oversized values receive HTTP 400 before cart initialization.
- A supplied cart `token` must be a string. Its value is still checked by the core; this module never generates, replaces or approves a token. A missing token retains the native behavior.
- GET/POST precedence is preserved: POST takes precedence over GET, as in `Tools::getValue()`. Invalid requests return a fixed plain-text message, with `no-store` and `nosniff` headers, without reflecting input.
- Cart ownership, prices, stock, discounts, minimum quantities and checkout rules remain in the core and installed business modules.

This is not a general firewall or a complete fix for all malformed PrestaShop parameters. It does not address password-reset controllers, unrelated IDs, redirects, other modules, or session-cookie lifetime.

## Compatibility

The supported installation scope remains PrestaShop 8.2.x (metadata: 8.2.0–8.2.99). The verified released range is **8.2.0–8.2.9**, checked against every official tag on 15 November 2026. The metadata upper bound is a branch constraint, not a claim that future patches have been tested.

| PrestaShop versions | Source and isolated method checks | Full-shop evidence / support |
| --- | --- | --- |
| 8.2.0–8.2.9, every released tag | 76 assertions per tag passed using the official login form and cart controller | Supported branch. Local runtime tests: 8.2.5 / PHP 8.1.34. Owner-reported shop checks: 8.2.0, 8.2.5 and 8.2.9. Authenticated production retest: 8.2.9 on 15 November 2026. |
| 8.0.0–8.0.5 and 8.1.0–8.1.7, every released tag | 76 assertions per tag passed | Candidates for a future extension only. Installation metadata still excludes these versions; full-shop installation and lifecycle tests are needed. |
| 1.7.8.11 | 76 assertions passed on the review machine's PHP runtime | Exploratory source check only; not supported or tested on the full PHP matrix for 1.7. |
| 9.0.0, 9.1.0, 9.2.0 and 9.2.1 | Current cart override fails the parent method signature contract | Not compatible. The core requires `CartController::init(): void`; do not force installation. |

Across 8.2.0–8.2.9 the complete `CustomerLoginForm.php` is identical. `CartController.php` differs between 8.2.0 and 8.2.1+, but the exercised override contracts pass on every tag. Source compatibility does not validate unrelated cart code, third-party overrides, every PHP version, or installation from a ZIP.

Source comparison uses the [official PrestaShop tags](https://github.com/PrestaShop/PrestaShop/tags), specifically `classes/form/CustomerLoginForm.php` and `controllers/front/CartController.php`. Reproduce the isolated checks with externally downloaded, unmodified files named `CustomerLoginForm.php` and `CartController.php` in a version-specific directory:

```bash
php tests/regression.php /path/to/core-fixtures/8.2.9 8.2.9
```

Production deployment requires an inventory of existing overrides and the exact installed patch version. Custom cart integrations must send unsigned integer quantities and use the native `op=down` operation to decrease quantities.

Multishop installation and activation lifecycle have not been validated. Native override files are shared by all shops even though the runtime activation check is per shop. Review all-shop lifecycle behavior before using this module in a multishop installation.

## Installation and recovery

Use the normal PrestaShop module manager. Overrides must be enabled, and the web process must be able to write to the relevant override directories and class-index cache. An existing override of either `CustomerLoginForm::fillWith()` or `CartController::init()` must be reviewed before installation; do not overwrite another module's code.

The module creates no tables, configuration values, cron jobs, public controllers or external network calls. Activation is checked per shop. Standard disable/uninstall operations remove the module's overrides and restore native behavior, including the original malformed-input defects. Clear the PrestaShop class-index/cache if required and preserve web-process ownership. Do not manually delete unrelated overrides. If removal fails, resolve file permissions and retry the native operation.

For a future update that changes override methods, disable the installed version before replacing its files, then enable the new version and verify the copied overrides. Keep a backup of existing override files. Global override disabling also disables this protection.

## Upstream references

- Login input types: [issue #42963](https://github.com/PrestaShop/PrestaShop/issues/42963), [PR #42979](https://github.com/PrestaShop/PrestaShop/pull/42979).
- Cart quantity types: [issue #31570](https://github.com/PrestaShop/PrestaShop/issues/31570), [PR #31571](https://github.com/PrestaShop/PrestaShop/pull/31571).

The cart guard deliberately rejects malformed quantities rather than casting an array to a valid quantity. It is an independent guard, not a verbatim copy of the upstream patch.

## Validation and release status

Version 1.0.0 is the initial source and installation-package release. Authenticated production behavior on an existing 8.2.9 installation was retested on 15 November 2026; this is not a clean ZIP installation test. The internal test report records both successful checks and unrelated pre-existing failures. ZIP installation/upgrade testing and PrestaShop Validator submission remain manual release controls for the project owner.

Support and security contact: helpdesk@tecnoacquisti.com.

License: MIT starting with version 1.0.1; see `LICENSE.md`. Previously published tags and ZIPs retain their original license notices. The module is available free of charge; the license choice is independent of pricing.

Source and version tags: https://github.com/ArteInfoRM/tecinputguard

Security evidence and remaining release controls: see CRA.md. The dependency SBOM and risk assessment are maintained in the internal release archive.
