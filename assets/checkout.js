'use strict';
const form=document.querySelector('#checkout-form');
if(form){
 let stripe=null,elements=null,orderNumber='',busy=false;
 const submit=form.querySelector('#checkout-submit'),errorBox=form.querySelector('#checkout-error');
 function showError(message){errorBox.textContent=message;errorBox.hidden=false;errorBox.scrollIntoView({block:'center',behavior:'smooth'});}
 function setBusy(value){busy=value;submit.disabled=value;submit.textContent=value?'Please wait…':elements?'Pay securely':'Continue to payment';}
 form.addEventListener('submit',async event=>{
  event.preventDefault();if(busy)return;errorBox.hidden=true;setBusy(true);
  try{
   if(!elements){
    if(typeof Stripe!=='function')throw new Error('The secure payment form could not load. Check your connection and refresh.');
    const response=await fetch('/api/checkout',{method:'POST',body:new FormData(form),credentials:'same-origin'});const data=await response.json();
    if(!response.ok)throw new Error(data.error||'Unable to start checkout.');
    stripe=Stripe(data.publishable_key);orderNumber=data.order_number;elements=stripe.elements({clientSecret:data.client_secret,appearance:{theme:'stripe',variables:{colorPrimary:'#df1825',borderRadius:'8px'}}});
    elements.create('payment',{layout:'tabs',defaultValues:{billingDetails:{name:form.elements.name.value,email:form.elements.email.value,phone:form.elements.customer_phone.value,address:{country:'US',postal_code:form.elements.zip.value}}}}).mount('#payment-element');
    form.querySelector('#checkout-fields').hidden=true;form.querySelector('#payment-section').hidden=false;form.querySelector('#edit-details').hidden=false;
    form.querySelector('#payment-review').textContent=`Recharge ${form.elements.phone.value} · Receipt to ${form.elements.email.value}`;
   }else{
    const result=await stripe.confirmPayment({elements,confirmParams:{return_url:location.origin+'/thank-you?order='+encodeURIComponent(orderNumber)},redirect:'if_required'});
    if(result.error)throw new Error(result.error.message||'Payment could not be completed.');
    location.assign('/thank-you?order='+encodeURIComponent(orderNumber));
   }
  }catch(error){showError(error.message||'We couldn’t complete this request. Please try again.');}finally{setBusy(false);}
 });
 form.querySelector('#edit-details').addEventListener('click',()=>{if(busy)return;elements?.getElement('payment')?.destroy();elements=null;stripe=null;form.querySelector('#checkout-fields').hidden=false;form.querySelector('#payment-section').hidden=true;form.querySelector('#edit-details').hidden=true;setBusy(false);});
}
