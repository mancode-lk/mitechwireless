# Selected-carrier monthly phone-plan research

Checked: **2026-10-15**. Final scope, in order: **Simple Mobile, T-Mobile, Lyca Mobile, Ultra Mobile, H2O Wireless, Verizon**. The two seven-carrier filenames are retained as internal filenames.

## Scope and field meanings

- **18 records across exactly six carriers:** Simple Mobile 2; T-Mobile 3; Lyca Mobile 3; Ultra Mobile 3; H2O Wireless 4; Verizon 3.
- **16 packages have current plan-page and/or broadband-label support. The two Simple Mobile records retain the strongest accessible official evidence, with purchase verification unresolved.** Final handoff preserves these limitations explicitly rather than withholding the catalog.
- `price_cents` is the regular USD base service price before AutoPay, loyalty, multi-line, introductory or multi-month discounts, with the Simple Mobile evidence limitation noted above. Fees/taxes are excluded unless expressly included.
- `validity_days: 30` means a 30-day service cycle. `0` means calendar-month billing, not zero service days; only Verizon uses 0 in this file.
- Each selected package combines phone data with unlimited domestic voice and text. International benefits and limits are summarized only where useful. Plan names are concise carrier-derived display names.
- Sources are official carrier pages and carrier-linked labels. Indexed text and retrieval failures are disclosed. Research does not establish reseller eligibility or perform a purchase.
- Research only: no app, database, fulfilment or hosting changes.

## Simple Mobile — 2 published references; purchasability unresolved

| Published reference | Base face value | Data / voice / text | Cycle |
| --- | ---: | --- | --- |
| Unlimited World | $50 | Unlimited data, talk and text | 30 days |
| Unlimited World+ | $60 | Unlimited data, talk and text; 5G Ultra Wideband | 30 days |

