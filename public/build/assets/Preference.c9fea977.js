import{h as S,A as j,q as B,c as $,s as v,r as F,o as y,k as D,l as i,f as p,v as d,x as r,e as a,b as l,I as R}from"./app.537b83f5.js";const k={class:"grid grid-cols-2 gap-6"},A={class:"col-span-2 sm:col-span-1"},N={class:"col-span-2 sm:col-span-1"},T={class:"text-xs pl-2"},C={class:"text-xs pl-2"},E={class:"col-span-2 sm:col-span-1"},w={class:"text-xs pl-2"},I={class:"text-xs pl-2"},P={class:"col-span-2 sm:col-span-1"},G={name:"UserPreference"},K=Object.assign(G,{setup(H){const _=S(),V=j("moment"),b="user/profile/",n=B(b),g=$(()=>_.getters["auth/user/preference"]),U="config/",c={dateFormat:"",timeFormat:"",locale:"",timezone:""},m=v({}),t=v({...c}),u=s=>V().format(s),z=()=>{Object.assign(c,g.value.system),Object.assign(t,R(c))},x=s=>{Object.assign(m,s)};return(s,o)=>{const f=F("BaseSelect"),O=F("FormAction"),q=F("ParentTransition");return y(),D(q,{appear:"",visibility:!0},{default:i(()=>[p(O,{"no-card":"","init-url":b,"pre-requisite-url":U,"pre-requisites":{data:["dateFormats","timeFormats","locales","timezones"]},onSetPreRequisites:x,"data-fetch":"user",action:"preference",form:t,"init-form":c,setForm:z,"stay-on":"",redirect:"Dashboard"},{title:i(()=>[d(r(s.$trans("user.preference.preference")),1)]),default:i(()=>[a("div",k,[a("div",A,[p(f,{modelValue:t.locale,"onUpdate:modelValue":o[0]||(o[0]=e=>t.locale=e),name:"locale",label:s.$trans("user.preference.props.locale"),"label-prop":"name","value-prop":"uuid",options:m.locales,error:l(n).locale,"onUpdate:error":o[1]||(o[1]=e=>l(n).locale=e)},null,8,["modelValue","label","options","error"])]),a("div",N,[p(f,{modelValue:t.dateFormat,"onUpdate:modelValue":o[2]||(o[2]=e=>t.dateFormat=e),name:"dateFormat",label:s.$trans("user.preference.props.date_format"),options:m.dateFormats,error:l(n).dateFormat,"onUpdate:error":o[3]||(o[3]=e=>l(n).dateFormat=e)},{selectedOption:i(e=>[d(r(u(e.value.value))+" ",1),a("span",T," ("+r(e.value.label)+")",1)]),listOption:i(e=>[d(r(u(e.option.value))+" ",1),a("span",C," ("+r(e.option.label)+")",1)]),_:1},8,["modelValue","label","options","error"])]),a("div",E,[p(f,{modelValue:t.timeFormat,"onUpdate:modelValue":o[4]||(o[4]=e=>t.timeFormat=e),name:"timeFormat",label:s.$trans("user.preference.props.time_format"),options:m.timeFormats,error:l(n).timeFormat,"onUpdate:error":o[5]||(o[5]=e=>l(n).timeFormat=e)},{selectedOption:i(e=>[d(r(u(e.value.value))+" ",1),a("span",w," ("+r(e.value.label)+")",1)]),listOption:i(e=>[d(r(u(e.option.value))+" ",1),a("span",I," ("+r(e.option.label)+")",1)]),_:1},8,["modelValue","label","options","error"])]),a("div",P,[p(f,{modelValue:t.timezone,"onUpdate:modelValue":o[6]||(o[6]=e=>t.timezone=e),name:"timezone",label:s.$trans("user.preference.props.timezone"),options:m.timezones,error:l(n).timezone,"onUpdate:error":o[7]||(o[7]=e=>l(n).timezone=e)},null,8,["modelValue","label","options","error"])])])]),_:1},8,["form"])]),_:1})}}});export{K as default};