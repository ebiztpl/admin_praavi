import{u as _,q as v,s as C,r as s,o as f,k as g,l as c,e as m,f as r,b as a}from"./app.537b83f5.js";const P={class:"grid grid-cols-3 gap-6"},A={class:"col-span-3 sm:col-span-1"},B={class:"col-span-3 sm:col-span-1"},F={name:"LocaleForm"},U=Object.assign(F,{setup(b){const i=_(),d={name:"",code:""},l="config/locale/",t=v(l),e=C({...d});return(p,o)=>{const u=s("BaseInput"),V=s("FormAction");return f(),g(V,{"init-url":l,"init-form":d,form:e,redirect:"ConfigLocale"},{default:c(()=>[m("div",P,[m("div",A,[r(u,{type:"text",modelValue:e.name,"onUpdate:modelValue":o[0]||(o[0]=n=>e.name=n),name:"name",label:p.$trans("config.locale.props.name"),error:a(t).name,"onUpdate:error":o[1]||(o[1]=n=>a(t).name=n),autofocus:""},null,8,["modelValue","label","error"])]),m("div",B,[r(u,{disabled:a(i).meta.type==="edit",type:"text",modelValue:e.code,"onUpdate:modelValue":o[2]||(o[2]=n=>e.code=n),name:"code",label:p.$trans("config.locale.props.code"),error:a(t).code,"onUpdate:error":o[3]||(o[3]=n=>a(t).code=n),autofocus:""},null,8,["disabled","modelValue","label","error"])])])]),_:1},8,["form"])}}}),$={name:"LocaleAction"},y=Object.assign($,{setup(b){return _(),(i,d)=>{const l=s("PageHeaderAction"),t=s("ParentTransition"),e=s("ConfigPage");return f(),g(e,{"no-background":""},{action:c(()=>[r(l,{name:"ConfigLocale",title:i.$trans("config.locale.locale"),actions:["list"]},null,8,["title"])]),default:c(()=>[r(t,{appear:"",visibility:!0},{default:c(()=>[r(U)]),_:1})]),_:1})}}});export{y as default};
