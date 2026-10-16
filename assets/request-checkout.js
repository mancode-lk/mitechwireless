'use strict';
(() => {
 const form=document.querySelector('#request-details-form');if(!form)return;
 const payment=document.querySelector('#request-payment'),error=document.querySelector('#request-error');
 const next=document.querySelector('#request-continue'),submit=document.querySelector('#request-submit'),edit=document.querySelector('#request-edit');
 // These nameless inputs are outside every form. Never serialize them, persist
 // them in storage, or pass their values to fetch or a gateway placeholder.
 const cardholder=document.querySelector('#payment-cardholder'),number=document.querySelector('#payment-number'),expiry=document.querySelector('#payment-expiry'),cvc=document.querySelector('#payment-cvc');
 const cardFields=[cardholder,number,expiry,cvc];
 function clearCard(){for(const input of cardFields){input.value='';input.setCustomValidity('');}}
 function validateCard(){
  for(const input of cardFields)input.setCustomValidity('');
  const digits=number.value.replace(/\s/g,'');let sum=0,double=false;
  for(let i=digits.length-1;i>=0;i--){let digit=Number(digits[i]);if(double){digit*=2;if(digit>9)digit-=9;}sum+=digit;double=!double;}
  if(!/^\d{13,19}$/.test(digits)||sum%10!==0)number.setCustomValidity('Enter a valid card number.');
  const match=expiry.value.match(/^(\d{2})\s*\/\s*(\d{2})$/),now=new Date();
  if(!match||Number(match[1])<1||Number(match[1])>12||new Date(2000+Number(match[2]),Number(match[1]),1)<=new Date(now.getFullYear(),now.getMonth(),1))expiry.setCustomValidity('Enter a current or future expiry date as MM / YY.');
  if(!/^\d{3,4}$/.test(cvc.value))cvc.setCustomValidity('Enter the 3 or 4 digit security code.');
  if(!cardholder.value.trim())cardholder.setCustomValidity('Enter the name on the card.');
  for(const input of cardFields)if(!input.reportValidity())return false;
  return true;
 }
 number.addEventListener('input',()=>{number.value=number.value.replace(/\D/g,'').slice(0,19).replace(/(.{4})/g,'$1 ').trim();number.setCustomValidity('');});
 expiry.addEventListener('input',()=>{const digits=expiry.value.replace(/\D/g,'').slice(0,4);expiry.value=digits.length>2?digits.slice(0,2)+' / '+digits.slice(2):digits;expiry.setCustomValidity('');});
 cvc.addEventListener('input',()=>{cvc.value=cvc.value.replace(/\D/g,'').slice(0,4);cvc.setCustomValidity('');});
 cardholder.addEventListener('input',()=>cardholder.setCustomValidity(''));
 window.addEventListener('pagehide',clearCard);window.addEventListener('pageshow',clearCard);
 let reference='',busy=false;
 function fail(message){error.textContent=message;error.hidden=false;error.scrollIntoView({block:'center'});}
 function setBusy(value){busy=value;next.disabled=value;submit.disabled=value;edit.disabled=value;}
 async function send(url,data){const r=await fetch(url,{method:'POST',body:data,credentials:'same-origin'});const result=await r.json();if(!r.ok)throw new Error(result.error||'Please try again.');return result;}
 form.addEventListener('submit',async event=>{
  event.preventDefault();if(busy)return;error.hidden=true;setBusy(true);
  try{
   const body=new URLSearchParams();
   for(const key of ['csrf','checkout_key','plan_id','carrier_id','name','email','phone','consent'])body.set(key,form.elements.namedItem(key).value);
   const result=await send('/api/checkout-request/details',body);reference=result.reference;
   if(result.completed){location.assign(result.redirect);return;}
   document.querySelector('#request-review').textContent=`${form.elements.namedItem('name').value} · ${form.elements.namedItem('email').value} · ${form.elements.namedItem('phone').value}`;
   form.hidden=true;payment.hidden=false;
   document.querySelector('#request-step-details').className='complete';document.querySelector('#request-step-payment').className='current';
   document.querySelector('#request-payment-title').focus();
  }catch(e){fail(e.message||'Unable to save your details.');}finally{setBusy(false);}
 });
 submit.addEventListener('click',async()=>{
  if(busy||!validateCard())return;error.hidden=true;clearCard();setBusy(true);
  try{
   const result=await send('/api/checkout-request/complete',new URLSearchParams({csrf:form.elements.namedItem('csrf').value,reference}));
   location.assign(result.redirect);
  }catch(e){fail(e.message||'Unable to submit your request.');}finally{setBusy(false);}
 });
 edit.addEventListener('click',()=>{if(busy)return;clearCard();error.hidden=true;payment.hidden=true;form.hidden=false;document.querySelector('#request-step-details').className='current';document.querySelector('#request-step-payment').className='';document.querySelector('#request-name').focus();});
})();
