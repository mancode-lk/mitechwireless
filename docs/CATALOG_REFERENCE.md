# MI Tech Wireless catalog reference

This reference contains all 63 options in the committed catalog checked on **October 15, 2026**. Amounts, allowances and eligibility describe that snapshot, not a guarantee of present carrier availability or fulfillment access. Recheck the linked carrier source before changing sellable products. [Return to the developer guide](../DEVELOPER_GUIDE.md#carrier-catalog).

Runtime metadata comes from [expanded-catalog.json](../research/expanded-catalog.json); the database receives product prices and descriptions through [selected-carriers.sql](../sql/selected-carriers.sql). Category and eligibility matching use the exact carrier slug and plan name. Database IDs are environment-specific and are intentionally omitted.

**Selectable** means the unpaid request flow accepts the option. It does not mean payment or recharge is enabled. **Carrier link only** means the UI directs the visitor to the carrier and the request API rejects that selection. All current generated database plans have `verify_pricing=1` until an operator verifies them for real purchase.

A zero `validity_days` is an unspecified/database-neutral term, not a promise of no expiry. Use the explicit period and eligibility text, especially for credits, add-ons and prepaid multi-month products.

## Carrier index

| Carrier | Slug | Options | Selectable | Carrier links only |
| --- | --- | ---: | ---: | ---: |
| [Simple Mobile](#simple-mobile) | `simple-mobile` | 6 | 5 | 1 |
| [T-Mobile](#t-mobile) | `t-mobile` | 10 | 8 | 2 |
| [Lyca Mobile](#lyca-mobile) | `lyca-mobile` | 12 | 10 | 2 |
| [Ultra Mobile](#ultra-mobile) | `ultra-mobile` | 13 | 10 | 3 |
| [H2O Wireless](#h2o-wireless) | `h2o-wireless` | 11 | 11 | 0 |
| [AT&T](#att) | `att` | 11 | 5 | 6 |

## Simple Mobile

30-day talk and data packages plus international calling credit. Published monthly prices are shown; availability and final charges require confirmation.

Carrier slug: `simple-mobile`. [Carrier source](https://www.simplemobile.com/serviceplan?deviceType=smartphone).

| Option | Price USD | Category | Request availability |
| --- | ---: | --- | --- |
| 15GB Monthly | $25.00 | Monthly plans | Selectable |
| 20GB Monthly | $30.00 | Monthly plans | Selectable |
| 30GB Monthly | $40.00 | Monthly plans | Selectable |
| Unlimited World | $50.00 | Monthly plans | Selectable |
| Unlimited World+ | $60.00 | Monthly plans | Selectable |
| Pay-As-You-Go International Calling Credit | $10.00 | Add-ons | Carrier link only |

### 1 15GB Monthly

Published 15GB plan with calling to 100+ countries. Confirm current availability before payment.

| Field | Catalog value |
| --- | --- |
| Price | USD $25.00 (2500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 15GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and global texting |
| Eligibility | Compatible Simple Mobile line; Verizon-network activation for stated international benefits. Confirm current terms before fulfillment; no AutoPay reduction. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless)

### 2 20GB Monthly

Published 20GB plan with calling to 125+ countries. Confirm current availability before payment.

| Field | Catalog value |
| --- | --- |
| Price | USD $30.00 (3000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 20GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and global texting |
| Eligibility | Compatible Simple Mobile line; Verizon-network activation for stated international benefits. Confirm current terms before fulfillment; no AutoPay reduction. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless)

### 3 30GB Monthly

Published 30GB plan with calling to 125+ countries. Confirm current availability before payment.

| Field | Catalog value |
| --- | --- |
| Price | USD $40.00 (4000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 30GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and global texting |
| Eligibility | Compatible Simple Mobile line; Verizon-network activation for stated international benefits. Confirm current terms before fulfillment; no AutoPay reduction. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless)

### 4 Unlimited World

Published unlimited plan with calling to 200+ countries. Confirm current availability before payment.

| Field | Catalog value |
| --- | --- |
| Price | USD $50.00 (5000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and global texting |
| Eligibility | Compatible Simple Mobile line; Verizon-network activation for 200+ country calling. Congestion can slow data. Confirm current terms before fulfillment; no AutoPay reduction. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless)

### 5 Unlimited World+

Published unlimited plan with roaming in 140+ countries. Confirm current availability before payment.

| Field | Catalog value |
| --- | --- |
| Price | USD $60.00 (6000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data; 5G Ultra Wideband access |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and global texting |
| Eligibility | Compatible Simple Mobile line; Verizon-network activation for stated international benefits. Ultra Wideband requires compatible device and coverage. Confirm current terms before fulfillment; no AutoPay reduction. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.verizon.com/about/news/verizon-value-simple-mobile-total-wireless)

### 6 Pay-As-You-Go International Calling Credit

$10 international calling credit; requires a separate active service plan. Online only.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Add-ons (`addon`) |
| Period | International calling credit |
| Database validity days | 0 |
| Data | None |
| Calls | International calling credit; destination rates vary |
| Texts | None |
| Eligibility | Active Simple Mobile service required; eligible destinations only. Buy through Simple Mobile online. No added service days. Credit expires 180 days after last use or 30 days after service suspension, whichever is earlier. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://dsweb.simplemobile.com/extras)

## T-Mobile

Prepaid phone plans, separate tablet/hotspot plans, and international add-ons. Regular prices before AutoPay; taxes and fees extra.

Carrier slug: `t-mobile`. [Carrier source](https://prepaid.t-mobile.com/prepaid-plans).

| Option | Price USD | Category | Request availability |
| --- | ---: | --- | --- |
| Mobile Internet 2GB — Data Only | $10.00 | Monthly plans | Selectable |
| Connect 5GB | $15.00 | Monthly plans | Selectable |
| Mobile Internet 5GB — Data Only | $20.00 | Monthly plans | Selectable |
| Connect 8GB | $25.00 | Monthly plans | Selectable |
| Connect 12GB | $35.00 | Monthly plans | Selectable |
| Starter Monthly | $45.00 | Monthly plans | Selectable |
| Unlimited Monthly | $50.00 | Monthly plans | Selectable |
| Unlimited Plus Monthly | $65.00 | Monthly plans | Selectable |
| Mexico & Canada Unlimited — Connect Add-on | $5.00 | Add-ons | Carrier link only |
| Stateside International — Connect Add-on | $15.00 | Add-ons | Carrier link only |

### 1 Mobile Internet 2GB — Data Only

Monthly tablet or hotspot data plan. Taxes and fees extra; no phone service included.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 1 month — data-only device plan |
| Database validity days | 0 |
| Data | 2GB high-speed data, then up to 128Kbps |
| Calls | Not included |
| Texts | Not included |
| Eligibility | Compatible unlocked SIM-capable tablet or hotspot; excludes smartphones, wearables and SyncUP. Regular price; activation charges may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/prepaid-internet)

### 2 Connect 5GB

Hotspot shares the data allowance; on-network data stops at the cap. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $15.00 (1500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 5GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide SMS/MMS |
| Eligibility | New and existing customers; compatible device. No AutoPay discount; no annual prepayment. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/connect/phone-plans)

### 3 Mobile Internet 5GB — Data Only

Monthly tablet or hotspot data plan. Taxes and fees extra; no phone service included.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 1 month — data-only device plan |
| Database validity days | 0 |
| Data | 5GB high-speed data, then up to 128Kbps |
| Calls | Not included |
| Texts | Not included |
| Eligibility | Compatible unlocked SIM-capable tablet or hotspot; excludes smartphones, wearables and SyncUP. Regular price; activation charges may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/prepaid-internet)

### 4 Connect 8GB

Hotspot shares the data allowance; on-network data stops at the cap. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $25.00 (2500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 8GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide SMS/MMS |
| Eligibility | New and existing customers; compatible device. No AutoPay discount; no annual prepayment. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/connect/phone-plans)

### 5 Connect 12GB

Hotspot shares the data allowance; on-network data stops at the cap. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $35.00 (3500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 12GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide SMS/MMS |
| Eligibility | New and existing customers; compatible device. No AutoPay discount; no annual prepayment. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/connect/phone-plans)

### 6 Starter Monthly

Hotspot shares 15GB. Regular price before AutoPay; taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $45.00 (4500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 15GB high-speed data, then 2G speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Compatible prepaid voice line. Carrier AutoPay with debit card or bank account reduces future cycles to $40; first cycle $45. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/prepaid-plans)

### 7 Unlimited Monthly

Unlimited hotspot at 3G speeds. Regular price before AutoPay; taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $50.00 (5000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data; 50GB premium data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Compatible prepaid voice line. Carrier AutoPay with debit card or bank account reduces future cycles to $45; first cycle $50. Lower priority after 50GB during congestion. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/prepaid-plans)

### 8 Unlimited Plus Monthly

Includes 5GB high-speed hotspot. Regular price before AutoPay; taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $65.00 (6500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data; 50GB premium data |
| Calls | Unlimited between the U.S., Mexico and Canada |
| Texts | Unlimited domestic; international texting to 215+ countries |
| Eligibility | Compatible prepaid voice line. Carrier AutoPay with debit card or bank account reduces future cycles to $60; first cycle $65. Lower priority after 50GB during congestion. |
| Request availability | Selectable for unpaid requests |

[Product source](https://prepaid.t-mobile.com/prepaid-plans)

### 9 Mexico & Canada Unlimited — Connect Add-on

Adds international calling and texting to an eligible Connect plan; base service costs extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $5.00 (500 cents) |
| Category | Add-ons (`addon`) |
| Period | Per monthly plan cycle |
| Database validity days | 30 |
| Data | No international data roaming on Connect |
| Calls | Unlimited between the U.S., Mexico and Canada |
| Texts | Unlimited to 215+ countries from covered U.S., Mexico and Canada locations |
| Eligibility | Connect plan priced $15 or higher. Add through T-Mobile; not for extended international use. Confirm coverage and taxes. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://prepaid.t-mobile.com/connect/international-calling)

### 10 Stateside International — Connect Add-on

Adds selected international calls and discounted rates elsewhere; base service costs extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $15.00 (1500 cents) |
| Category | Add-ons (`addon`) |
| Period | Per monthly plan cycle |
| Database validity days | 30 |
| Data | None added |
| Calls | Unlimited to landlines in 70+ countries and mobiles in 30+ countries |
| Texts | International texting to 215+ countries from the network |
| Eligibility | Connect plan priced $15 or higher. Add through T-Mobile; check country and number eligibility. Confirm taxes. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://prepaid.t-mobile.com/connect/international-calling)

## Lyca Mobile

30-day plans, account credit and data add-ons. Website purchases add a 5% recovery fee; introductory offers have separate conditions.

Carrier slug: `lyca-mobile`. [Carrier source](https://www.lycamobile.us/en/plans/best-prepaid-phone-plans/).

| Option | Price USD | Category | Request availability |
| --- | ---: | --- | --- |
| Unlimited International 5GB | $19.00 | Monthly plans | Selectable |
| $23 Unlimited International - 8GB | $23.00 | Monthly plans | Selectable |
| $29 Unlimited International - 15GB | $29.00 | Monthly plans | Selectable |
| High Data 18GB | $33.00 | Monthly plans | Selectable |
| Unlimited International 25GB | $39.00 | Monthly plans | Selectable |
| Unlimited Plus | $49.00 | Monthly plans | Selectable |
| $10 account credit refill | $10.00 | Refill credit | Selectable |
| $20 account credit refill | $20.00 | Refill credit | Selectable |
| 5GB data add-on | $10.00 | Add-ons | Selectable |
| 10GB data add-on | $20.00 | Add-ons | Selectable |
| 5GB new-line introductory offer | $10.00 | Special offers | Carrier link only |
| Unlimited Plus introductory offer | $18.00 | Special offers | Carrier link only |

### 1 Unlimited International 5GB

Hotspot supported. International calling to selected destinations included; restrictions apply.

| Field | Catalog value |
| --- | --- |
| Price | USD $19.00 (1900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 5GB high-speed data, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Regular price before introductory offers. Compatible unlocked phone required. Website purchases add a 5% recovery fee. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/19-international-plan-2/)

### 2 $23 Unlimited International - 8GB

High-speed data with unlimited nationwide calls and texts. Data speeds are reduced after the allowance. International destination restrictions apply; carrier website purchases add a 5% recovery fee.

| Field | Catalog value |
| --- | --- |
| Price | USD $23.00 (2300 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 8GB at up to 5G speeds, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Regular single-month price for an eligible existing line. Compatible phone required; taxes and fees may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/23-unlimited-international-plan/)

### 3 $29 Unlimited International - 15GB

High-speed data with unlimited nationwide calls and texts. Data speeds are reduced after the allowance. International destination restrictions apply; carrier website purchases add a 5% recovery fee.

| Field | Catalog value |
| --- | --- |
| Price | USD $29.00 (2900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 15GB at up to 5G speeds, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Regular single-month price for an eligible existing line. Compatible phone required; taxes and fees may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/29-unlimited-international-plan/)

### 4 High Data 18GB

Includes up to 10GB hotspot. International calling to selected destinations included; restrictions apply.

| Field | Catalog value |
| --- | --- |
| Price | USD $33.00 (3300 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 18GB high-speed data, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Regular price before introductory offers. Compatible unlocked phone required. Website purchases add a 5% recovery fee. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/33-high-data-plan/)

### 5 Unlimited International 25GB

Includes up to 10GB hotspot. International calling to selected destinations included; restrictions apply.

| Field | Catalog value |
| --- | --- |
| Price | USD $39.00 (3900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 25GB high-speed data, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Regular price before introductory offers. Compatible unlocked phone required. Website purchases add a 5% recovery fee. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/39-high-data-plan/)

### 6 Unlimited Plus

Includes up to 15GB hotspot. International calling to selected destinations included; restrictions apply.

| Field | Catalog value |
| --- | --- |
| Price | USD $49.00 (4900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 50GB high-speed data, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | Regular price before introductory offers. Compatible unlocked phone required. Website purchases add a 5% recovery fee. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/unlimited-plus-data-plan/)

### 7 $10 account credit refill

Adds $10 account credit. Does not itself specify a service plan or new service period.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Refill credit (`refill`) |
| Period | Account credit; no fixed term published |
| Database validity days | 0 |
| Data | No bundled data |
| Calls | No bundled minutes |
| Texts | No bundled texts |
| Eligibility | Existing Lyca number required. Use depends on account and service terms; website recovery fee is 5%. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/quick-top-up/)

### 8 $20 account credit refill

Adds $20 account credit. Does not itself specify a service plan or new service period.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Refill credit (`refill`) |
| Period | Account credit; no fixed term published |
| Database validity days | 0 |
| Data | No bundled data |
| Calls | No bundled minutes |
| Texts | No bundled texts |
| Eligibility | Existing Lyca number required. Use depends on account and service terms; website recovery fee is 5%. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/quick-top-up/)

### 9 5GB data add-on

Adds data to an active plan; unused add-on data expires when that plan ends.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Add-ons (`addon`) |
| Period | Until current plan expires |
| Database validity days | 0 |
| Data | 5GB additional high-speed data |
| Calls | Not included |
| Texts | Not included |
| Eligibility | Requires an active 30-day Lyca plan; cannot be used alone. Website recovery fee is 5%. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/data-bolt-10/)

### 10 10GB data add-on

Adds data to an active plan; unused add-on data expires when that plan ends.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Add-ons (`addon`) |
| Period | Until current plan expires |
| Database validity days | 0 |
| Data | 10GB additional high-speed data |
| Calls | Not included |
| Texts | Not included |
| Eligibility | Requires an active 30-day Lyca plan; cannot be used alone. Website recovery fee is 5%. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.lycamobile.us/en/plan/data-add-on/)

### 11 5GB new-line introductory offer

$10 per 30-day cycle for the advertised 12-month introductory period, then $19.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Special offers (`offer`) |
| Period | 30 days; introductory price for 12 months |
| Database validity days | 30 |
| Data | 5GB high-speed data, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | New line purchased directly from Lyca online; continuous auto-renewal required. Discount ends if auto-renewal is disabled or fails. 5% website recovery fee extra. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.lycamobile.us/en/plan/19-international-plan-2/)

### 12 Unlimited Plus introductory offer

$18 per 30-day cycle for the advertised nine-month introductory period, then $49. Includes 15GB hotspot.

| Field | Catalog value |
| --- | --- |
| Price | USD $18.00 (1800 cents) |
| Category | Special offers (`offer`) |
| Period | 30 days; introductory price for 9 months |
| Database validity days | 30 |
| Data | 50GB high-speed data, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide |
| Eligibility | New line purchased directly from Lyca online; continuous auto-renewal required. Discount ends if auto-renewal is disabled or fails. 5% website recovery fee extra. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.lycamobile.us/en/plan/unlimited-plus-data-plan/)

## Ultra Mobile

Monthly service, a separate PayGo plan, and account-specific add-ons. Taxes and fees are extra; multi-month introductory prices require upfront payment.

Carrier slug: `ultra-mobile`. [Carrier source](https://www.ultramobile.com/plans/).

| Option | Price USD | Category | Request availability |
| --- | ---: | --- | --- |
| PayGo monthly service | $3.00 | Monthly plans | Selectable |
| 4GB - 1 month | $19.00 | Monthly plans | Selectable |
| 8GB - 1 month | $24.00 | Monthly plans | Selectable |
| 12GB - 1 Month | $29.00 | Monthly plans | Selectable |
| 24GB - 1 Month | $39.00 | Monthly plans | Selectable |
| Ultra Unlimited - 1 month | $49.00 | Monthly plans | Selectable |
| Ultra Unlimited+ - 1 month | $59.00 | Monthly plans | Selectable |
| $10 PayGo wallet refill | $10.00 | Refill credit | Selectable |
| PayGo 1GB data pass | $10.00 | Add-ons | Selectable |
| $20 UpRoam credit | $20.00 | Add-ons | Selectable |
| 25GB new-customer offer - 1 month | $29.00 | Special offers | Carrier link only |
| 4GB introductory 3-month offer | $30.00 | Special offers | Carrier link only |
| 25GB introductory 12-month offer | $240.00 | Special offers | Carrier link only |

### 1 PayGo monthly service

A $3 charge renews service every 30 days from the PayGo wallet. Included allowances expire each cycle.

| Field | Catalog value |
| --- | --- |
| Price | USD $3.00 (300 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 100MB; additional data $0.03/MB |
| Calls | 100 minutes; then $0.03/minute |
| Texts | 100 texts; then $0.01 each |
| Eligibility | Requires the separate PayGo SIM and plan. Wallet must cover renewal and extra usage. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/paygo/)

### 2 4GB - 1 month

Hotspot shares the data allowance. Includes calling to selected international destinations.

| Field | Catalog value |
| --- | --- |
| Price | USD $19.00 (1900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 4GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | Regular single-month price; compatible unlocked phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/product/4gb-prepaid-plan/?attribute_months=1-month-plan)

### 3 8GB - 1 month

Hotspot shares the data allowance. Includes calling to selected international destinations.

| Field | Catalog value |
| --- | --- |
| Price | USD $24.00 (2400 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 8GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | Regular single-month price; compatible unlocked phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/product/8gb-prepaid-plan/?attribute_months=1-month-plan)

### 4 12GB - 1 Month

Hotspot shares plan data. After the allowance, speeds may fall to 2G or data may stop under plan terms. Congestion may reduce speeds; taxes/fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $29.00 (2900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 12GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide SMS/MMS |
| Eligibility | Regular single-month price for an eligible existing line. Compatible phone required; taxes and fees may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/plans/)

### 5 24GB - 1 Month

Hotspot shares plan data. After the allowance, speeds may fall to 2G or data may stop under plan terms. Congestion may reduce speeds; taxes/fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $39.00 (3900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 24GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide SMS/MMS |
| Eligibility | Regular single-month price for an eligible existing line. Compatible phone required; taxes and fees may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/product/24gb-prepaid-plan/?attribute_months=1-month-plan)

### 6 Ultra Unlimited - 1 month

10GB high-speed hotspot. Video generally streams at about 480p.

| Field | Catalog value |
| --- | --- |
| Price | USD $49.00 (4900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data; congestion-related slowing may apply after 35GB |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | Regular single-month price; compatible unlocked phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/why-ultra-mobile/)

### 7 Ultra Unlimited+ - 1 month

25GB high-speed hotspot. Video generally streams at about 480p.

| Field | Catalog value |
| --- | --- |
| Price | USD $59.00 (5900 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data; congestion-related slowing may apply after 35GB |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | Regular single-month price; compatible unlocked phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/why-ultra-mobile/)

### 8 $10 PayGo wallet refill

Adds $10 to the PayGo wallet for renewal, usage or eligible passes.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Refill credit (`refill`) |
| Period | Wallet credit; service renews separately |
| Database validity days | 0 |
| Data | Credit used for metered data or passes |
| Calls | Credit used for minutes |
| Texts | Credit used for texts |
| Eligibility | PayGo accounts only; ordinary Ultra recharge cards are not compatible. The $3 service charge is deducted separately. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/paygo/)

### 9 PayGo 1GB data pass

Adds 1GB for seven days to an active PayGo account.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Add-ons (`addon`) |
| Period | 7 days |
| Database validity days | 7 |
| Data | 1GB additional data |
| Calls | Not included |
| Texts | Not included |
| Eligibility | PayGo only; does not work on suspended accounts. Another data pass cannot be added until the current high-speed data is exhausted. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/paygo/)

### 10 $20 UpRoam credit

Adds international roaming credit; unused credit rolls into the next billing month.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Add-ons (`addon`) |
| Period | Credit rolls over while subscribed |
| Database validity days | 0 |
| Data | Metered roaming data; destination rates apply |
| Calls | Metered roaming calls |
| Texts | Metered roaming texts |
| Eligibility | Requires an eligible active standard Ultra plan. PayGo uses its own wallet and has no data roaming. Destination and device restrictions apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.ultramobile.com/international-roaming/)

### 11 25GB new-customer offer - 1 month

New-customer version of the regular 12GB plan. $29 paid for one month; longer terms require larger upfront payments.

| Field | Catalog value |
| --- | --- |
| Price | USD $29.00 (2900 cents) |
| Category | Special offers (`offer`) |
| Period | 30 days; new-customer offer |
| Database validity days | 30 |
| Data | 25GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | Limited-time new-customer carrier offer; discount ends if the line is cancelled or downgraded to an ineligible plan. Taxes and fees extra; renewal terms must be checked with Ultra. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.ultramobile.com/product/25gb-prepaid-plan/?attribute_months=1-month-plan)

### 12 4GB introductory 3-month offer

$30 prepaid for three months, equivalent to $10 per month. Full-price options apply after the first term.

| Field | Catalog value |
| --- | --- |
| Price | USD $30.00 (3000 cents) |
| Category | Special offers (`offer`) |
| Period | 3 months prepaid; $30 upfront |
| Database validity days | 90 |
| Data | 4GB high-speed data per monthly cycle |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | New customers; initial term only. Taxes and fees extra. Carrier offer; availability must be checked directly with Ultra. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.ultramobile.com/all-promotional-offers-terms-conditions/)

