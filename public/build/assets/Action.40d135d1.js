import{u as _,q as T,s as V,r as a,o as f,k as g,l as c,e as s,f as i,b as r,x as d}from"./app.537b83f5.js";const B={class:"grid grid-cols-1 gap-6"},P={class:"col-span-1"},$={class:"col-span-1"},y={class:"col-span-1"},A={class:"text-sm"},F={name:"ConfigMailTemplateForm"},U=Object.assign(F,{setup(b){const m=_(),p={subject:"",content:"",variablesDisplay:""},l="config/mailTemplate/",n=T(l),e=V({...p});return(u,t)=>{const v=a("BaseInput"),j=a("BaseEditor"),C=a("FormAction");return f(),g(C,{"init-url":l,"init-form":p,form:e,redirect:"ConfigMailTemplate"},{default:c(()=>[s("div",B,[s("div",P,[i(v,{type:"text",modelValue:e.subject,"onUpdate:modelValue":t[0]||(t[0]=o=>e.subject=o),name:"subject",label:u.$trans("config.mail.template.props.subject"),error:r(n).subject,"onUpdate:error":t[1]||(t[1]=o=>r(n).subject=o),autofocus:""},null,8,["modelValue","label","error"])]),s("div",$,[i(j,{id:"Testing",modelValue:e.content,"onUpdate:modelValue":t[2]||(t[2]=o=>e.content=o),name:"content",edit:!!r(m).params.uuid,label:u.$trans("config.mail.template.props.content"),error:r(n).content,"onUpdate:error":t[3]||(t[3]=o=>r(n).content=o)},null,8,["modelValue","edit","label","error"])]),s("div",y,[s("p",A,d(u.$trans("config.mail.template.available_variables"))+": "+d(e.variablesDisplay),1)])])]),_:1},8,["form"])}}}),k={name:"ConfigMailTemplateAction"},M=Object.assign(k,{setup(b){return _(),(m,p)=>{const l=a("PageHeaderAction"),n=a("ParentTransition"),e=a("ConfigPage");return f(),g(e,{"no-background":""},{action:c(()=>[i(l,{name:"ConfigMailTemplate",title:m.$trans("config.mail.template.template"),actions:["list"]},null,8,["title"])]),default:c(()=>[i(n,{appear:"",visibility:!0},{default:c(()=>[i(U)]),_:1})]),_:1})}}});export{M as default};
