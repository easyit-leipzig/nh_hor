(()=>{'use strict';
const form=document.getElementById('block-editor-form');if(!form)return;
const defaults={backgroundColor:'#ffffff',textColor:'#17324d',accentColor:'#0057a4',buttonColor:'#0057a4',buttonTextColor:'#ffffff',padding:32,gap:32,borderRadius:20,borderWidth:0,borderColor:'#cad8e4',shadow:'medium',minHeight:220,imageWidth:280,imageHeight:220,imageRadius:16,imageFit:'cover',imagePosition:'center center',layout:'image-left',textAlign:'left',titleSize:32,contentSize:16,hoverEffect:'lift'};
const hidden=document.getElementById('style_json'),preview=document.getElementById('block-preview'),image=document.getElementById('preview-image'),cssBox=document.getElementById('custom_css'),warning=document.getElementById('css-warning');
let state={...defaults};try{state={...state,...JSON.parse(hidden.value||'{}')}}catch(e){}
const shadows={none:'none',soft:'0 4px 14px rgba(0,0,0,.08)',medium:'0 8px 25px rgba(0,0,0,.12)',strong:'0 16px 38px rgba(0,0,0,.22)'};
const badCss=s=>/[{}]|@import|<\/?style|expression\s*\(|javascript\s*:|behavior\s*:|-moz-binding/i.test(s);
function apply(){
 hidden.value=JSON.stringify(state); const v=(n,x)=>preview.style.setProperty(n,x);
 v('--hb-bg',state.backgroundColor);v('--hb-text',state.textColor);v('--hb-accent',state.accentColor);v('--hb-button',state.buttonColor);v('--hb-button-text',state.buttonTextColor);v('--hb-padding',state.padding+'px');v('--hb-gap',state.gap+'px');v('--hb-radius',state.borderRadius+'px');v('--hb-border-width',state.borderWidth+'px');v('--hb-border',state.borderColor);v('--hb-min-height',state.minHeight+'px');v('--hb-image-width',state.imageWidth+'px');v('--hb-image-height',state.imageHeight+'px');v('--hb-image-radius',state.imageRadius+'px');v('--hb-title-size',state.titleSize+'px');v('--hb-content-size',state.contentSize+'px');
 preview.style.textAlign=state.textAlign;preview.style.boxShadow=shadows[state.shadow]||shadows.medium;image.style.objectFit=state.imageFit;image.style.objectPosition=state.imagePosition;
 preview.className='homepage-block-editor-preview layout-'+state.layout+' hover-'+state.hoverEffect;
 const custom=cssBox.value.trim();warning.hidden=true;preview.style.cssText=preview.style.cssText.replace(/;?\s*--expert-marker:[^;]+;?/g,'');
 if(custom){if(badCss(custom)){warning.textContent='Nicht erlaubtes CSS erkannt. Die Vorschau übernimmt diese Eingabe nicht.';warning.hidden=false;}else{preview.style.cssText+=';'+custom+';--expert-marker:1';}}
}
document.querySelectorAll('[data-style]').forEach(el=>{const key=el.dataset.style;if(state[key]!==undefined)el.value=state[key];el.addEventListener('input',()=>{state[key]=el.type==='range'?Number(el.value):el.value;const out=document.querySelector('[data-output="'+key+'"]');if(out)out.textContent=el.value+(el.dataset.unit||'');apply();});});
document.querySelectorAll('[data-preview]').forEach(el=>el.addEventListener('input',()=>{const key=el.dataset.preview,target={title:'preview-title',content:'preview-text',buttonText:'preview-button'}[key];if(target)document.getElementById(target).textContent=el.value||({title:'Titel der Block-Kachel',content:'Hier erscheint der Inhalt der Kachel.',buttonText:'Mehr erfahren'}[key]);}));
document.getElementById('image-upload').addEventListener('change',e=>{const f=e.target.files&&e.target.files[0];if(f&&f.type.startsWith('image/'))image.src=URL.createObjectURL(f);});
document.querySelectorAll('[data-viewport]').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('[data-viewport]').forEach(b=>b.classList.remove('is-active'));btn.classList.add('is-active');document.getElementById('preview-stage').dataset.viewport=btn.dataset.viewport;}));
document.getElementById('editor-reset').addEventListener('click',()=>{state={...defaults};document.querySelectorAll('[data-style]').forEach(el=>{el.value=state[el.dataset.style];const out=document.querySelector('[data-output="'+el.dataset.style+'"]');if(out)out.textContent=el.value+(el.dataset.unit||'');});apply();});
cssBox.addEventListener('input',apply);form.addEventListener('submit',e=>{if(badCss(cssBox.value)){e.preventDefault();warning.textContent='Das Experten-CSS enthält nicht erlaubte Anweisungen und kann nicht gespeichert werden.';warning.hidden=false;warning.scrollIntoView({behavior:'smooth',block:'center'});}});apply();
})();