- [Official smartphone-plan page](https://www.simplemobile.com/serviceplan?deviceType=smartphone) and [official shop page](https://www.simplemobile.com/shop): indexed official text still names the $50/$60 Unlimited World plans, links a Shop plan purchase path, and states congestion/network/device conditions. The shop page markets the range from $50/month.
- [Verizon's official announcement](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless), dated **2025-08-20**, corroborates names, prices and unlimited data/talk/text. It is historical corroboration, not proof of current purchasability.
- [Official extras terms](https://dsweb.simplemobile.com/extras) define a month as 30 days. [Current support FAQ](https://support.simplemobile.com/en/brands/General/SMaccounthelp/faq/2846426/) also describes a 30-day cycle.
- Follow-up verification tried the carrier's [Broadband Facts page](https://www.simplemobile.com/broadbandfacts), [Target-channel labels](https://www.simplemobile.com/nationalretailer/target), [Best Buy-channel labels](https://www.simplemobile.com/nationalretailer/bestbuy), and [legacy purchase URL](https://www.simplemobile.com/wps/portal/home/shop/serviceplans?lang=en), reached from the official extras-page Plans link. These were inaccessible or returned only an empty application shell. Direct HTTP checks of the current storefront and Target-channel label page returned **403**. The browser surface was unavailable on the follow-up; the prior browser attempt had been blocked.
- **Current purchasability is not independently verified.** The JSON retains two explicitly flagged references supported by the official shop text and carrier announcement. No successful plan selection, cart evidence or readable current carrier label was obtained.
- No hotspot quantity is asserted. Tax/fee treatment remains unverified. No AutoPay reduction is applied to the published face values. Verizon-network activation is required for expanded 200+ destination calling; Ultra Wideband requires compatible hardware/coverage.
- Retailer snippets were used only to locate carrier-owned label URLs; retailer prices, hotspot quantities and label images were not used as evidence.
- Excluded: lower-priced products supported only by the 2025 announcement; the old cloud page's expired 2020 promotion; and Simple Rewards terms containing another carrier's service text.
- Before customer-facing publication, obtain a readable current carrier label or purchase-page evidence for each of these two references.

## T-Mobile — 3 packages

| Selected plan | Regular base price | High-speed data | Cycle |
| --- | ---: | --- | --- |
| Connect 5GB | $15 | 5GB | 30 days |
| Connect 8GB | $25 | 8GB | 30 days |
| Connect 12GB | $35 | 12GB | 30 days |

- [Connect plan page and embedded Broadband Facts](https://prepaid.t-mobile.com/connect/phone-plans): confirms all three prices, unlimited talk/text, data caps, tethering from the same allowance, and 30-day cycles. Labels identify non-introductory prices; no AutoPay discount.
- [Connect overview](https://prepaid.t-mobile.com/connect?hl=en-US): states Connect can be slower than other T-Mobile service during congestion.
- Eligibility: new and existing customers; compatible device. Domestic service; data stops at the cap. Phone/tablet data is prioritized above tethering.
- Taxes/fees are additional. Labels show $0 online and $10/line in-store activation/change; general terms also mention a device connection charge. Confirm the actual activation channel charge.
- Do not apply the nearby unlimited-plan 50GB prioritization footnote to these capped Connect plans.

## Lyca Mobile — 3 packages

| Selected single-month plan | Regular base price | Phone data | Published hotspot | Cycle |
| --- | ---: | --- | --- | --- |
| $19 Unlimited International | $19 | 5GB, then slower data | Supported; separate GB quota not stated | 30 days |
| $23 Unlimited International | $23 | 8GB, then slower data | 8GB | 30 days |
| $29 Unlimited International | $29 | 15GB, then slower data | 10GB | 30 days |

- [Current plan catalog](https://www.lycamobile.us/en/plans/best-prepaid-phone-plans/), [$19 product](https://www.lycamobile.us/en/plan/19-international-plan-2/), [$23 product](https://www.lycamobile.us/en/plan/23-unlimited-international-plan/), and [$29 product](https://www.lycamobile.us/en/plan/29-unlimited-international-plan/): official lycamobile.us sources; product pages expose Buy now / Add to basket and the 30-day terms. No purchase was made.
- [Official renewal/top-up page](https://www.lycamobile.us/en/quick-top-up/?others=1): indexed carrier content lists 5GB/$19, 8GB/$23 and 15GB/$29 as 30-day packages, separately from cash-credit top-ups. Direct extraction of this dynamic page omitted the plan cards, so regular prices were also checked against each product's linked Broadband Facts.
- **Broadband-label verification:** the Broadband Facts link on each lycamobile.us product page opens a carrier-hosted PDF on its linked asset CDN. The $19 label states $10 introductory pricing for 12 months, then $19; the $23 label states $15 introductory pricing for one month, then $23; the $29 label states $29 is non-introductory. JSON uses **1900, 2300 and 2900 cents**, without AutoPay discounts.
- Official linked labels: [$19 / 5GB](https://cms-assets.ldsvcplatform.com/USA/s3fs-public/2025-09/19InternationalPlan.pdf?VersionId=kAuOl4ZiK0Yy0ZL72B8UwIpYV4NAZAKJ), [$23 / 8GB](https://cms-assets.ldsvcplatform.com/USA/s3fs-public/2025-09/23_Unlimited_Internation_Plan_30_day_26_june_2025.pdf?VersionId=m73zJTZt9BX.Y0kU4aGDV7A2kqg19wHN), [$29 / 15GB](https://cms-assets.ldsvcplatform.com/USA/s3fs-public/2025-09/29-Unlimited-International-Plan-30-Days-CA%201.pdf?VersionId=ZcWuNJpSkItXRiAJ3hrLbwAjRb0xhQ5Z). These are carrier-linked documents, not third-party plan comparisons; JSON source URLs remain on lycamobile.us.
- Promotional pricing requires continued auto-renewal; the $19 offer also explicitly requires a new online line. The promotion length is not plan validity: service renews in 30-day increments, not through an annual prepaid purchase. No auto-renewal requirement is stated for the quoted regular prices; the $29 label lists no discount bundle.
- Product terms assess a **5% regulatory recovery fee on website purchases, including auto-recharges**. It is excluded from price_cents. Label fees $0.50/$0.75 apply to the $10/$15 introductory prices; they must not be carried over as the regular-price fee. The $29 label's $1.45 fee agrees with 5%. Other taxes are not independently itemized here; the actual checkout total must govern.
- Unlimited refers to voice/text, including supported international destinations, not unlimited high-speed phone data. All three include unlimited nationwide talk/text; international calling is restricted to the first ten dialed numbers per country and excludes specified destinations/prefixes.
- Data slows after the stated allowance; no exact post-cap speed is promised. Congestion may reduce speeds. Compatible unlocked GSM 4G/5G device required; no domestic off-network roaming is promised.
- The $23/$29 hotspot quotas are explicit product-page values. They are not added to phone data. No numeric hotspot quota was invented for the $19 plan.
- Long-term 3/6/12-month products, data-only products and promotional headline prices are excluded.

## Ultra Mobile — 3 packages

| Selected plan | Regular one-month price | Data | Cycle |
| --- | ---: | --- | --- |
| 4GB | $19 | 4GB | 30 days |
| 12GB | $29 | 12GB | 30 days |
| 24GB | $39 | 24GB | 30 days |

- [Plans overview](https://www.ultramobile.com/plans/): one-month product prices, unlimited domestic voice/text and hotspot inclusion.
- [4GB, one-month product](https://www.ultramobile.com/product/4gb-prepaid-plan/?attribute_months=1-month-plan) and [24GB, one-month product](https://www.ultramobile.com/product/24gb-prepaid-plan/?attribute_months=1-month-plan): explicit one-month totals, current data allowances, taxes/fees and 30-day FAQ.
- [Official Broadband Facts CSV](https://broadband-labels.ultramobile.com/labels.csv): linked from the product pages; downloaded into memory and parsed without saving another file. The web extractor did not support CSV. Verified `4GB | 1 Month` ($19), `12GB | 1 Month` ($29), and `24GB | 1 Month` ($39); `intro_rate=NO`. Label-ID stems: `M0021822333007001120`, `M0021822333007001129`, `M0021822333007001134`.
- [Network management](https://www.ultramobile.com/network-management-policy/) and [plan terms](https://www.ultramobile.com/mobile-plans-terms-conditions/): congestion and possible 2G reduction/data suspension after the high-speed allotment. A precise guaranteed post-cap speed is not promised. The [official hotspot FAQ](https://www.ultramobile.com/mobile-hotspot/) confirms hotspot draws from the monthly data allowance.
- Overview embedded content contains stale 3GB wording within the current 4GB product; product page and label corroborate 4GB. The 12GB product URL returned 403, so its price/data use the overview plus CSV.
- Unlimited was omitted because old overview/CSV text and newer product/network-policy text disagree about its data threshold. Multi-month promotional rates are excluded.

## H2O Wireless — 4 packages

| Selected plan | Regular base price | High-speed threshold | Hotspot |
| --- | ---: | --- | --- |
| $20 Monthly 10GB | $20 | 10GB | 2GB |
| $30 Monthly Unlimited | $30 | 30GB | 5GB |
| $40 Monthly Unlimited | $40 | 40GB | 10GB |
| Unlimited XL $60 Monthly | $60 | 60GB | 20GB |

- [One-month plan cards and Broadband Facts](https://www.h2owireless.com/plan/monthly): prices, allowances, hotspot and unlimited voice/text. Use the **1 MO** selection. The page also contains discounted 3/6/12-month products, which are excluded.
- [Current terms](https://www.h2owireless.com/terms-conditions): September 2026 terms specify 30-day cycles and post-allowance speeds up to 256Kbps.
- [Open Internet disclosure](https://www.h2owireless.com/openinternet): congestion-based deprioritization can affect unlimited plans. Direct open returned 403; the official search-indexed text was readable.
- Labels for the selected tiers disclose federal USF / administrative-regulatory recovery charges respectively: $0.17/$1.50, $0.24/$1.75, $0.32/$2.00 and $0.48/$2.50, plus government taxes varying by location. These charges are **not added to price_cents**.
- Label identifiers for $20/$30 include `M0020735312H2OPLNW2020260831` and `M0020735312H2OPLNW3020260831`.
- The 10% AutoPay discount is excluded. Hotspot is recorded as the published allowance, without assuming it is additional to the phone-data pool or promising post-cap hotspot service.

## Verizon — 3 packages

| Selected plan | Regular base price | Data / hotspot | Cycle |
| --- | ---: | --- | --- |
| Prepaid 15GB | $45 | 15GB shared with hotspot, then 2G | Calendar month |
| Prepaid Unlimited | $60 | Unlimited; 5GB hotspot, then 600Kbps | Calendar month |
| Prepaid Unlimited Plus | $70 | Unlimited; 50GB premium 5G/LTE; 25GB hotspot | Calendar month |

- [Current prepaid plans, detailed sections](https://www.verizon.com/plans/prepaid/): explicit $45/$60/$70 base rates, unlimited talk/text, data priority, hotspot, taxes and discount conditions. The detailed plan sections were used instead of prominent discounted headings or multi-line text.
- [Prepaid customer terms](https://www.verizon.com/support/prepaid-customer-info-legal/): monthly plans renew on the same day each month.
- Excludes $10 Auto Pay reductions after month one and tenure-based loyalty reductions ($5 after three months; another $5 after nine). They do not stack. Additional taxes/fees may apply.
- Unlimited Plus: congestion-based lower priority after 50GB on 5G/4G LTE; hotspot after 25GB is up to 3Mbps on Ultra Wideband or 600Kbps on 5G/4G LTE. Ultra Wideband requires compatible hardware/coverage.
- Talk & Text, data-only, multi-line and conditional promotional offers were excluded.

## Validation and changed files

Validated six unique slugs in the requested order, 18 records, required plan fields, integer positive cent prices, HTTPS source URLs and only 30/0 validity values. The JSON contains no AT&T or Cricket carrier. Simple Mobile's two records explicitly retain unresolved purchase/hotspot/tax caveats. UTF-8 without BOM.

Only these files were updated:

- `research/seven-carrier-plans.json`
- `research/seven-carrier-sources.md`

Existing `research/carriers.json`, `research/carrier-sources.md`, app code and live hosting were not changed.
