# Bootstrap 5 interface

OSPOS uses Bootstrap 5.3.8 and Bootswatch 5.3.8. Bootstrap 3 and its JavaScript plugins are no longer loaded. jQuery remains in use for application requests, validation, tables, and autocomplete.

## Build and test

1. Install the locked dependencies: `composer install` and `npm ci`.
2. Run the UI regression tests: `npm run test:ui`.
3. Build both development and production assets: `npm run build`.
4. Run PHP tests against a separate test database: `composer test`. Without a coverage driver, use `composer test -- --no-coverage`.
5. Check the application in English, Sorani (`ckb`), and Arabic (`ar-EG` or `ar-LB`). Exercise a dialog save, a sale/return, table controls, configuration tabs, and a receipt.

Build assets before starting the application, or restart the PHP runtime after rebuilding if its opcode cache retains old generated view contents. Deploy matching generated views and assets together.

## Components

- Navigation, tabs, dialogs, tooltips, alerts, forms, cards, and switches use Bootstrap 5.
- Bootstrap Icons replace Glyphicons. The build copies icon fonts for both asset modes.
- Tom Select provides searchable and multiple selects, including barcode format tags. Add `search-select` to an enhanced select; use `data-live-search="true"` for searching and `data-placeholder` for its placeholder.
- Flatpickr replaces the old datetime picker. Its adapter preserves the application’s Moment date formats and translated calendar names. Calendar popups stay inside their owning modal.
- Date Range Picker retains localized report ranges and uses Bootstrap 5 button styles.
- File inputs use local preview/reset handling; no Jasny Bootstrap dependency is needed.
- `dialog_support` remains the application entry point for AJAX-loaded dialogs. Its implementation uses Bootstrap Modal.
- Notifications keep the existing sanitized `$.notify` API, rendered with Bootstrap alerts.

`OSPOS.init(root)` initializes controls after inserting a fragment. Call it once a dynamic form has loaded; existing enhanced controls are not duplicated.

## RTL and themes

The effective employee/store language determines the document direction and the matching `bootstrap.rtl.min.css` or `bootstrap.min.css` stylesheet. Login and the main interface use the same theme directory. Existing `paper` and `readable` selections fall back to `flatly`, since those Bootstrap 3 themes are unavailable in Bootswatch 5.

Application spacing uses logical CSS properties. Register panels stack below the desktop breakpoint, and wide item tables scroll within their panel. Visible monetary outputs are isolated where needed so signed amounts remain readable in RTL. Barcodes keep LTR direction.

This migration does not complete missing language translations or change the PDF engine. Browser receipts and generated PDFs need separate visual checks; thermal printer behavior depends on the device and driver.
