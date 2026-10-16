# MI Tech Wireless — USA carrier seed research

Research date: **October 15, 2026**. Destination: the new PHP store for **mitechwireless.com**. Currency: USD. Scope: bounded local research under the Sites skill; no hosting, deployment, account login, payment or carrier transaction was performed.

## Import and purchase controls

All **24 carriers** are present in brief order. There are **48 research entries across 17 carriers**, with **7 intentionally empty catalogs**. Every carrier and every entry has `verify_pricing: true`, `purchasable: false` and `active: false`. Nothing in this research authorizes checkout or proves distributor access.

These are data controls, not an implemented PHP checkout gate. The importing application must preserve them and reject payment creation while either the carrier or selected entry is inactive, unverified, or non-purchasable. Admin review must confirm the exact fulfilment product, current price/fees, eligible account/network, renewal conditions and service details before deliberately enabling a product. Turning on a carrier alone must not enable its entries.

## Reading the JSON

- `plans` is the requested container name; an item is not necessarily a service plan. Read `kind`, the name, description and carrier caveat together.
- `price_cents` is an integer USD face value, documented payment minimum, or clearly labeled published price reference. It is not a wholesale cost, resale price, guaranteed renewal charge, or final tax-inclusive checkout total.
- `refill_credit`, `account_credit` and `metered_credit` do not promise fixed data, talk, text or a month of service. `gift_card_value_reference` is a different product class; it must not silently become a mobile e-PIN.
- `plan_price_reference`, `first_month_price_reference` and `multi_month_price_reference` require matching the customer's actual product. Multi-month prices are full upfront payments, never monthly-equivalent denominations.
- `null` means unverified, unassigned, or account-dependent. It does not mean zero, unlimited, or non-expiring. Do not replace null validity with 30 days.
- Where populated, `validity_basis` distinguishes a service cycle from credit expiration. H2O/Page Plus credit lifetime is not a promise of continuous service for that many days.
- Colors are editable, approximate UI accents selected for identification. They are not verified official brand specifications, logos or approval to use trademarks.

## Evidence standard and limits

Primary carrier pages, official carrier-controlled support/rewards pages and the FCC were used. The browser's indexed extract was used where direct rendering was empty, JavaScript-dependent or blocked; these cases are identified below and in `source_evidence`. A crawl date is not an effective date or proof of a currently purchasable SKU. No checkout was submitted and no user account was inspected.

Promotions, referral credits, device subsidies, AutoPay discounts and historical plans were not converted into ordinary refill amounts. Unsupported catalogs remain empty instead of being filled with customary but unsourced dollar amounts. The subset is intentionally not an exhaustive carrier plan catalog.

## Carrier summary

| Carrier | Seeded USD values | Classification |
| --- | --- | --- |
| Verizon | $25.00, $50.00, $75.00, $100.00 | gift card funding reference |
| AT&T | $10.00 | account payment reference |
| T-Mobile | $15.00, $25.00, $35.00 | prepaid plan reference |
| Cricket Wireless | $10.00, $25.00, $35.00, $40.00, $50.00, $60.00 | refill card |
| Metro by T-Mobile | None — plans: [] | account bill payment |
| Boost Mobile | $30.00 | prepaid plan reference |
| Straight Talk | $35.00, $45.00, $55.00, $65.00 | prepaid plan reference |
| Tracfone | $50.00 | prepaid plan reference |
| Total Wireless | $40.00, $55.00, $65.00 | prepaid plan reference |
| Simple Mobile | None — plans: [] | unverified prepaid catalog |
| H2O Wireless | $10.00, $30.00, $100.00 | pay as you go credit |
| Lyca Mobile | $10.00, $20.00, $50.00, $100.00 | account credit |
| Ultra Mobile | $10.00, $15.00, $50.00 | paygo specific refill card |
| Mint Mobile | $75.00, $120.00, $180.00 | multi month account renewal |
| Visible | None — plans: [] | account subscription |
| Net10 | None — plans: [] | legacy migration unverified |
| Page Plus | $10.00, $25.00, $50.00, $80.00 | legacy payg refill |
| Red Pocket | $10.00, $20.00, $30.00 | prepaid plan reference |
| Tello | $20.00 | account payg credit |
| US Mobile | None — plans: [] | account plan and usage topups |
| Good2Go | $60.00 | multi month account plan |
| Consumer Cellular | None — plans: [] | postpaid account billing |
| Walmart Family Mobile | $19.88, $24.88, $34.88 | prepaid plan reference |
| Life Wireless | None — plans: [] | lifeline restricted service |

