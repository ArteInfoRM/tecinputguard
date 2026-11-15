# Security evidence

Tecnoacquisti.com® maintains an internal dependency inventory, CycloneDX SBOM, risk assessment and verification record for tecinputguard 1.0.1. The module introduces two narrowly scoped overrides and no database tables, configuration values, remote services, bundled third-party libraries or public module endpoints.

The compatibility scope remains PrestaShop 8.2.x. See README.md for tested environments and installation/recovery instructions; SECURITY.md for private reporting; and THIRD-PARTY-NOTICES.md for host dependencies and licensing.

The risk review covers malformed inputs, authentication and cart integrity, override conflicts, activation/removal behavior and shared overrides in multishop. A product-security regulatory classification, applicable conformity procedure and a defined support period remain owner review items. This document is not a CRA declaration of conformity or a certification.

Source-mounted tests are not ZIP installation tests. Installation/upgrade from the final ZIP and the official PrestaShop Validator remain manual controls for the project owner and have not been reported as completed. Production behavior, all patch/PHP combinations and multishop lifecycle are not certified by the existing tests.

## Version 1.0.1 license and compatibility review

Version 1.0.1 uses MIT for original module code, by explicit copyright-owner instruction. Historical release manifests and SBOMs remain unchanged. The 1.0.1 internal SBOM records MIT; historical release evidence remains unchanged. The review checks every official 8.0.0–8.0.5, 8.1.0–8.1.7 and 8.2.0–8.2.9 tag, with 76 isolated assertions per tag; only the existing 8.2.x installation scope is supported. See README.md for runtime evidence and the incompatible 9.x cart signature.
