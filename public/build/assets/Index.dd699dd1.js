import{s as I,r as l,o as u,k as m,l as e,e as B,f as a,m as R,A as L,p as v,y as M,b as n,v as s,x as i,d as F,a as N,z as j,F as E}from"./app.537b83f5.js";const O={class:"grid grid-cols-3 gap-6"},U={class:"col-span-3 sm:col-span-1"},z={__name:"Filter",emits:["hide"],setup(h,{emit:p}){const d={name:""},c=I({...d});return($,f)=>{const _=l("BaseInput"),y=l("FilterForm");return u(),m(y,{"init-form":d,form:c,onHide:f[1]||(f[1]=k=>p("hide"))},{default:e(()=>[B("div",O,[B("div",U,[a(_,{type:"text",modelValue:c.name,"onUpdate:modelValue":f[0]||(f[0]=k=>c.name=k),name:"name",label:$.$trans("payroll.salary_template.props.name")},null,8,["modelValue","label"])])])]),_:1},8,["form"])}}},q={name:"PayrollSalaryTemplateList"},J=Object.assign(q,{setup(h){const p=R(),d=L("emitter");let c=["filter"];v("salary-template:create")&&c.unshift("create");let $=[];v("salary-template:export")&&($=["print","pdf","excel"]);const f="payroll/salaryTemplate/",_=M(!1),y=I({}),k=o=>{Object.assign(y,o)};return(o,r)=>{const w=l("PageHeaderAction"),S=l("PageHeader"),P=l("ParentTransition"),g=l("DataCell"),C=l("FloatingMenuItem"),D=l("FloatingMenu"),A=l("DataRow"),V=l("BaseButton"),H=l("DataTable"),T=l("ListItem");return u(),m(T,{"init-url":f,onSetItems:k},{header:e(()=>[a(S,{title:o.$trans("payroll.salary_template.salary_template"),navs:[{label:o.$trans("payroll.payroll"),path:"Payroll"}]},{default:e(()=>[a(w,{url:"payroll/salary-templates/",name:"PayrollSalaryTemplate",title:o.$trans("payroll.salary_template.salary_template"),actions:n(c),"dropdown-actions":n($),onToggleFilter:r[0]||(r[0]=t=>_.value=!_.value)},null,8,["title","actions","dropdown-actions"])]),_:1},8,["title","navs"])]),filter:e(()=>[a(P,{appear:"",visibility:_.value},{default:e(()=>[a(z,{onRefresh:r[1]||(r[1]=t=>n(d).emit("listItems")),onHide:r[2]||(r[2]=t=>_.value=!1)})]),_:1},8,["visibility"])]),default:e(()=>[a(P,{appear:"",visibility:!0},{default:e(()=>[a(H,{header:y.headers,meta:y.meta,module:"payroll.salary_template",onRefresh:r[4]||(r[4]=t=>n(d).emit("listItems"))},{actionButton:e(()=>[n(v)("salary-template:create")?(u(),m(V,{key:0,onClick:r[3]||(r[3]=t=>n(p).push({name:"PayrollSalaryTemplateCreate"}))},{default:e(()=>[s(i(o.$trans("global.add",{attribute:o.$trans("payroll.salary_template.salary_template")})),1)]),_:1})):F("",!0)]),default:e(()=>[(u(!0),N(E,null,j(y.data,t=>(u(),m(A,{key:t.uuid},{default:e(()=>[a(g,{name:"name"},{default:e(()=>[s(i(t.name),1)]),_:2},1024),a(g,{name:"alias"},{default:e(()=>[s(i(t.alias),1)]),_:2},1024),a(g,{name:"salaryStructure"},{default:e(()=>[s(i(t.structuresCount),1)]),_:2},1024),a(g,{name:"createdAt"},{default:e(()=>[s(i(t.createdAt),1)]),_:2},1024),a(g,{name:"action"},{default:e(()=>[a(D,null,{default:e(()=>[a(C,{icon:"fas fa-arrow-circle-right",onClick:b=>n(p).push({name:"PayrollSalaryTemplateShow",params:{uuid:t.uuid}})},{default:e(()=>[s(i(o.$trans("general.show")),1)]),_:2},1032,["onClick"]),n(v)("salary-template:edit")?(u(),m(C,{key:0,icon:"fas fa-edit",onClick:b=>n(p).push({name:"PayrollSalaryTemplateEdit",params:{uuid:t.uuid}})},{default:e(()=>[s(i(o.$trans("general.edit")),1)]),_:2},1032,["onClick"])):F("",!0),n(v)("salary-template:create")?(u(),m(C,{key:1,icon:"fas fa-copy",onClick:b=>n(p).push({name:"PayrollSalaryTemplateDuplicate",params:{uuid:t.uuid}})},{default:e(()=>[s(i(o.$trans("general.duplicate")),1)]),_:2},1032,["onClick"])):F("",!0),n(v)("salary-template:delete")?(u(),m(C,{key:2,icon:"fas fa-trash",onClick:b=>n(d).emit("deleteItem",{uuid:t.uuid})},{default:e(()=>[s(i(o.$trans("general.delete")),1)]),_:2},1032,["onClick"])):F("",!0)]),_:2},1024)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["header","meta"])]),_:1})]),_:1})}}});export{J as default};