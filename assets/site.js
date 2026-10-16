'use strict';
const menu=document.querySelector('.menu-toggle');
menu?.addEventListener('click',()=>{const open=menu.getAttribute('aria-expanded')!=='true';menu.setAttribute('aria-expanded',String(open));document.querySelector('#main-nav').classList.toggle('open',open);});
document.querySelectorAll('#main-nav a').forEach(a=>a.addEventListener('click',()=>{menu?.setAttribute('aria-expanded','false');document.querySelector('#main-nav').classList.remove('open');}));
document.querySelector('#carrier-search')?.addEventListener('input',e=>{const q=e.target.value.trim().toLowerCase();let visible=0;document.querySelectorAll('[data-carrier]').forEach(card=>{card.hidden=!card.dataset.carrier.includes(q);if(!card.hidden)visible++;});document.querySelector('#no-carriers').hidden=visible>0;});
document.querySelectorAll('[data-confirm]').forEach(form=>form.addEventListener('submit',e=>{if(!confirm(form.dataset.confirm))e.preventDefault();}));
document.querySelectorAll('input[type=tel]').forEach(input=>input.addEventListener('blur',()=>{let digits=input.value.replace(/\D/g,'');if(digits.length===11&&digits[0]==='1')digits=digits.slice(1);if(digits.length===10)input.value=`(${digits.slice(0,3)}) ${digits.slice(3,6)}-${digits.slice(6)}`;}));
document.querySelectorAll('[data-password-toggle]').forEach(button=>button.addEventListener('click',()=>{const field=document.getElementById(button.dataset.passwordToggle);field.type=field.type==='password'?'text':'password';button.textContent=field.type==='password'?'Show':'Hide';}));
