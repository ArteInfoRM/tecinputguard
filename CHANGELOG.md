# Changelog

## [1.0.2] - 2026-11-15

- Align PHP file header tags with the validator and add missing author and copyright tags to directory guards and tests.

## [1.0.1] - 2026-11-15

- Include the updated module logo.
- Change original module code and documentation licensing to MIT at the copyright owner's request; preserve historical release artifacts.
- Document source and isolated method checks across every released 8.0, 8.1 and 8.2 tag, keeping the supported installation scope at 8.2.x.
- Record the incompatible PrestaShop 9 cart method signature and distinguish source checks from full-shop tests.
- Allow the isolated regression runner to select an explicit core fixture version.

- Identify PrestaShop login issue #42963 and cart issue #31570 in the module description and introductory documentation.

## [1.0.0] - 2026-11-15

- Add a scoped PrestaShop 8.2 login-form override that rejects non-string credential types through native required-field validation.
- Add a cart-controller override that rejects malformed quantities and non-string tokens before core processing.
- Preserve native authentication, authorization, token validation, stock and pricing behavior.
- Add regression coverage for malformed inputs and unchanged core method contracts.

- Document deployment risks, private vulnerability reporting, dependency inventory and release verification limits.
