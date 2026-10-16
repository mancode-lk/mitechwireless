# Expanded prepaid research — Simple Mobile, T-Mobile, AT&T

Checked **2026-10-15**. Research only. Output: `expanded-a.json` and this file. No application, database, asset, account, payment or hosting changes.

## Scope and interpretation

The JSON contains **26 options: Simple Mobile 6, T-Mobile 10, AT&T 10**. AT&T replaces Verizon as a catalog carrier; Verizon appears only as Simple Mobile's parent-company primary source.

- `price_cents` is the actual USD price for `period_label`, before unspecified taxes/fees. The annual AT&T offer is **24000 cents upfront**, not 2000 cents.
- `monthly` means a regular recurring plan; `refill` is account funding without an included service bundle; `addon` needs an eligible base plan; `offer` has special activation/purchase conditions.
- `selectable: true` means **an unpaid request for review**, never a successful purchase, activation, guaranteed availability, dealer authorization or entitlement. Published regular plans/refill references retain this flag as requested. There are 17 such rows.
- All add-ons and promotional rows are `selectable: false`; show their original `source_url` as the carrier link. Account eligibility and activation must be handled by the carrier.
- Always display `period_label` and `eligibility`. A zero `validity_days` means no fixed service-day count is asserted: credit, monthly data service, add-on timing or a 12-month package. It never means zero days of service or unlimited validity. Do not turn credit expiry into an included service period.
- The file is bounded, not an exhaustive catalog. Some verified additional promotions are described below rather than expanding beyond ten rows.

## Simple Mobile — primary-source publication verified; current checkout unresolved

**Important limitation:** the five monthly amounts and data tiers are verified as published regular plans, but their current checkout availability could not be independently verified. They are retained only as explicitly caveated unpaid requests. This is not a claim that all six records were purchase-verified on the checked date.

| Record | Published amount | Evidence |
| --- | ---: | --- |
| 15GB Monthly | $25 | S1 |
| 20GB Monthly | $30 | S1 |
| 30GB Monthly | $40 | S1 |
| Unlimited World | $50 | S1, S3 |
| Unlimited World+ | $60 | S1, S3 |
| International calling credit | $10 | S2 |

