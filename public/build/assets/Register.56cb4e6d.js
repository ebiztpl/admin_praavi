import{q as v,g as E,s as _,r as l,o as V,a as b,f as t,l as m,F as k,e as w,b as a,v as u,x as d,d as F}from"./app.537b83f5.js";const c={class:"space-y-6"},L={class:"flex items-center justify-center"},N={key:0,class:"flex items-center justify-center"},j={__name:"Register",setup(q){const p="auth/register/",s=v(p),y=E("auth.enableEmailVerification"),f={name:"",email:"",username:"",password:"",passwordConfirmation:""},o=_({...f});return(n,e)=>{const B=l("GuestHeader"),i=l("BaseInput"),g=l("BaseLink"),U=l("BaseButton"),C=l("FormAction"),$=l("ParentTransition");return V(),b(k,null,[t(B,{label:n.$trans("auth.register.register_title")},null,8,["label"]),t($,{appear:"",visibility:!0},{default:m(()=>[t(C,{"no-card":"","no-action-button":"","init-url":p,"init-form":f,form:o,action:"register",redirect:"Login"},{default:m(()=>[w("div",c,[t(i,{type:"text",modelValue:o.name,"onUpdate:modelValue":e[0]||(e[0]=r=>o.name=r),name:"name",label:n.$trans("auth.register.props.name"),error:a(s).name,"onUpdate:error":e[1]||(e[1]=r=>a(s).name=r),autofocus:""},null,8,["modelValue","label","error"]),t(i,{type:"text",modelValue:o.email,"onUpdate:modelValue":e[2]||(e[2]=r=>o.email=r),name:"email",label:n.$trans("auth.register.props.email"),error:a(s).email,"onUpdate:error":e[3]||(e[3]=r=>a(s).email=r)},null,8,["modelValue","label","error"]),t(i,{type:"text",modelValue:o.username,"onUpdate:modelValue":e[4]||(e[4]=r=>o.username=r),name:"username",label:n.$trans("auth.register.props.username"),error:a(s).username,"onUpdate:error":e[5]||(e[5]=r=>a(s).username=r)},null,8,["modelValue","label","error"]),t(i,{type:"password",modelValue:o.password,"onUpdate:modelValue":e[6]||(e[6]=r=>o.password=r),name:"password",label:n.$trans("auth.register.props.password"),error:a(s).password,"onUpdate:error":e[7]||(e[7]=r=>a(s).password=r)},null,8,["modelValue","label","error"]),t(i,{type:"password",modelValue:o.passwordConfirmation,"onUpdate:modelValue":e[8]||(e[8]=r=>o.passwordConfirmation=r),name:"passwordConfirmation",label:n.$trans("auth.register.props.password_confirmation"),error:a(s).passwordConfirmation,"onUpdate:error":e[9]||(e[9]=r=>a(s).passwordConfirmation=r)},null,8,["modelValue","label","error"]),w("div",L,[t(g,{to:"Login"},{default:m(()=>[u(d(n.$trans("auth.login.login_title")),1)]),_:1})]),t(U,{type:"submit",block:""},{default:m(()=>[u(d(n.$trans("auth.register.register")),1)]),_:1}),a(y)?(V(),b("div",N,[t(g,{to:"EmailRequest"},{default:m(()=>[u(d(n.$trans("auth.register.email_request_description")),1)]),_:1})])):F("",!0)])]),_:1},8,["form"])]),_:1})],64)}}};export{j as default};