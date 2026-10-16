import json
from pathlib import Path
root=Path(__file__).resolve().parents[1]
data=json.loads((root/'research/carriers.json').read_text(encoding='utf-8-sig'))
def q(v):
    if v is None: return 'NULL'
    if isinstance(v,(int,float)):return str(v)
    return "'"+str(v).replace('\\','\\\\').replace("'","''")+"'"
settings={
 'site_name':'MI Tech Wireless','site_logo':'/assets/brand/logo.svg',
 'color_primary':'#e21e2c','color_secondary':'#17191d','color_accent':'#fff1f2',
 'support_email':'info@mitechwireless.com','sender_email':'info@mitechwireless.com',
 'support_phone':'','support_hours':'','business_address':'',
 'hero_title':'More connection.','hero_accent':'Less complication.',
 'hero_description':'Top up your US prepaid phone in a few simple steps. Your number, your carrier, your connection — all in one place.',
 'stripe_mode':'test','checkout_enabled':'0','stripe_test_publishable':'','stripe_test_secret':'','stripe_test_webhook':'',
 'stripe_live_publishable':'','stripe_live_secret':'','stripe_live_webhook':'',
 'smtp_host':'','smtp_port':'587','smtp_security':'tls','smtp_username':'info@mitechwireless.com','smtp_password':'',
 'footer_links':'[]',
 'faqs':json.dumps([
  {'question':'How does a prepaid top-up work?','answer':'Choose the carrier for your existing US prepaid number, select an eligible refill, and pay securely. Our team processes the recharge manually. A payment receipt confirms your payment; a separate completion email confirms the recharge.'},
  {'question':'Do I need to create an account?','answer':'No. You can check out without creating an account. Keep your order ID and checkout email to track your order or contact support.'},
  {'question':'How long will my recharge take?','answer':'Our team fulfills orders manually after payment is confirmed. Timing depends on carrier availability and eligibility checks. We do not promise instant completion. Check your order status online or contact support for an update.'},
  {'question':'Can I top up someone else’s phone?','answer':'Yes, if you are authorized to recharge the number and use the payment method. Confirm the recipient’s current prepaid carrier and exact mobile number before paying.'},
  {'question':'What if I enter the wrong number or carrier?','answer':'Contact us immediately with your order ID. We will check whether fulfillment can still be stopped. Once a refill is delivered, carriers generally cannot move or reverse it.'},
  {'question':'Which payment methods can I use?','answer':'When online checkout is enabled, card payments are handled securely by Stripe. The site does not receive or store your full card number or CVV. All prices and payments are in USD.'},
  {'question':'Can I recharge a postpaid or international number?','answer':'This store is intended for eligible US prepaid accounts. It does not support postpaid bill payments, international numbers, new-line activation, or number transfers. Some carriers and plans have additional restrictions.'},
  {'question':'How do I track my order?','answer':'Open Track order and enter your order ID plus the email used at checkout. Payment and recharge statuses are shown separately so you can see whether the refill is still processing or completed.'},
  {'question':'Is this an automatic recurring payment?','answer':'No. Each order is a one-time payment. MI Tech Wireless does not enroll you in a recurring subscription. Your existing carrier account may have its own AutoPay settings.'}
 ],ensure_ascii=False)
}
sql=['-- Starter catalog researched 2026-10-15. Every plan requires verification before purchase.','-- No administrator with a universal password is seeded; tools/install.php generates unique credentials.']
for i,c in enumerate(data,1):
    description='Explore prepaid options for your existing '+c['name']+' number. Confirm your plan is eligible before ordering.'
    if not c['plans']:description='Contact our team to check refill eligibility for your '+c['name']+' account. Online refill options are not yet confirmed.'
    values=[i,c['name'],c['slug'],c['color'],description,'Enter your existing 10-digit US prepaid mobile number.',c['source_url'],1,i*10]
    sql.append('INSERT INTO carriers (id,name,slug,color,description,number_hint,source_url,active,sort_order) VALUES ('+','.join(map(q,values))+');')
    for j,p in enumerate(c['plans'],1):
        title=p['name'].replace(' price reference','').replace(' regular-price reference','').replace(' reference','')
        desc=p['description']+' '+c['caveat']
        # Gift-card and account-funding references are retained for Admin review only.
        active=0 if p.get('kind')=='gift_card_value_reference' else 1
        vals=[i,title,p['price_cents'],p.get('data') or '',p.get('talk') or '',p.get('text') or '',p.get('validity_days') or 0,desc,0,active,1,j*10]
        sql.append('INSERT INTO plans (carrier_id,name,price_cents,data_allowance,talk,texts,validity_days,description,popular,active,verify_pricing,sort_order) VALUES ('+','.join(map(q,vals))+');')
for k,v in settings.items():sql.append('INSERT INTO settings (`key`,`value`) VALUES ('+q(k)+','+q(v)+');')
schema=root/'sql/schema.sql'
text=schema.read_text(encoding='utf-8').split('-- BEGIN STARTER SEED')[0].rstrip()+'\n\n-- BEGIN STARTER SEED\n'+'\n'.join(sql)+'\n'
schema.write_text(text,encoding='utf-8')
print(f'Seed: {len(data)} carriers, {sum(len(c["plans"]) for c in data)} plans, {len(settings)} settings')