## Sources and decisions by carrier

### 1. Verizon

Primary: [Verizon official evidence](https://www.verizon.com/support/gift-card-faqs/).

The cited $25/$50/$75/$100 products are Verizon gift cards usable toward prepaid service, not verified prepaid e-PIN SKUs or instant phone-number refills. Confirm distributor product, redemption route, account eligibility and taxes. Gift-card life is not a service term.

Evidence handling: `official_page_or_indexed_extract`.

- [Prepaid billing and refill-card support](https://www.verizon.com/support/prepaid-billing-payment-faqs/) — Confirms separate prepaid refill cards and account-dependent expiration. Gift-card denominations must not be relabeled as these SKUs.

### 2. AT&T

Primary: [AT&T official evidence](https://www.att.com/support/article-modal/wireless/KM1008656/).

Only the documented $10 minimum online debit/credit-card payment is seeded. This is not evidence of a $10 service plan or a transferable refill PIN. Confirm the customer's Prepaid account, amount due, taxes and authorised fulfilment; general AT&T retail gift cards must not be assumed to work as refill cards.

Evidence handling: `official_page_or_indexed_extract`.

- [Gift-of-wireless support](https://www.att.com/support/article/wireless/KM1001041/article.html) — Lists retail gift-card values, but the seed deliberately uses only the clearly documented Prepaid payment minimum to avoid confusing retail gift cards with service refills.

### 3. T-Mobile

Primary: [T-Mobile official evidence](https://prepaid.t-mobile.com/connect/phone-plans).

Connect prices are account-specific service references, not universal T-Mobile refill-card denominations. Verify the line is on the matching Connect plan. Taxes and fees are additional. Data stops at the allowance unless an eligible pass or plan change is purchased.

Evidence handling: `official_page_or_indexed_extract`.

- [Connect plan overview](https://prepaid.t-mobile.com/connect?hl=en-US) — Confirms the 30-day renewal context and hard data caps.

### 4. Cricket Wireless

Primary: [Cricket Wireless official evidence](https://www.cricketwireless.com/support/billing-and-payments/cricket-refill-cards).

Refill cards add account credit; the value does not select a plan or guarantee a month of service. The carrier states cards are redeemable for 12 months after purchase; that is not 365 days of phone service. Verify the account's balance due and fulfilment route.

Evidence handling: `official_page_or_indexed_extract`.

### 5. Metro by T-Mobile

Primary: [Metro by T-Mobile official evidence](https://www.metrobyt-mobile.com/guestpay/landing).

Official guest payment requires a Metro number before showing account payment details. No generic refill denomination was verified. Promotional activation and AutoPay rates are not safe substitutes for the customer's renewal amount. Keep plans empty until an authorised bill-payment route and amount are confirmed.

Evidence handling: `official_guest_payment_page; no_denominations_verified`.

- [Payment support](https://www.metrobyt-mobile.com/support/account/payments) — Account billing route, not a verified denomination list.

### 6. Boost Mobile

Primary: [Boost Mobile official evidence](https://www.boostmobile.com/plans/affordable-phone-plan).

The advertised $25 rate includes a $5 AutoPay discount; the carrier states $30 when AutoPay is off. New-customer $10 promotions are excluded. Confirm prepaid versus other Boost account types, renewal eligibility, taxes and supported payment channel. No transferable $30 card SKU is established.

Evidence handling: `official_page_or_indexed_extract`.

- [Boost payment/account terms](https://help.boostmobile.com/docs/general-terms-conditions) — Account types and payment application need matching; an advertised plan does not establish a reseller SKU.

### 7. Straight Talk

Primary: [Straight Talk official evidence](https://www.straighttalk.com/).

Use regular single-line prices only; AutoPay, switcher, multiline and device promotions are excluded. Confirm the exact service-plan SKU, network and current benefits before sale. These references do not prove MI Tech Wireless can fulfil a refill.

Evidence handling: `official_page_or_indexed_extract`.

### 8. Tracfone

Primary: [Tracfone official evidence](https://www.tracfone.com/plans/tracfone-freedom-30-days).

The cited Freedom offer states a $50 regular price and a $45 Auto-Refill price. Temporary new-line discounts are excluded. Legacy basic-phone, smartphone and annual products are not interchangeable; verify the active line and exact refill SKU.

Evidence handling: `official_page_or_indexed_extract`.

### 9. Total Wireless

Primary: [Total Wireless official evidence](https://www.totalwireless.com/m/plans/smartphone).

Current pages use STARTER, MAX 5G and ALL ACCESS names. Do not reuse older Total by Verizon or Base/Total 5G prices automatically. STARTER and MAX 5G standard prices are shown in Broadband Facts; ALL ACCESS is retained only as a stated first-month amount. AutoPay and BYO discounts are excluded.

Evidence handling: `official_page_or_indexed_extract`.

- [ALL ACCESS first-month price](https://www.totalwireless.com/buy/smartphones/google-pixel-10a-prepaid) — Explicitly shows $65 first month, then $60 with AutoPay. The seed labels $65 as first-month reference only.
- [STARTER and MAX 5G Broadband Facts](https://akamai.totalwireless.com/m/plans) — Indexed carrier labels show $40 and $55 non-introductory monthly prices.

### 10. Simple Mobile

Primary: [Simple Mobile official evidence](https://support.simplemobile.com/expresshelp/services/).

Official support describes refilling, but the current plan storefront could not be reliably retrieved. A 2025 parent-company announcement and legacy pages show different plan generations. No amounts are seeded from those older offers. Verify current network, product SKU and renewal price before adding plans.

Evidence handling: `official_support_indexed; storefront_unavailable`.

- [Verizon's August 2025 Simple/Total announcement](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless) — Historical official evidence of $30/$40/$50/$60 Simple products; insufficient by itself to certify the October 2026 catalog.
- [Simple Rewards status](https://rewards.simplemobile.com/home/about) — The current notice schedules rewards-program sunset for November 18, 2026 and says the Simple service plan is unaffected. A rewards closure must not be reported as carrier service closure.

### 11. H2O Wireless

Primary: [H2O Wireless official evidence](https://www.h2owireless.com/plan/minute).

These values are PAYG credit, not monthly unlimited plans. Domestic talk/text are charged at 5 cents per minute/message and data at 10 cents per MB. Validity describes balance expiration: 90 days for $10/$30 and 365 days for $100. Verify current rates, account type and recharge timing.

Evidence handling: `official_page_or_indexed_extract`.

### 12. Lyca Mobile

Primary: [Lyca Mobile official evidence](https://www.lycamobile.us/en/quick-top-up/?others=1).

Official Quick Top Up separates credit from 30-day bundles. These values are credit only; do not attach the displayed bundle allowances to them. The page shows a 5% regulatory recovery fee, so face value is not necessarily the final payable total. Verify number, current fees and credit expiry.

Evidence handling: `official_indexed_top_up_form; live_form_not_fully_rendered`.

### 13. Ultra Mobile

Primary: [Ultra Mobile official evidence](https://www.ultramobile.com/paygo/).

Only PayGo-specific cards can recharge Ultra PayGo; ordinary Ultra recharge cards are not interchangeable. The $10/$15/$50 card values do not themselves buy a fixed service period or the advertised $3 monthly bundle. Confirm PayGo account and distributor SKU.

Evidence handling: `official_page_or_indexed_extract`.

### 14. Mint Mobile

Primary: [Mint Mobile official evidence](https://www.mintmobile.com/phone-plans/12-month-plans/?selected=MINT-SMALL-12).

Mint renewals require full upfront payment; advertised monthly equivalents are not refill denominations. The selected 6GB page lists $75/$120/$180 for 3/6/12-month renewal. Account renewal options must be confirmed; annual cycles can differ for legacy accounts. No phone-number-only third-party refill route was verified.

Evidence handling: `official_page_or_indexed_extract`.

- [Plan terms](https://www.mintmobile.com/plan-terms-and-conditions/) — Three/six-month plans use 30-day monthly cycles. Annual cycles can be 30/31 days; no universal annual day count is assigned.
- [Data reset rules](https://www.mintmobile.com/help/how-do-i-know-when-my-data-resets/) — Mentions legacy 360-day annual plans, which is why annual validity is null.

### 15. Visible

Primary: [Visible official evidence](https://www.visible.com/m/help/your-account/billing-payments).

Visible accepts new subscribers, but its official payment workflow uses the member's logged-in account and saved payment methods. No conventional carrier refill PIN or generic reseller denomination was verified. Acceptance of prepaid bank cards is not evidence of Visible-branded refill cards. Keep checkout unavailable.

Evidence handling: `official_page_or_indexed_extract`.

### 16. Net10

Primary: [Net10 official evidence](https://net10.augeocms.com/home/about).

Official Net10 Rewards material retired that program in 2024 and directs customers toward Simple Mobile. Current new-customer activation and refill availability could not be verified from accessible primary sources; the main site returned HTTP 403. Treat as legacy/migration only, block new activations and all sales, and confirm the customer's actual carrier. Rewards closure alone does not prove service termination.

Evidence handling: `official_rewards_notice_indexed; main_site_403; activation_status_unverified`.

- [Net10 support](https://support.net10wireless.com/en/) — Still exposes support material. Neither that nor the rewards transition alone establishes current activation eligibility.

### 17. Page Plus

Primary: [Page Plus official evidence](https://www.pagepluscellular.com/refill/).

The official indexed refill table lists $10/$25/$50/$80 Standard PINs, but direct access reached an unsupported-browser page. Revalidate current SKU availability and new-customer activation separately. The first three expire after 120 days; $80 is one year on Standard PAYG but 120 days as monthly-plan cash, so its validity is left null.

Evidence handling: `official_indexed_refill_table; direct_browser_gate`.

### 18. Red Pocket

Primary: [Red Pocket official evidence](https://www.redpocket.com/refer).

Current official comparison lists $10 Essentials, $20 Plus and $30 Unlimited Premium. Network, account and plan generation matter. Exclude first-month, referral and annual discounts from refill pricing. Do not treat a monthly price as proof of a generic PIN product.

Evidence handling: `official_page_or_indexed_extract`.

- [Current plan comparison](https://www.redpocket.com/plans) — Corroborates 3GB/20GB/50GB high-speed allowances. Account/network eligibility and reduced-speed rules need revalidation.

### 19. Tello

Primary: [Tello official evidence](https://tello.com/help_center/new-to-tello/how-does-pay-as-you-go-work).

Official website PAYG initial/manual refill minimum is $20. This is separate from monthly plans and is not a transferable refill-card SKU. Credit stays valid with an active plan but expires after three months without one; no universal validity is assigned. Third-party fulfilment remains unverified.

Evidence handling: `official_page_or_indexed_extract`.

- [PAYG without a plan](https://tello.com/help_center/pay-as-you-go/can-i-use-pay-as-you-go-without-a-plan) — Supports the distinction between active-plan credit and 90-day credit without a plan; validity is kept null because the account controls the rule.

### 20. US Mobile

Primary: [US Mobile official evidence](https://www.usmobile.com/plans).

US Mobile offers new service and account-specific top-ups, but no generic cash refill denomination or authorised third-party phone-number-only fulfilment was verified. By-the-Gig data add-ons and annual promotional monthly equivalents are not universal refill products. Keep plans empty pending integration and account checks.

Evidence handling: `official_page_or_indexed_extract`.

### 21. Good2Go

Primary: [Good2Go official evidence](https://annualplans.good2gomobile.com/home-page).

The official annual page lists $60 paid upfront for 12 months with 1GB per month. This is not a $5 standalone monthly refill or generic $60 account-credit card. The main dynamic plan grid did not expose pricing in this research; confirm the annual offer, existing-customer renewal and actual service dates before sale.

Evidence handling: `official_page_or_indexed_extract`.

- [Main plan grid](https://www.good2gomobile.com/shop/plans) — Returned no readable plan rows. The seed therefore includes only the separately published full annual payment and does not derive a standalone $5 refill.

### 22. Consumer Cellular

Primary: [Consumer Cellular official evidence](https://www.consumercellular.com/api/assets/custom-content/emails/welcome-kit-booklet-2024.pdf).

The official welcome guide describes billing in arrears for the preceding billing cycle. No prepaid refill-card product was verified. This is a conventional account bill, not a refill denomination catalog. New-customer service remains distinct from unsupported reseller refill fulfilment; seed no plans.

Evidence handling: `official_2024_welcome_guide; no_refill_product_verified`.

- [Account and billing portal](https://www.consumercellular.com/help/billing) — Dynamic page did not expose substantive content; the dated official welcome guide is the cited evidence for the billing model.

### 23. Walmart Family Mobile

Primary: [Walmart Family Mobile official evidence](https://support.myfamilymobile.com/en/topics/plans-and-services/all/).

Official support introduces $19.88/4GB and $34.88/20GB, and upgrades $24.88 to 8GB. It retires $29.88/$39.88 for new selection while allowing existing users to remain. Do not confuse the $19.88 add-a-line rate with the standalone 4GB plan. Verify network, renewal term and SKU.

Evidence handling: `official_indexed_support_faq; direct_page_did_not_render`.

### 24. Life Wireless

Primary: [Life Wireless official evidence](https://lifewireless.com/tac).

Lifeline requires eligibility and is distinct from ACP. ACP ended June 1, 2024; do not advertise ACP enrollment or benefits. Life Wireless says top-up availability, rates and allowances vary by state. Published $5/$10 international credits are restricted add-ons, not general domestic refill plans. No universal refill product is seeded.

Evidence handling: `official_terms_indexed; direct_terms_403; FCC_ACP_confirmation`.

- [International calling add-ons](https://lifewireless.com/international-calling) — Publishes $5/$10 international talk credits. These are excluded from a general domestic refill catalog; the page's rollover wording also needs account-level clarification.
- [FCC ACP consumer advisory](https://consumercomplaints.fcc.gov/hc/en-us/articles/32636130998420-CONSUMER-ADVISORY-FEDERAL-COMMUNICATIONS-COMMISSION-WARNS-CONSUMERS-ABOUT-WEBSITES-ADVERTISING-THE-AFFORDABLE-CONNECTIVITY-PROGRAM) — Confirms ACP ended June 1, 2024 and cautions that some provider pages remain outdated.
- [Stale Life Wireless ACP page](https://lifewireless.com/save-acp) — Still discusses impending spring 2024 funding exhaustion; rejected as evidence of a current benefit.

## Availability and retirement distinctions

- **Net10:** retained as legacy/migration only. The primary evidence confirms the 2024 rewards retirement and a path toward Simple Mobile. A definitive current official new-customer closure notice was not accessible, so this file does not invent a closure date or claim that all existing service has ended. New activations and all sales remain blocked pending direct carrier confirmation.
- **Page Plus:** the official indexed Standard PIN table is evidence of denominations, not proof that a new activation can be completed today. Direct storefront access was browser-gated. No blanket service-closure claim is made.
- **Visible, Consumer Cellular and US Mobile:** absence of entries means that a conventional reseller refill product was not verified. It does not mean these carriers have stopped accepting subscribers.
- **Mint and Good2Go:** retained price references are multi-month account products. They cannot be sold as arbitrary cash refills or monthly equivalents without a verified fulfilment method.
- **Life Wireless:** Lifeline eligibility and state-specific top-ups remain separate from ACP. No ACP enrollment or subsidy may be advertised from the stale page. No general domestic refill is seeded.
- **Walmart Family Mobile:** $29.88/$39.88 are not seeded as current open-selection offers; the carrier says existing customers may retain them.
- **Simple Mobile:** the announced November 2026 rewards sunset does not mean the service or new-customer enrollment has ended.

## Local validation and handoff

Local validation passed: 24 unique carrier slugs in exact brief order, 48 entries, 7 empty catalogs, required fields present, positive integer cent amounts, nullable service fields, HTTPS source URLs, valid hex colors, UTF-8 without BOM, and disabled/unverified state at both levels. Further product or pricing approval requires account/distributor verification; this research is not that approval.

Only these output files are written by this task:

1. `C:\xampp\htdocs\gemu_live\mitechwireless-build\research\carriers.json`
2. `C:\xampp\htdocs\gemu_live\mitechwireless-build\research\carrier-sources.md`
