# Expanded prepaid research B

Checked: **2026-10-15**. Scope: US Lyca Mobile, Ultra Mobile and H2O Wireless. Official carrier pages and carrier-linked disclosures only. Read-only research; no activation, cart submission, account access, dealer-portal verification or live/app change.

## How to use the JSON

- Ten selected options per carrier; this is a bounded expansion of `seven-carrier-plans.json`, not an exhaustive replacement. Existing $23/$29 Lyca and $29/$39 Ultra regular records remain relevant as described below.
- `price_cents` is the base amount for the stated purchase, before extra taxes/fees. Multi-month entries contain the **full upfront amount**, not the advertised monthly equivalent.
- `selectable: true` identifies a published ordinary service/refill/add-on suitable for an **unpaid request**. It is not evidence of a dealer's entitlement, inventory, activation access or guaranteed fulfillment. All included carrier promotions are `category: offer`, `selectable: false`, with original carrier links.
- `validity_days: 0` means a fixed independent day count is not established or does not apply. Display `period_label`: credit, remaining-plan validity, rollover and twelve-month prepaid service must not be shown as “0 days” or silently converted into 30 days.
- An add-on requires its compatible base service. A credit refill is not an unlimited plan. Promotional prices are not regular renewal prices. No generic flyer/coupon or dealer-specific discount has been assumed.

## Lyca Mobile

### Ordinary plans and $10/$20 products

