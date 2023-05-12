import{u as g,s as b,q as v,r as p,o as V,k as A,l as y,e as d,f as r,b as n,a as B,F as T}from"./app.537b83f5.js";const P={class:"grid grid-cols-3 gap-6"},F={class:"col-span-3 sm:col-span-1"},q={class:"col-span-3 sm:col-span-1"},k={class:"col-span-3 sm:col-span-1"},C={class:"col-span-3 sm:col-span-1"},H={class:"col-span-3 sm:col-span-1"},R={class:"col-span-3"},j={name:"AttendanceTypeForm"},E=Object.assign(j,{setup(f){g();const i={name:"",code:"",color:"",category:"",alias:"",description:""},s="attendance/type/",m=b({attendanceCategories:[]}),a=v(s),o=b({...i}),u=l=>{Object.assign(m,l)};return(l,e)=>{const _=p("BaseSelect"),c=p("BaseInput"),U=p("BaseTextarea"),$=p("FormAction");return V(),A($,{"pre-requisites":!0,onSetPreRequisites:u,"init-url":s,"init-form":i,form:o,redirect:"AttendanceType"},{default:y(()=>[d("div",P,[d("div",F,[r(_,{modelValue:o.category,"onUpdate:modelValue":e[0]||(e[0]=t=>o.category=t),name:"category",label:l.$trans("attendance.type.props.category"),options:m.attendanceCategories,error:n(a).category,"onUpdate:error":e[1]||(e[1]=t=>n(a).category=t)},null,8,["modelValue","label","options","error"])]),d("div",q,[r(c,{type:"text",modelValue:o.name,"onUpdate:modelValue":e[2]||(e[2]=t=>o.name=t),name:"name",label:l.$trans("attendance.type.props.name"),error:n(a).name,"onUpdate:error":e[3]||(e[3]=t=>n(a).name=t),autofocus:""},null,8,["modelValue","label","error"])]),d("div",k,[r(c,{type:"text",modelValue:o.alias,"onUpdate:modelValue":e[4]||(e[4]=t=>o.alias=t),name:"alias",label:l.$trans("attendance.type.props.alias"),error:n(a).alias,"onUpdate:error":e[5]||(e[5]=t=>n(a).alias=t)},null,8,["modelValue","label","error"])]),d("div",C,[r(c,{type:"text",modelValue:o.code,"onUpdate:modelValue":e[6]||(e[6]=t=>o.code=t),name:"code",label:l.$trans("attendance.type.props.code"),error:n(a).code,"onUpdate:error":e[7]||(e[7]=t=>n(a).code=t),autofocus:""},null,8,["modelValue","label","error"])]),d("div",H,[r(c,{type:"color",modelValue:o.color,"onUpdate:modelValue":e[8]||(e[8]=t=>o.color=t),name:"color",label:l.$trans("attendance.type.props.color"),error:n(a).color,"onUpdate:error":e[9]||(e[9]=t=>n(a).color=t),autofocus:""},null,8,["modelValue","label","error"])]),d("div",R,[r(U,{modelValue:o.description,"onUpdate:modelValue":e[10]||(e[10]=t=>o.description=t),name:"description",label:l.$trans("attendance.type.props.description"),error:n(a).description,"onUpdate:error":e[11]||(e[11]=t=>n(a).description=t)},null,8,["modelValue","label","error"])])])]),_:1},8,["form"])}}}),O={name:"AttendanceTypeAction"},I=Object.assign(O,{setup(f){const i=g();return(s,m)=>{const a=p("PageHeaderAction"),o=p("PageHeader"),u=p("ParentTransition");return V(),B(T,null,[r(o,{title:s.$trans(n(i).meta.trans,{attribute:s.$trans(n(i).meta.label)}),navs:[{label:s.$trans("attendance.attendance"),path:"Attendance"},{label:s.$trans("attendance.type.type"),path:"AttendanceTypeList"}]},{default:y(()=>[r(a,{name:"AttendanceType",title:s.$trans("attendance.type.type"),actions:["list"]},null,8,["title"])]),_:1},8,["title","navs"]),r(u,{appear:"",visibility:!0},{default:y(()=>[r(E)]),_:1})],64)}}});export{I as default};
