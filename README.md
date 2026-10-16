# MI Tech Wireless

PHP/MySQL prepaid-refill storefront with Stripe Payment Element, manual fulfillment, and an admin console. Production: https://mitechwireless.com. Admin: https://mitechwireless.com/admin.

This repository includes the current website source, compiled assets, pinned PHP dependencies, database installation scripts, carrier research, and browser checks. Private configuration, live databases, credentials, uploads, and local test artifacts are excluded. Node dependencies can be installed from the included lockfile.

## Files

`public/` contains customer pages, `admin/` management pages, `includes/` shared PHP services, `config/` the configuration example, `assets/` compiled CSS/JS/brand artwork, `sql/schema.sql` the full schema and starter catalog, `tools/` CLI operations, and `tests/` isolated QA checks. Root `index.php` is the Apache entry point.

## Requirements and installation

PHP 8.1+ with PDO MySQL, mbstring, OpenSSL, cURL, GD and fileinfo; MySQL 8-compatible InnoDB (compatible MariaDB is supported); Apache mod_rewrite and a valid TLS certificate. Dependencies are pinned in composer.lock: Stripe PHP SDK and PHPMailer. Node is needed only to rebuild CSS or run tests.

1. Back up the existing document root and databases. Create a **new, empty database** and dedicated database user. Never reuse the old OpenCart or Gemu database.
2. Create `/home/CPANEL_USER/mitechwireless-private` with mode 0700, beside the document root. Copy `config/example.php` there as `config.php`. Set database credentials, HTTPS base URL, `environment=production`, and reporting timezone. Generate the 64-hex-character `app_key` with `bin2hex(random_bytes(32))`. Preserve this key across deployments and backups; encrypted integration secrets depend on it. Set config permissions to 0600.
3. Run `composer install --no-dev --prefer-dist --optimize-autoloader` on PHP 8.1+, or upload the delivered locked vendor directory.
4. Install from the CLI with a private output path:

   ```sh
   MITECH_CONFIG=/home/CPANEL_USER/mitechwireless-private/config.php \
   MITECH_CREDENTIAL_OUTPUT=/home/CPANEL_USER/mitechwireless-private/admin-access.md \
   php /home/CPANEL_USER/mitechwireless.com/tools/install.php
   ```

   The installer refuses databases containing any tables. `schema.sql` already includes seed data; do not import it twice.
5. **Default admin email: info@mitechwireless.com.** A unique temporary password is generated at install time and printed into the private `admin-access.md` document. There is no shared universal password. Sign in at `/admin`; first login requires a password change. Never put that credentials document in the webroot or shared source archive.
6. In cPanel AutoSSL, cover both the apex and www domain. Upload source files as 0644, directories as 0755. Root `.htaccess` redirects HTTP to HTTPS, blocks private directories, disables directory listings and prevents executable image uploads. No document-root change is needed.
7. Run server `php -l`, then test home, carriers, tracking, admin login, a missing page (404), and private routes (403). Configure SMTP, Stripe and verified refill products before enabling checkout.

### Deployment-specific paths

- Document root: `/home/mancode/mitechwireless.com`
- New production database: `mancode_mitopup`
- Separate QA database: `mancode_mitopupqa`
- Private config/credentials: `/home/mancode/mitechwireless-private/`
- Owner’s local admin details: `C:\Users\FILE\mitechwireless-private\admin-access.md`

The old `mancode_mitech` database, `/opencart` folder, and Gemu systems are independent and unchanged.

## Stripe: test to live

### Request checkout and payment integration

The public site supports Simple Mobile, T-Mobile, Lyca Mobile, Ultra Mobile, H2O Wireless and AT&T. The storefront uses original carrier artwork and 63 researched US monthly packages, refill amounts, add-ons and conditional carrier offers. The visible flow is carrier → plan → contact details → payment → confirmation. There is no sample-card form or demo wording.

While a payment gateway is unavailable, Admin → Settings → **Accept recharge requests without online payment** keeps checkout open for contact collection. Requests appear in Admin → Checkout requests, can be found by reference/email on Track order, and remain **Awaiting payment**. The request handler does not charge a card or start fulfillment. The card form currently validates in the browser only. Its four inputs have no names or form owner; their values are never serialized, sent to the server, or written to browser storage. They are cleared before completion requests, when editing contacts and on page exit/return. Only name, email and phone are collected as contact fields; the request also retains the selected top-up and reference. The existing legacy phone columns hold the same number and new ZIP values are empty. Existing records are preserved.

