from pathlib import Path
import json
root=Path(__file__).resolve().parents[1]
catalog=json.loads((root/'research/seven-carrier-plans.json').read_text(encoding='utf8'))
logos=json.loads((root/'research/seven-carrier-logos.json').read_text(encoding='utf8'))
items=logos if isinstance(logos,list) else logos.get('logos',logos.get('carriers',[]))
logos={x['slug']:x for x in items}
order=['simple-mobile','t-mobile','lyca-mobile','ultra-mobile','h2o-wireless','verizon']
carriers={c['slug']:c for c in catalog['carriers']}
if set(carriers)!=set(order):raise RuntimeError('Research must match final six-carrier scope')
# Keep research notes intact while giving customers concise plan information.
carriers['simple-mobile']['description']='Monthly unlimited talk, text and data for Simple Mobile prepaid numbers. Plan availability and final charges are confirmed before payment.'
carriers['simple-mobile']['plans'][0]['description']='Published carrier price; availability, hotspot allowance and final charges require confirmation. Data may slow during congestion. Expanded international calling requires activation on the Verizon network.'
carriers['simple-mobile']['plans'][1]['description']='Published carrier price; availability, hotspot allowance and final charges require confirmation. Data may slow during congestion. 5G Ultra Wideband requires a compatible phone and coverage.'
carriers['lyca-mobile']['description']='30-day plans with nationwide calls, texts and international calling to eligible destinations. Regular prices shown; introductory discounts excluded. An unlocked compatible phone is required.'
for p in carriers['lyca-mobile']['plans']:
    hotspot={1900:'Mobile hotspot supported; confirm the allowance.',2300:'Includes up to 8GB high-speed hotspot within your plan allowance.',2900:'Includes up to 10GB high-speed hotspot within your plan allowance.'}[p['price_cents']]
    p['description']=hotspot+' Data speeds may slow during congestion. Lyca applies a 5% recovery fee to purchases on its website; final charges will be confirmed before payment.'
carriers['ultra-mobile']['description']='Monthly plans with unlimited nationwide calls and texts. Regular single-line prices shown; multi-month discounts excluded. Taxes and fees extra. An unlocked compatible phone is required.'
def q(v):return "'"+str(v).replace('\\','\\\\').replace("'","''")+"'"
sql=['-- Selected US prepaid catalog checked 2026-10-15.','-- Preserve all order/customer/contact records. Existing catalog rows are hidden rather than deleted.','SET NAMES utf8mb4;','START TRANSACTION;','UPDATE carriers SET active=0;','UPDATE plans SET active=0 WHERE carrier_id IN (SELECT id FROM carriers WHERE slug IN ('+','.join(map(q,order))+'));']
count=0
for index,slug in enumerate(order,1):
    c=carriers[slug];logo='/'+logos[slug]['file'].lstrip('/')
    if not (root/logo.lstrip('/')).is_file():raise RuntimeError('Missing logo '+logo)
    sql.append('UPDATE carriers SET active=1,name='+q(c['name'])+',logo='+q(logo)+',sort_order='+str(index*10)+',description='+q(c['description'])+',source_url='+q(c['source_url'])+' WHERE slug='+q(slug)+';')
    for pos,p in enumerate(c['plans'],1):
        if not 100<=p['price_cents']<=200000:raise RuntimeError('Invalid price')
        values={'name':p['name'],'price_cents':p['price_cents'],'data_allowance':p['data_allowance'],'talk':p['talk'],'texts':p['texts'],'validity_days':p['validity_days'],'description':p['description'],'popular':int(pos==2),'active':1,'verify_pricing':1,'sort_order':pos*10}
        # Re-running the migration updates matching catalog entries without duplicating them.
        sql.append('INSERT INTO plans (carrier_id,'+','.join(values)+') SELECT c.id,'+','.join(str(v) if isinstance(v,int) else q(v) for v in values.values())+' FROM carriers c WHERE c.slug='+q(slug)+' AND NOT EXISTS (SELECT 1 FROM plans p WHERE p.carrier_id=c.id AND p.name='+q(p['name'])+');')
        sql.append('UPDATE plans p JOIN carriers c ON c.id=p.carrier_id SET '+','.join('p.'+k+'='+(str(v) if isinstance(v,int) else q(v)) for k,v in values.items())+' WHERE c.slug='+q(slug)+' AND p.name='+q(p['name'])+';')
        count+=1
sql.append("INSERT INTO settings (`key`,`value`) VALUES ('request_checkout_enabled','1') ON DUPLICATE KEY UPDATE `value`='1';")
sql.append('COMMIT;')
(root/'sql/selected-carriers.sql').write_bytes(('\n'.join(sql)+'\n').encode('utf8'))
print(json.dumps({'carriers':len(order),'plans':count,'sql':'sql/selected-carriers.sql'}))
