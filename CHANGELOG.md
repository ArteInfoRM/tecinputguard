# Changelog

## [1.0.0] - 2026-11-15

- Add a scoped PrestaShop 8.2 login-form override that rejects non-string credential types through native required-field validation.
- Add a cart-controller override that rejects malformed quantities and non-string tokens before core processing.
- Preserve native authentication, authorization, token validation, stock and pricing behavior.
- Add regression coverage for malformed inputs and unchanged core method contracts.

- Document deployment risks, private vulnerability reporting, dependency inventory and release verification limits.