### 13 25GB introductory 12-month offer

$240 upfront for twelve months, equivalent to $20 per month. Includes 25GB high-speed data per monthly cycle.

| Field | Catalog value |
| --- | --- |
| Price | USD $240.00 (24000 cents) |
| Category | Special offers (`offer`) |
| Period | 12 months prepaid; $240 upfront |
| Database validity days | 0 |
| Data | 25GB high-speed data |
| Calls | Unlimited nationwide |
| Texts | Unlimited global |
| Eligibility | New-customer carrier offer. Full payment for twelve months required; taxes and fees extra. Confirm renewal pricing with Ultra. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.ultramobile.com/all-promotional-offers-terms-conditions/)

## H2O Wireless

Monthly plans, prepaid multi-month service, PAYG credit and rollover data top-ups. Listed prices exclude taxes and fees; AutoPay discounts require enrollment.

Carrier slug: `h2o-wireless`. [Carrier source](https://www.h2owireless.com/plan/monthly).

| Option | Price USD | Category | Request availability |
| --- | ---: | --- | --- |
| 10GB - $20 monthly | $20.00 | Monthly plans | Selectable |
| Unlimited - $30 monthly | $30.00 | Monthly plans | Selectable |
| Unlimited - $40 monthly | $40.00 | Monthly plans | Selectable |
| Unlimited - $50 monthly | $50.00 | Monthly plans | Selectable |
| Unlimited - $60 monthly | $60.00 | Monthly plans | Selectable |
| 10GB - 12 months prepaid | $192.00 | Monthly plans | Selectable |
| $10 Pay As You Go credit | $10.00 | Refill credit | Selectable |
| $30 Pay As You Go credit | $30.00 | Refill credit | Selectable |
| $100 Pay As You Go credit | $100.00 | Refill credit | Selectable |
| 2GB data top-up | $10.00 | Add-ons | Selectable |
| 5GB data top-up | $20.00 | Add-ons | Selectable |

### 1 10GB - $20 monthly

2GB hotspot included. Selected international calls included.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 10GB high-speed data, then up to 256Kbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and international |
| Eligibility | Regular price; $18 with carrier AutoPay enrollment. Compatible phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/monthly)

