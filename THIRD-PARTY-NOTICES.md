# Third-party notices

No third-party runtime libraries or copied core implementations are bundled with this module. The guards are original code distributed under AFL-3.0.

PrestaShop provides the parent classes, module lifecycle, request processing, authentication, authorization and rendering infrastructure. It is an external runtime dependency, distributed separately under its own licenses. Tests use externally supplied unmodified PrestaShop core source fixtures, which are not included in this module or a release archive.

The design addresses behavior documented by PrestaShop issues #42963 and #31570 and their associated pull requests. Links and design differences are recorded in README.md. No Composer/npm dependencies, CDN assets or remote services are used by the module.
