'use strict';
(()=>{
 const buttons=[...document.querySelectorAll('[data-catalog-filter]')],cards=[...document.querySelectorAll('[data-catalog-category]')],status=document.querySelector('.catalog-count');
 for(const button of buttons)button.addEventListener('click',()=>{
  const kind=button.dataset.catalogFilter;let count=0;
  for(const card of cards){card.hidden=kind!=='all'&&card.dataset.catalogCategory!==kind;if(!card.hidden)count++;}
  for(const option of buttons)option.setAttribute('aria-pressed',String(option===button));
  if(status)status.textContent=count+' '+(count===1?'option':'options')+' available';
 });
})();