### 2 Unlimited - $30 monthly

5GB hotspot included. Selected international calls included.

| Field | Catalog value |
| --- | --- |
| Price | USD $30.00 (3000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 30GB high-speed data, then up to 256Kbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and international |
| Eligibility | Regular price; $27 with carrier AutoPay enrollment. Compatible phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/monthly)

### 3 Unlimited - $40 monthly

10GB hotspot included. Selected international calls included.

| Field | Catalog value |
| --- | --- |
| Price | USD $40.00 (4000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 40GB high-speed data, then up to 256Kbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and international |
| Eligibility | Regular price; $36 with carrier AutoPay enrollment. Compatible phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/monthly)

### 4 Unlimited - $50 monthly

15GB hotspot included. Selected international calls included.

| Field | Catalog value |
| --- | --- |
| Price | USD $50.00 (5000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 60GB high-speed data, then up to 256Kbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and international |
| Eligibility | Regular price; $45 with carrier AutoPay enrollment. Compatible phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/monthly)

### 5 Unlimited - $60 monthly

20GB hotspot included. Selected international calls included.

| Field | Catalog value |
| --- | --- |
| Price | USD $60.00 (6000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | 60GB high-speed data, then up to 256Kbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and international |
| Eligibility | Regular price; $54 with carrier AutoPay enrollment. Compatible phone required. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/monthly)