The contact table keeps its legacy name `demo_submissions` to preserve existing records; no data migration or deletion is required. New references use `MI-RQ-`. Older references are retained. The active setting is `request_checkout_enabled` (the legacy toggle is only a fallback for older installs).

Integration points:

- `public/request-checkout.php` and `assets/request-checkout.js` render the contact/card/request UI. Replace the temporary browser-only card fields with provider-hosted fields when integrating payments; never forward these raw fields through the app server.
- `includes/requests.php` validates and stores contact details; completion is request submission, not payment confirmation.
- The existing `public/checkout.php`, `assets/checkout.js`, `includes/payments.php` and `/api/webhook` implement real Stripe Elements payments. Configure your credentials/webhook, verify fulfillment eligibility for each plan, disable request checkout and enable Stripe checkout to use them.
- Never mark a request paid from a button click or thank-you URL. Use a verified processor result and preserve card handling in the processor-hosted fields.

`sql/selected-carriers.sql` updates the selected catalog, hides other carriers and outdated plans, and preserves historical orders/contacts. It is safe to rerun without duplicating matching plan names. Existing installs may apply it through `tools/migrate-catalog.php`; back up before changes.

### Real payment setup

1. Open Admin → Settings. Keep Test mode initially. Enter your `pk_test_…`, `sk_test_…` and webhook signing secret. Saved secret values are never displayed; blank fields preserve them. Test and Live credentials are separate and encrypted at rest.
2. Register `https://mitechwireless.com/api/webhook` with Stripe. Subscribe to `payment_intent.succeeded`, `payment_intent.payment_failed`, `payment_intent.canceled`, `payment_intent.processing`, `charge.refunded`, `refund.created`, `refund.updated`, and `refund.failed`. Store the `whsec_…` secret in the matching Test or Live section. Canonical payment state is re-fetched through the SDK.
3. Verify a plan with your actual fulfillment provider: price, denomination, taxes, eligibility, refill route and your ability to fulfill it. Clear “Verify pricing” only for confirmed plans. Configure SMTP and then enable checkout.
4. Complete a test purchase using `4242 4242 4242 4242`, a future expiry, and a test CVC. Also exercise a declined card, retry and 3D Secure. Never perform a real recharge for a test order. Test orders are labeled and excluded from Live dashboard totals.
5. Confirm the signed webhook, payment status, customer receipt, admin alert, tracking, and completion email after marking Recharged. Payment confirmation is separate from recharge completion. A return-page URL cannot falsely mark an order paid. Webhooks handle buyers who never return to the site.
6. Enter your own Live account keys, create the Live endpoint and signing secret, then switch to Live when the business is ready. A temporary development sandbox is for QA only, not production ownership or long-term use.

Stripe Elements sends card details directly to Stripe; PAN/CVV are never sent to the application server. Prices are server-derived integer cents. Payment amount, currency, mode and order identity are checked. Retries reuse order-specific idempotency keys. Refunds require a separate admin action, current-password confirmation, and a Stripe-confirmed result. Fulfillment status alone cannot mark a payment refunded.

