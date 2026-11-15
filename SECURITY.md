# Security policy

## Private reporting

Report suspected vulnerabilities in tecinputguard privately to helpdesk@tecnoacquisti.com. Include the module, PrestaShop and PHP versions, reproduction steps and observed impact. Do not publish unpatched vulnerabilities, credentials, session tokens or customer data in public issues.

If credentials are necessary, follow the [secure credential instructions](https://www.tecnoacquisti.com/it/content/19-come-inviare-le-tue-password).

## Release scope

The 1.0.x release line targets PrestaShop 8.2.0 through 8.2.99, on a PHP version supported by that PrestaShop release. Runtime validation covers PHP 8.1.34 with PrestaShop 8.2.5; isolated method-contract tests cover all official 8.2.0–8.2.9 tags. An authenticated production retest also covers an existing 8.2.9 installation. Earlier 8.x versions are source-tested candidates, not supported installations; the current cart override is incompatible with the examined 9.x method signatures. A fixed security-support end date has not been announced. This document does not promise a support duration or response SLA.

## Updates and recovery

Source updates and version tags are available at https://github.com/ArteInfoRM/tecinputguard. Read CHANGELOG.md and README.md before applying an update, particularly the override conflict and recovery instructions. Security maintenance is distinct from paid installation or commercial assistance; commercial support terms do not define a security-support period.

The module validates selected login and cart inputs. It does not replace authentication, authorization, CSRF protection, application updates or deployment-specific testing. Disabling the module or all overrides removes this protection. Multishop lifecycle and full installation on other patch versions remain unvalidated.