### 6 10GB - 12 months prepaid

$192 upfront, equivalent to $16 per month. Includes 2GB hotspot per monthly cycle.

| Field | Catalog value |
| --- | --- |
| Price | USD $192.00 (19200 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 12 months prepaid; $192 upfront |
| Database validity days | 0 |
| Data | 10GB high-speed data per monthly cycle, then reduced speeds |
| Calls | Unlimited nationwide |
| Texts | Unlimited nationwide and international |
| Eligibility | Full-term advance payment required. No introductory new-line condition stated on the current plan card. No additional AutoPay discount applied; taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/monthly?duration=12)

### 7 $10 Pay As You Go credit

$10 shared usage credit; service stops when credit runs out. MMS consumes data.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Refill credit (`refill`) |
| Period | 90 days or until credit is used |
| Database validity days | 90 |
| Data | $0.10/MB; usage draws from credit |
| Calls | $0.05/minute |
| Texts | $0.05/text |
| Eligibility | H2O PAYG account required. Recharge the same denomination before expiry for balance rollover. $9 with AutoPay; taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/minute)

### 8 $30 Pay As You Go credit

$30 shared usage credit; service stops when credit runs out. MMS consumes data.

| Field | Catalog value |
| --- | --- |
| Price | USD $30.00 (3000 cents) |
| Category | Refill credit (`refill`) |
| Period | 90 days or until credit is used |
| Database validity days | 90 |
| Data | $0.10/MB; usage draws from credit |
| Calls | $0.05/minute |
| Texts | $0.05/text |
| Eligibility | H2O PAYG account required. Recharge the same denomination before expiry for balance rollover. $27 with AutoPay; taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/minute)

