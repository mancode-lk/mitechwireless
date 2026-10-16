from pathlib import Path
import json,copy
root=Path(__file__).resolve().parents[1]
order=['simple-mobile','t-mobile','lyca-mobile','ultra-mobile','h2o-wireless','att']
carriers={c['slug']:c for fn in ['expanded-a.json','expanded-b.json'] for c in json.loads((root/'research'/fn).read_text(encoding='utf8'))['carriers']}
old={c['slug']:c for c in json.loads((root/'research/seven-carrier-plans.json').read_text(encoding='utf8'))['carriers']}
for slug,prices in [('lyca-mobile',[2300,2900]),('ultra-mobile',[2900,3900])]:
    for source in old[slug]['plans']:
        if source['price_cents'] in prices:
            p=copy.deepcopy(source);p.update(category='monthly',period_label='30 days',eligibility='Regular single-month price for an eligible existing line. Compatible phone required; taxes and fees may apply.',selectable=True)
            if slug=='lyca-mobile':p['description']='High-speed data with unlimited nationwide calls and texts. Data speeds are reduced after the allowance. International destination restrictions apply; carrier website purchases add a 5% recovery fee.'
            carriers[slug]['plans'].append(p)
p=copy.deepcopy(next(p for p in carriers['att']['plans'] if p['category']=='refill'))
p.update(name='$20 Prepaid Account Credit',price_cents=2000,description='Adds $20 toward account charges. This alone does not renew a monthly plan; balance expiry applies.',eligibility='Existing AT&T Prepaid account. Full plan balance is required for renewal; $20 account payments expire in 30 days. Taxes or channel fees may apply.')
carriers['att']['plans'].append(p)
p=copy.deepcopy(next(p for p in carriers['h2o-wireless']['plans'] if p['category']=='refill' and p['price_cents']==1000))
p.update(name='$30 Pay As You Go credit',price_cents=3000,description='$30 shared usage credit; service stops when credit runs out. MMS consumes data.',eligibility='H2O PAYG account required. Recharge the same denomination before expiry for balance rollover. $27 with AutoPay; taxes and fees extra.')
carriers['h2o-wireless']['plans'].append(p)
p=copy.deepcopy(next(p for p in carriers['ultra-mobile']['plans'] if p['name'].startswith('25GB')))
p.update(name='25GB introductory 12-month offer',price_cents=24000,validity_days=0,description='$240 upfront for twelve months, equivalent to $20 per month. Includes 25GB high-speed data per monthly cycle.',period_label='12 months prepaid; $240 upfront',eligibility='New-customer carrier offer. Full payment for twelve months required; taxes and fees extra. Confirm renewal pricing with Ultra.',source_url='https://www.ultramobile.com/all-promotional-offers-terms-conditions/')
carriers['ultra-mobile']['plans'].append(p)
carriers['simple-mobile']['description']='30-day talk and data packages plus international calling credit. Published monthly prices are shown; availability and final charges require confirmation.'
carriers['att']['description']='AT&T Prepaid monthly packages, account refill credit, calling add-ons and online offers. Taxes and fees may apply; check the conditions on each option.'
for p in carriers['simple-mobile']['plans']:
    if p['category']=='addon':p['period_label']='International calling credit';p['eligibility']+=' Credit expires 180 days after last use or 30 days after service suspension, whichever is earlier.'
    else:p['description']=p['description'].replace('Current checkout availability unverified.','Confirm current availability before payment.')
for c in carriers.values():
    c['plans'].sort(key=lambda p:({'monthly':0,'refill':1,'addon':2,'offer':3}[p['category']],p['price_cents'],p['name']))
    assert len({p['name'].lower() for p in c['plans']})==len(c['plans'])
    for p in c['plans']:
        assert all(len(p[k])<=size for k,size in [('name',150),('talk',100),('texts',100),('data_allowance',100)])
        assert p['source_url'].startswith('https://') and 100<=p['price_cents']<=200000
        assert p['category']!='offer' or not p['selectable']
catalog={'checked_date':'2026-10-15','carriers':[carriers[s] for s in order]}
(root/'research/expanded-catalog.json').write_text(json.dumps(catalog,indent=2,ensure_ascii=False)+'\n',encoding='utf8')
logos={x['slug']:'/'+x['file'] for x in json.loads((root/'research/seven-carrier-logos.json').read_text(encoding='utf8'))}
def q(v):return "'"+str(v).replace('\\','\\\\').replace("'","''")+"'"
sql=['-- Expanded US catalog checked 2026-10-15; Verizon replaced by AT&T.','-- No orders, customers or contact records are deleted or altered.','SET NAMES utf8mb4;','START TRANSACTION;','UPDATE carriers SET active=0;','UPDATE plans SET active=0 WHERE carrier_id IN (SELECT id FROM carriers WHERE slug IN ('+','.join(map(q,order))+'));']
for i,c in enumerate(catalog['carriers'],1):
    slug=c['slug'];sql.append('UPDATE carriers SET active=1,name='+q(c['name'])+',logo='+q(logos[slug])+',sort_order='+str(i*10)+',description='+q(c['description'])+',source_url='+q(c['source_url'])+' WHERE slug='+q(slug)+';')
    for j,p in enumerate(c['plans'],1):
        values={k:p[k] for k in ['name','price_cents','data_allowance','talk','texts','validity_days','description']};values.update(popular=0,active=1,verify_pricing=1,sort_order=j*10)
        sql.append('INSERT INTO plans (carrier_id,'+','.join(values)+') SELECT c.id,'+','.join(str(v) if isinstance(v,int) else q(v) for v in values.values())+' FROM carriers c WHERE c.slug='+q(slug)+' AND NOT EXISTS (SELECT 1 FROM plans p WHERE p.carrier_id=c.id AND p.name='+q(p['name'])+');')
        sql.append('UPDATE plans p JOIN carriers c ON c.id=p.carrier_id SET '+','.join('p.'+k+'='+(str(v) if isinstance(v,int) else q(v)) for k,v in values.items())+' WHERE c.slug='+q(slug)+' AND p.name='+q(p['name'])+';')
sql.append('COMMIT;')
(root/'sql/selected-carriers.sql').write_text('\n'.join(sql)+'\n',encoding='utf8')
print(json.dumps({c['name']:len(c['plans']) for c in catalog['carriers']}))