Sources: [Payment Intents](https://docs.stripe.com/payments/payment-intents), [webhooks](https://docs.stripe.com/webhooks), [test cards](https://docs.stripe.com/testing).

## Email and cron

Configure SMTP hostname, port, TLS/SSL, username and password in Settings. From/reply-to default to info@mitechwireless.com. A dedicated mailbox can authenticate notifications using the approved support From address when the host permits this; existing mailbox passwords are not reset.

Branded messages: payment receipt to the customer, new-paid-order alert to support, and recharge-completed email. A durable queue retries failed SMTP delivery every 15 minutes up to eight attempts. Admin → Email delivery shows attempts/errors and supports retry or immediate queue processing. Stable Message-IDs and unique order/message jobs prevent duplicate queue inserts. SMTP itself is not exactly-once: a crash after provider acceptance but before the database commit can cause a retry.

Install a cPanel cron every five minutes after confirming the PHP executable path:

```cron
*/5 * * * * MITECH_CONFIG=/home/mancode/mitechwireless-private/config.php /usr/local/bin/php /home/mancode/mitechwireless.com/tools/cron.php >> /home/mancode/mitechwireless-private/mail-cron.log 2>&1
```

The worker uses a database advisory lock and cleans expired rate-limit entries. Keep logs private and rotate them. SMTP acceptance does not prove inbox placement; check the receiving inbox and headers.

### SPF / DKIM / DMARC

Use cPanel → Email Deliverability to inspect the domain’s exact provider-recommended SPF and DKIM records. If DNS is hosted elsewhere, copy the actual values there. Do not invent a DKIM key or add a second SPF record; include all legitimate senders in one valid policy.

After confirming SPF or DKIM alignment, a domain owner can start DMARC monitoring with `v=DMARC1; p=none; rua=mailto:info@mitechwireless.com` at `_dmarc.mitechwireless.com`. Review reports before moving to quarantine/reject, and confirm all legitimate senders first. This app does not automatically change DNS policy or promise spam-free delivery.

[PHPMailer](https://github.com/PHPMailer/PHPMailer), [FTC small-business cybersecurity](https://www.ftc.gov/business-guidance/small-businesses/cybersecurity).

## Catalog and fulfillment

Only the six selected carriers are active publicly. Current product details and eligibility are in `research/expanded-catalog.json`; evidence is in `research/expanded-a-sources.md` and `research/expanded-b-sources.md`. The older seven-carrier research files are historical. Use `tools/build-expanded-catalog.py` to rebuild the current catalog; it preserves selected verified regular options from that earlier research. `research/seven-carrier-logos.json` records official artwork provenance and hashes. Product filters separate monthly plans, account credit, add-ons and promotions. Carrier-only offers link to their original provider; the server refuses their IDs in request checkout. Multi-month offers show the full upfront payment. Published carrier prices do not establish distributor access, tax treatment or account eligibility; real payment checkout still requires verified fulfillment products.

Older catalog rows remain inactive to preserve references and history. The original carrier artwork is used for identification without claiming affiliation or endorsement.

Orders preserve the carrier, plan, amount and customer details as purchased. Used carrier/plan records cannot be deleted; disable them to retain order history. Mark Recharged only after actual fulfillment. Internal notes are private. Tracking requires the random order ID and checkout email and is rate limited.

## Security and backups

Prepared PDO queries; escaped output; server-controlled prices; CSRF on state-changing forms; signed Stripe webhooks; password hashes and mandatory initial change; 30-minute admin inactivity timeout; five failed account logins per 15 minutes plus IP limits; secure HttpOnly/SameSite cookies; CSP; type-checked, re-encoded image uploads; CSV formula-injection protection. Errors avoid printing credentials or request bodies. No card PAN/CVV is stored.

Back up MySQL consistently and retain the private config/app key separately. Restoring the database without the app key loses access to encrypted credentials. The owner should confirm the operational policies, business identity, tax handling and carrier permissions before enabling sales.

## Build and tests

```sh
pnpm install
pnpm run css
node --check assets/site.js
node --check assets/checkout.js
```

Tailwind CSS is prebuilt; no CDN or Node server is required in production. Styles use a system-font stack. Logo lettering is vector paths, with transparent PNG variants and a font license notice in `assets/brand/`; the source raster is not embedded.

Use `tools/router.php` for loopback preview, a separate QA database and `MITECH_CONFIG`. Never run QA mutations against production. Screenshots/results are in `tests/artifacts/`. The first-login browser test expects a fresh QA install.

The current checkout/catalog checks are `tests/card-catalog.cjs` and `tests/catalog-encoding.cjs`. Set `MITECH_QA_ADMIN_PASSWORD` to the password of your isolated QA administrator before running the authenticated checks; no QA password is committed. The browser scripts currently use the Windows Chrome path and loopback preview address from the development environment. Older `selected-carriers.cjs` checks describe the previous carrier selection and are retained as historical test source.

## Rollback

Restore affected entry files from the dated backup and preserve new orders. Do not restore a stale database over paid orders. Disable checkout before investigating payment or fulfillment issues. The retained OpenCart folder and its database remain independent.