### 9 $100 Pay As You Go credit

$100 shared usage credit; service stops when credit runs out. MMS consumes data.

| Field | Catalog value |
| --- | --- |
| Price | USD $100.00 (10000 cents) |
| Category | Refill credit (`refill`) |
| Period | 365 days or until credit is used |
| Database validity days | 365 |
| Data | $0.10/MB; usage draws from credit |
| Calls | $0.05/minute |
| Texts | $0.05/text |
| Eligibility | H2O PAYG account required. Recharge the same denomination before expiry for balance rollover. $90 with AutoPay; taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/plan/minute)

### 10 2GB data top-up

Used after the plan's included data. Unused top-up data rolls over with continuous renewal of the same plan.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Add-ons (`addon`) |
| Period | Until used; continuous same-plan renewal required |
| Database validity days | 0 |
| Data | 2GB additional high-speed data |
| Calls | Not included |
| Texts | Not included |
| Eligibility | Active H2O Monthly Unlimited plan required. Balance is forfeited on expiry, cancellation or a plan change. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/billpay)

### 11 5GB data top-up

Used after the plan's included data. Unused top-up data rolls over with continuous renewal of the same plan.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Add-ons (`addon`) |
| Period | Until used; continuous same-plan renewal required |
| Database validity days | 0 |
| Data | 5GB additional high-speed data |
| Calls | Not included |
| Texts | Not included |
| Eligibility | Active H2O Monthly Unlimited plan required. Balance is forfeited on expiry, cancellation or a plan change. Taxes and fees extra. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.h2owireless.com/billpay)

