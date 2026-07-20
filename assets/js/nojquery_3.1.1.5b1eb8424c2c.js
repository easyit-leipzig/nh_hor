(function(global){
'use strict';
class StorageManager{
  constructor(scope='local',namespace='easyit'){this.scope=scope;this.namespace=namespace}
  get store(){return this.scope==='session'?sessionStorage:localStorage}
  key(k){return `${this.namespace}.${k}`}
  set(k,v){this.store.setItem(this.key(k),JSON.stringify(v));return v}
  get(k,fallback=null){try{const v=this.store.getItem(this.key(k));return v===null?fallback:JSON.parse(v)}catch(e){return fallback}}
  remove(k){this.store.removeItem(this.key(k))}
}
const nj = function(selector,context=document){return Array.from((context||document).querySelectorAll(selector))}
nj.storage={local:new StorageManager('local'),session:new StorageManager('session')}
nj.ready=fn=>document.readyState==='loading'?document.addEventListener('DOMContentLoaded',fn,{once:true}):fn()
nj.on=(target,event,handler,options)=>target.addEventListener(event,handler,options)
global.nj=global._=nj
})(window);