- **S1 — [Verizon's Simple Mobile plan announcement](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless)**, originally published August 20, 2025, retrieved today: supplies the five tiers, data allowances and international destination counts. This is historical publication evidence, not a current checkout. International enhancements depend on Verizon-network activation.
- **S2 — [Simple Mobile Extras](https://dsweb.simplemobile.com/extras)**, readable today: defines a month as 30 days and documents $10 international credit, an existing service requirement, online-only purchase, destination-dependent rates and expiry 180 days after last use or 30 days after suspension, whichever is earlier. It provides no domestic monthly service entitlement.
- **S3 — [Simple Mobile Rewards page](https://www.simplemobile.com/rewards)**, official search-index extract crawled last month: still identifies the $50/$60 World tiers and current international/network conditions. Direct retrieval was empty; the indexed extract is corroboration only.
- **Blocked/empty:** [smartphone plans](https://www.simplemobile.com/serviceplan?deviceType=smartphone), [shop](https://www.simplemobile.com/shop), [international destinations](https://www.simplemobile.com/ilddestinations), and [Walmart-channel labels](https://www.simplemobile.com/nationalretailer/walmart). Direct HTTP retrieval of the smartphone page returned **403**. Earlier local research also records blocked Broadband Facts and retailer-channel labels.
- No current authoritative data-add-on amount/allotment pair was retrieved. **Omitted** alleged $5/2GB, $10/5GB and $20/10GB data add-ons, arbitrary $10/$20 domestic refills, unverified AutoPay reductions and dealer coupons. No precise hotspot quota or tax-inclusive claim is made for these monthly rows.
- The [older Lifeline/triple-data announcement](https://www.verizon.com/about/news/simple-mobile-lifeline) describes new-customer and eligibility-restricted benefits; current availability was not established. The [cloud page](https://www.simplemobile.com/cloud?lang=es) contains an explicitly expired September 2020 promotion and outdated allowances. Neither was promoted into a current offer. The Rewards terms also contain another brand's service terms and were not used.
- Retailer and comparison-site search results were encountered but not accepted as primary proof of current Simple Mobile pricing. No speculative lower monthly plan was added.

## T-Mobile — 10 current options

- **T1 — [Connect plans and Broadband Facts](https://prepaid.t-mobile.com/connect/phone-plans)**: $15/5GB, $25/8GB and $35/12GB; new and existing customers; 30-day cycles. No AutoPay discount. On-network data stops at the cap; hotspot shares the allowance.
- **T2 — [Prepaid monthly plans and Broadband Facts](https://prepaid.t-mobile.com/prepaid-plans)**: regular single-line prices are Starter $45, Unlimited $50 and Unlimited Plus $65. Carrier AutoPay lowers later cycles by $5 with a debit card or bank account; the first cycle stays at base price. JSON uses base prices. Detailed terms support 50GB premium data on the unlimited tiers; some homepage boilerplate still says 35GB, so the detailed plan page takes precedence.
- **T3 — [Data-only plans and Broadband Facts](https://prepaid.t-mobile.com/prepaid-internet)**: genuine $10/2GB and $20/5GB recurring plans, then up to 128Kbps. These are for compatible tablets/hotspots and explicitly exclude smartphones, wearables and SyncUP. Voice and texts are excluded. Labels identify plans ending **0030** and **0033**. Connection-fee wording differs between labels and footer, so the JSON does not promise a specific activation fee.
- **T4 — [Connect international add-ons](https://prepaid.t-mobile.com/connect/international-calling)**: $5 Mexico/Canada calling/texting and $15 Stateside International. Eligible on Connect $15-and-higher plans. Connect does not gain international data roaming; do not apply the main prepaid site's separate roaming-data benefits to these Connect add-ons.
- **Refill research — [official refill support](https://www.t-mobile.com/support/account/refill-your-prepaid-account)**: confirms one-time balance funding and an Auto Refill range of $10–$150. The range describes automatic funding, not a universal $10 phone plan or a verified fixed-denomination PIN. No invented $10/$20 phone-refill products were added.
- **Promotions checked at T2:** two Unlimited lines for **$75 total**, with a new-line requirement in the offer terms; four 10GB lines for **$100 total**. These are account/line-count offers, not $37.50 or $25 single-line refill prices. Not duplicated in the JSON to keep ten rows; any later offer card must be carrier-only, `selectable: false`, and link T2.
- The current Connect page starts at $15. A legacy $10/1GB phone plan was not established as currently available and was omitted. The genuine $10 and $20 rows here are explicitly data-only.

## AT&T — 10 current options

- **A1 — [Prepaid plans](https://www.att.com/prepaid/plans/)**: Unlimited Saver $35; 5GB hotspot add-on $10; online new-single-line $25 offer; 12-month $240 prepaid offer. Saver and the $25 offer cap the first 30GB at 3Mbps, then 1.5Mbps. Annual service includes 16GB monthly before slowing, plus 10GB hotspot. Exact total day count was not verified, so the annual row uses zero plus the explicit 12-month label.
- **A2 — [Prepaid family page and full plan terms](https://www.att.com/att/prepaid-family/)**: regular single-line Enhanced Plus $45 and Ultra $60; 30-day terms and 10GB/30GB hotspot respectively. Multi-line savings require enrollment; they were not deducted from single-line prices. Enhanced Plus expressly excludes an AutoPay discount.
- **A3 — [International calling and travel](https://www.att.com/prepaid/international-calling/)**: $10/250-minute international add-on and $15 International Plus, each 30 days with an active eligible voice plan. Also verifies Ultra's online new-single-line **$45 for six months, then $60** offer.
- **A4 — [Make a prepaid payment](https://www.att.com/support/article-modal/wireless/KM1008656/)**, updated November 24, 2025 and retrieved today: $10 minimum debit/credit-card payment; user chooses an amount. The JSON's $10 credit is a funding reference, not a $10 monthly plan or a guaranteed reseller PIN.
- **A5 — [Consumer Service Agreement, section 3.3](https://lsreg.att.com/legal/terms.consumerServiceAgreement.html)**: $10–$24 payments expire after 30 days, $25–$99 after 90 days, and $100+ after 365 days. A monthly plan needs its full charge funded. This also permits a $20 account payment, but it is not a distinct service bundle; not duplicated as another product.
- **Additional verified option, omitted only for the ten-row bound:** A3 lists the international travel add-on at **$40 for seven days**, with 5GB and unlimited talk/text in eligible countries; an active plan is required. Any later card should be carrier-only and link A3.
- **Not priced:** [BridgePay support](https://www.att.com/support/article-modal/wireless/KM1385451/) confirms seven-day 1GB/4GB extensions after the base plan expires but gives no dollar amounts in the retrieved page. No guessed $10/$20 BridgePay SKU was added.
- The [multi-month URL](https://www.att.com/prepaid/multi-month-plans/) redirects to A1. Older $300 annual/other legacy plan snippets were not treated as current alternatives. No unidentified flyer or coupon was verified.

## Existing AT&T asset evidence

Read-only inspection found `assets/carriers/att.svg`, **4,902 bytes**, SVG dimensions **98 × 32**, with dark wordmark paths and blue `#009FDB` globe paths.

SHA-256: `43652D903A8E592ACF08BE0708CFF62CF31FA261CE653089FFBC841380F3EE16`.

`research/carriers.json` already records slug `att`, color `#009FDB` and the $10 account-payment reference. `research/carrier-sources.md` explains that funding distinction. `research/seven-carrier-logos.json` has no AT&T provenance record. The local SVG's existence is confirmed; an original download source was not established from those research files. No asset was edited.

## Validation

Checked exact schema, required slugs, positive integer cent prices, boolean selection flags, HTTPS source links, allowed categories, 6/10/10 option counts, and carrier-only offer flags. Only the two requested research files were written. No purchase or fulfillment was performed.