## AT&T

AT&T Prepaid monthly packages, account refill credit, calling add-ons and online offers. Taxes and fees may apply; check the conditions on each option.

Carrier slug: `att`. [Carrier source](https://www.att.com/prepaid/plans/).

| Option | Price USD | Category | Request availability |
| --- | ---: | --- | --- |
| Unlimited Saver | $35.00 | Monthly plans | Selectable |
| Unlimited Enhanced Plus | $45.00 | Monthly plans | Selectable |
| Unlimited Ultra | $60.00 | Monthly plans | Selectable |
| $10 Prepaid Account Credit | $10.00 | Refill credit | Selectable |
| $20 Prepaid Account Credit | $20.00 | Refill credit | Selectable |
| 5GB Hotspot Add-on | $10.00 | Add-ons | Carrier link only |
| International 250 Minutes | $10.00 | Add-ons | Carrier link only |
| International Plus | $15.00 | Add-ons | Carrier link only |
| Online Unlimited — New Single Line | $25.00 | Special offers | Carrier link only |
| Unlimited Ultra — First Six Months | $45.00 | Special offers | Carrier link only |
| 12-Month Unlimited — $240 Upfront | $240.00 | Special offers | Carrier link only |

### 1 Unlimited Saver

Speed-capped unlimited phone plan. Hotspot costs extra; taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $35.00 (3500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited; first 30GB at up to 3Mbps, then up to 1.5Mbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited domestic; U.S. texting to 230+ countries |
| Eligibility | Single line only; compatible AT&T Prepaid device. Regular price with no new-line promotion or AutoPay reduction. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.att.com/prepaid/plans/)

### 2 Unlimited Enhanced Plus

Includes 10GB hotspot and Mexico/Canada use; Canadian data limit 25GB. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $45.00 (4500 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited data with 5G; congestion may slow speeds |
| Calls | Unlimited between the U.S., Mexico and Canada |
| Texts | Unlimited domestic; U.S. texting to 230+ countries |
| Eligibility | Compatible AT&T Prepaid line. Regular single-line price; no AutoPay discount. Family pricing requires separate enrollment. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.att.com/att/prepaid-family/)

### 3 Unlimited Ultra

Includes 30GB hotspot and Mexico/Canada use; Canadian data limit 25GB. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $60.00 (6000 cents) |
| Category | Monthly plans (`monthly`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | Unlimited high-speed data with 5G |
| Calls | Unlimited between the U.S., Mexico and Canada |
| Texts | Unlimited domestic; U.S. texting to 230+ countries |
| Eligibility | Compatible AT&T Prepaid line. Regular single-line price; introductory $45 offer excluded. No AutoPay reduction applied. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.att.com/att/prepaid-family/)

### 4 $10 Prepaid Account Credit

Adds $10 toward account charges. This alone does not renew a monthly plan; balance expiry applies.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Refill credit (`refill`) |
| Period | Account credit — no included service term |
| Database validity days | 0 |
| Data | No data bundle included |
| Calls | Depends on existing plan |
| Texts | Depends on existing plan |
| Eligibility | Existing AT&T Prepaid account. Official debit/credit-card minimum is $10; full plan balance required for renewal. $10 credit expires in 30 days. Taxes or channel fees may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.att.com/support/article-modal/wireless/KM1008656/)