[Current catalog](https://www.lycamobile.us/en/plans/best-prepaid-phone-plans/) and individual products support these regular 30-day amounts:

| Regular price | High-speed data | Evidence |
| --- | --- | --- |
| $19 | 5GB | [$19 product](https://www.lycamobile.us/en/plan/19-international-plan-2/) |
| $23 | 8GB | [$23 product](https://www.lycamobile.us/en/plan/23-unlimited-international-plan/) — retained in existing research |
| $29 | 15GB | [$29 product](https://www.lycamobile.us/en/plan/29-unlimited-international-plan/) — retained in existing research |
| $33 | 18GB | [$33 product](https://www.lycamobile.us/en/plan/33-high-data-plan/) |
| $39 | 25GB | [$39 product](https://www.lycamobile.us/en/plan/39-high-data-plan/) |
| $49 Unlimited Plus | 50GB before reduced speeds | [Unlimited Plus product](https://www.lycamobile.us/en/plan/unlimited-plus-data-plan/) |

These include unlimited domestic talk/text; international destination restrictions apply. Website recovery fee: 5%. Hotspot amounts are not added to phone-data totals.

- [Quick top-up](https://www.lycamobile.us/en/quick-top-up/) explicitly lists $10 and $20 under account-credit top-ups in indexed official content. It also lists $50/$100. The direct extraction is a dynamic shell; the denomination evidence comes from the official search-indexed page, not a completed transaction. No fixed credit expiry or PAYG usage rate was established. JSON makes no 30-day-plan claim for these amounts.
- [$10 data add-on](https://www.lycamobile.us/en/plan/data-bolt-10/): **5GB**, requires an existing 30-day plan, expires with that plan.
- [$20 data add-on](https://www.lycamobile.us/en/plan/data-add-on/): current body says **10GB**; the page title still says 2GB. The [equivalent official bundle page](https://www.lycamobile.us/en/bundle/data-add-on/) also says 10GB. JSON follows the two current product bodies, records the stale-title conflict here, and does not invent a separate 2GB product.
- Both add-ons carry the 5% website fee. Neither is a standalone monthly plan or separate hotspot product.

### Current introductory offers and conflicts

- **5GB for $10 per 30-day cycle for 12 advertised months, then $19.** The [product](https://www.lycamobile.us/en/plan/19-international-plan-2/) and its [linked Broadband Facts](https://cms-assets.ldsvcplatform.com/USA/s3fs-public/2025-09/19InternationalPlan.pdf?VersionId=kAuOl4ZiK0Yy0ZL72B8UwIpYV4NAZAKJ) agree. New online line and continuing auto-renewal required. This is recurring discounted service, not $10 for a whole year.
- **Unlimited Plus for $18 per cycle for nine advertised months, then $49.** The [product](https://www.lycamobile.us/en/plan/unlimited-plus-data-plan/) and [June 2026 linked label](https://cms-assets.ldsvcplatform.com/USA/s3fs-public/2026-06/Unlimited%20Plus%2030%20Days%20_CA.pdf-1.pdf?VersionId=DKhRt0ds77M1psWKJe7ut9wEnWPNmgVc) agree on price, duration and 50GB. Same new-online-line/auto-renewal condition. The product's 40GB page title is stale relative to its body, terms and label.
- **Excluded discounted $33/18GB entry:** catalog says $7.50, extracted product price rounds to $8, while its [linked label](https://cms-assets.ldsvcplatform.com/USA/s3fs-public/2025-12/33_High_Data_Plan%201.pdf?VersionId=y0p2Lj13nFV72of8AqIuHdAAcekTc8wD) says $10 for six months then $33. The ordinary $33/18GB amount is consistent and included; no discounted amount is asserted as reliable.
- The existing $23 research records $15 introductory pricing then $23. It was not expanded into another offer row within the ten-option selection. Older blog PAYG wording and old flyer prices were not treated as current metered service.

## Ultra Mobile

### Regular service and verification

[Official comparison](https://www.ultramobile.com/why-ultra-mobile/), [shop listing](https://www.ultramobile.com/?post_type=product), [4GB product](https://www.ultramobile.com/product/4gb-prepaid-plan/) and [Broadband Facts CSV](https://broadband-labels.ultramobile.com/labels.csv) corroborate regular monthly prices: 4GB/$19, 8GB/$24, 12GB/$29, 24GB/$39, Unlimited/$49 and Unlimited+/$59. The CSV was fetched into memory and parsed; current named one-month rows show `intro_rate=NO`. Historical rows also remain in the file, so matching only a price or an old data amount is unsafe.

The existing 12GB/$29 and 24GB/$39 records can remain regular options; JSON uses its available slots for additional products and the separate 25GB new-customer offer. The [4GB FAQ](https://www.ultramobile.com/product/4gb-prepaid-plan/) defines service cycles as 30 days.

[Current plan terms](https://www.ultramobile.com/mobile-plans-terms-conditions/) and [carrier homepage](https://www.ultramobile.com/) support 10GB hotspot on Unlimited and 25GB on Unlimited+, approximately 480p video and possible congestion slowing above 35GB. The [hotspot page](https://www.ultramobile.com/mobile-hotspot/) contains an older 20GB sentence; its FAQ and current terms say 25GB. JSON uses current terms. Several direct storefront fetches returned 403; official indexed pages, accessible product pages and the CSV supplied corroboration. No account-specific checkout availability was established.

### PayGo and actual $10/$20 purchases

[Official PayGo page](https://www.ultramobile.com/paygo/) and [PayGo terms](https://www.ultramobile.com/mobile-plans-terms-conditions/) support:

- $3 each 30 days for 100 minutes, 100 texts and 100MB; excess usage draws from the wallet at 3 cents/minute, 1 cent/text and 3 cents/MB.
- PayGo-specific recharge cards include **$10**, $15 and $50. Ordinary Ultra recharge cards are incompatible. The $10 JSON entry is wallet credit, not ten dollars of bundled service.
- **$10 buys a seven-day 1GB data pass** on active PayGo service. Also published: $5/500MB for one day and $10 for a seven-day unlimited voice/text pass; omitted to keep the selection bounded.
- Auto-renew wallet denominations include $5/$10/**$20**. A $20 automatic wallet funding setting is not evidence of a universal $20 regular Ultra plan or a $20 PayGo retail card.

[International roaming](https://www.ultramobile.com/international-roaming/) publishes UpRoam credit in $5/$10/$20/$40 denominations. JSON includes $20 as **international roaming credit**, not domestic GB. Unused credit rolls over while subscribed; PayGo instead uses its separate wallet and has no data roaming. No reliable current standard-plan UpData dollar/GB table was found in the bounded pass, so no guessed $10/$20 domestic UpData option was added.

### Current carrier offers

[Promotion terms](https://www.ultramobile.com/all-promotional-offers-terms-conditions/) publish:

- 4GB: $30/3 months, $60/6 months or $120/12 months upfront; $10/month equivalent. New customers, first term only, then full-price options. JSON includes the $30 three-month purchase.
- Unlimited: $75/3 months, $150/6 months or $300/12 months upfront; $25/month equivalent. New customers, first term only. Verified but omitted from JSON to avoid repeating every term.
- 25GB: $29/1 month, $78/3 months, $138/6 months or $240/12 months upfront. The [25GB product](https://www.ultramobile.com/product/25gb-prepaid-plan/?attribute_months=1-month-plan) confirms the $29 total, new-customer restriction and loss of discount on cancellation/ineligible downgrade. JSON includes the one-month carrier offer and does not promise a permanent renewal rate.

Taxes/fees are extra. A $20/month advertisement can therefore mean the $240 annual 25GB offer, not a $20 one-month purchase. No AutoPay requirement was stated in the verified Ultra offer terms.

## H2O Wireless

### Regular plans, PAYG and multi-month payment

[Current monthly catalog](https://www.h2owireless.com/plan/monthly) gives:

| Base monthly price | High-speed data threshold | Hotspot | With AutoPay |
| --- | --- | --- | --- |
| $20 | 10GB | 2GB | $18 |
| $30 | 30GB | 5GB | $27 |
| $40 | 40GB | 10GB | $36 |
| $50 | 60GB | 15GB | $45 |
| $60 | 60GB | 20GB | $54 |

[Terms sections 1.3–1.5](https://www.h2owireless.com/terms-conditions) establish 30-day monthly cycles, reduced speeds up to 256Kbps and data-top-up rollover. JSON uses ordinary base prices. Carrier fees and location-dependent taxes are additional.

The old [annual /25 URL](https://www.h2owireless.com/affordable-mobile-annual-plans/25) now redirects to [the 12-month catalog](https://www.h2owireless.com/plan/monthly?duration=12). Its lowest current card is **$192 upfront for 12 months of 10GB per cycle**, equivalent to $16/month. The same tier lists $54/3 months and $102/6 months. JSON preserves the full annual payment and the published twelve-month period without inventing a 365-day term. No new-customer-only condition appears on that card. Advance-payment discounts and monthly AutoPay must not be stacked.

[PAYG product and detailed terms](https://www.h2owireless.com/plan/minute) agree on **$10/90 days**, $30/90 days and **$100/365 days**, with 5-cent domestic minutes/texts and 10 cents/MB. JSON includes $10 and $100; $30 is verified but omitted for the ten-entry bound. These are shared metered balances. The page's “$10 a month” introduction and label monthly equivalents do not replace the explicit 90-day expiry. Balance rollover requires same-denomination recharge before expiry. No $20 PAYG denomination was verified.

### Data add-ons and current promotions

[Bill pay](https://www.h2owireless.com/billpay) independently confirms mobile data **2GB/$10 and 5GB/$20**. Its recharge terms and [current general terms](https://www.h2owireless.com/terms-conditions) say included data is consumed first; unused top-up data rolls over through uninterrupted renewal of the same plan and is lost on expiry, termination or plan changes. These are not new 30-day plans.

The bill-pay headline separately advertises hotspot 2GB/$10, 5GB/$20, 10GB/$30, but its FAQ still says 1GB/$10 and carries old annual-plan/device language. **Separate hotspot top-up rows are excluded**; mobile data top-ups are the reliable nonduplicated entries. Ordinary included hotspot quotas above are independently supported by current plan cards.

[AutoPay](https://www.h2owireless.com/autopay-intro) is a conditional 10% reduction, reflected in eligibility rather than substituted for base price. [Refer a Friend](https://www.h2owireless.com/refer-a-friend) currently promises $20 reward credit to each party after the friend purchases through the unique referral link and activates; the stated posting time is 1–7 business days. This is a carrier reward, not a $20 purchased plan or an unconditional dealer coupon. It is documented here rather than forced into a JSON field that represents a purchase price.

## Validation and limits

Thirty JSON records use the requested schema, slugs and category vocabulary. Promotions are non-selectable; ordinary options are selectable only for unpaid requests under the eligibility text. Search-indexed official content is identified where direct extraction was unavailable. Conflicting quantities, unsupported PAYG prices, historical flyers, third-party summaries and unverified dealer incentives were excluded. Current means observed in the carrier's public material on the checked date; no purchase or carrier account transaction was performed.