### 5 $20 Prepaid Account Credit

Adds $20 toward account charges. This alone does not renew a monthly plan; balance expiry applies.

| Field | Catalog value |
| --- | --- |
| Price | USD $20.00 (2000 cents) |
| Category | Refill credit (`refill`) |
| Period | Account credit — no included service term |
| Database validity days | 0 |
| Data | No data bundle included |
| Calls | Depends on existing plan |
| Texts | Depends on existing plan |
| Eligibility | Existing AT&T Prepaid account. Full plan balance is required for renewal; $20 account payments expire in 30 days. Taxes or channel fees may apply. |
| Request availability | Selectable for unpaid requests |

[Product source](https://www.att.com/support/article-modal/wireless/KM1008656/)

### 6 5GB Hotspot Add-on

Adds hotspot data to an eligible prepaid plan. Base service and taxes cost extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Add-ons (`addon`) |
| Period | Per month — eligible base plan required |
| Database validity days | 0 |
| Data | 5GB hotspot data |
| Calls | None added |
| Texts | None added |
| Eligibility | Add in the AT&T Prepaid account. Confirm base-plan compatibility and add-on renewal date with AT&T. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.att.com/prepaid/plans/)

### 7 International 250 Minutes

International calling add-on for an active voice plan. Tax extra; eligible destinations only.

| Field | Catalog value |
| --- | --- |
| Price | USD $10.00 (1000 cents) |
| Category | Add-ons (`addon`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | None added |
| Calls | 250 minutes from the U.S. to 70 countries |
| Texts | None added |
| Eligibility | Active voice plan and unexpired account balance. Add through AT&T; unused minutes roll over if renewed before expiry. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.att.com/prepaid/international-calling/)

### 8 International Plus

International calling add-on for a monthly or multi-month voice plan. Tax extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $15.00 (1500 cents) |
| Category | Add-ons (`addon`) |
| Period | 30 days |
| Database validity days | 30 |
| Data | None added |
| Calls | Unlimited U.S. calls to 85+ countries; discounted rates to 140 more |
| Texts | None added |
| Eligibility | Active monthly or multi-month voice plan and unexpired balance. Add through AT&T; eligible numbers and destinations only. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.att.com/prepaid/international-calling/)

### 9 Online Unlimited — New Single Line

Online new-line offer with a five-year price lock. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $25.00 (2500 cents) |
| Category | Special offers (`offer`) |
| Period | Per month — qualifying new line |
| Database validity days | 30 |
| Data | Unlimited; first 30GB at up to 3Mbps, then up to 1.5Mbps |
| Calls | Unlimited nationwide |
| Texts | Unlimited domestic; U.S. texting to 230+ countries |
| Eligibility | New single-line customers only; activate through AT&T online. Not a general $25 refill or dealer price. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.att.com/prepaid/plans/)

### 10 Unlimited Ultra — First Six Months

$45 per month for six months, then $60. Includes 30GB hotspot; taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $45.00 (4500 cents) |
| Category | Special offers (`offer`) |
| Period | Per month for first 6 months; then $60/month |
| Database validity days | 30 |
| Data | Unlimited high-speed data with 5G |
| Calls | Unlimited between the U.S., Mexico and Canada |
| Texts | Unlimited domestic; U.S. texting to 230+ countries |
| Eligibility | Online activation on a new single line through AT&T required. Not an existing-line refill discount. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.att.com/prepaid/international-calling/)

### 11 12-Month Unlimited — $240 Upfront

Pay $240 upfront for 12 months; advertised equivalent $20/month. Taxes and fees extra.

| Field | Catalog value |
| --- | --- |
| Price | USD $240.00 (24000 cents) |
| Category | Special offers (`offer`) |
| Period | 12 months prepaid — $240 upfront |
| Database validity days | 0 |
| Data | 16GB high-speed per month, then up to 1.5Mbps; 10GB hotspot |
| Calls | Unlimited nationwide; U.S. calls to Mexico and Canada |
| Texts | Unlimited domestic; U.S. texting to 230+ countries |
| Eligibility | Online only; SIM or phone purchase and activation on a new single line required. Buy through AT&T; no $20 month-by-month refill. |
| Request availability | Carrier link only; request selection blocked |

[Product source](https://www.att.com/prepaid/plans/)

## Updating this reference

After a reviewed catalog change, reconcile this reference with the generated JSON and SQL. Do not edit this document as a substitute for changing the runtime catalog. Preserve full upfront payments and conditions rather than turning advertised monthly equivalents or referral rewards into unconditional refill prices.
