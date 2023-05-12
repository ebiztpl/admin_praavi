import{u as P,A as _,g as s,p as k,r as d,o as b,a as x,k as y,l,b as a,d as f,f as o,F as C,e as L,v as c,x as u}from"./app.537b83f5.js";const V={class:"grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3"},j={name:"EmployeeShowBasic"},H=Object.assign(j,{props:{employee:{type:Object,default(){return{}}}},setup(e){const p=e,g=P(),t=_("$trans"),h=s("employee.uniqueIdNumber1Label"),N=s("employee.uniqueIdNumber2Label"),B=s("employee.uniqueIdNumber3Label");let r=[];return k("employee:edit")&&(r.push({label:t("global.edit",{attribute:t("employee.employee")}),path:{name:"EmployeeEditBasic",params:{uuid:p.employee.uuid}}}),r.push({label:t("global.edit",{attribute:t("contact.props.photo")}),path:{name:"EmployeeEditPhoto",params:{uuid:p.employee.uuid}}})),(v,w)=>{const q=d("PageHeaderAction"),I=d("PageHeader"),n=d("BaseDataView"),D=d("BaseCard"),E=d("ParentTransition");return b(),x(C,null,[e.employee.uuid?(b(),y(I,{key:0,title:a(t)(a(g).meta.label),navs:[{label:a(t)("employee.employee"),path:"Employee"},{label:e.employee.contact.name,path:{name:"EmployeeShow",params:{uuid:e.employee.uuid}}}]},{default:l(()=>[o(q,{"additional-actions":a(r)},null,8,["additional-actions"])]),_:1},8,["title","navs"])):f("",!0),o(E,{appear:"",visibility:!0},{default:l(()=>[e.employee.uuid?(b(),y(D,{key:0},{default:l(()=>[L("dl",V,[o(n,{label:a(t)("employee.props.code_number")},{default:l(()=>[c(u(e.employee.codeNumber),1)]),_:1},8,["label"]),o(n,{label:a(t)("employee.props.joining_date")},{default:l(()=>[c(u(e.employee.joiningDateDisplay),1)]),_:1},8,["label"]),o(n,{label:a(t)("company.department.department")},{default:l(()=>{var i,m;return[c(u((m=(i=e.employee.lastRecord)==null?void 0:i.department)==null?void 0:m.name),1)]}),_:1},8,["label"]),o(n,{label:a(t)("company.designation.designation")},{default:l(()=>{var i,m;return[c(u((m=(i=e.employee.lastRecord)==null?void 0:i.designation)==null?void 0:m.name),1)]}),_:1},8,["label"]),o(n,{label:a(t)("company.branch.branch")},{default:l(()=>{var i,m;return[c(u((m=(i=e.employee.lastRecord)==null?void 0:i.branch)==null?void 0:m.name),1)]}),_:1},8,["label"]),o(n,{label:a(t)("contact.props.birth_date")},{default:l(()=>[c(u(e.employee.contact.birthDateDisplay),1)]),_:1},8,["label"]),o(n,{label:a(t)("contact.props.gender")},{default:l(()=>[c(u(e.employee.contact.genderDisplay),1)]),_:1},8,["label"]),o(n,{label:a(h)},{default:l(()=>[c(u(e.employee.contact.uniqueIdNumber1),1)]),_:1},8,["label"]),o(n,{label:a(N)},{default:l(()=>[c(u(e.employee.contact.uniqueIdNumber2),1)]),_:1},8,["label"]),o(n,{label:a(B)},{default:l(()=>[c(u(e.employee.contact.uniqueIdNumber3),1)]),_:1},8,["label"]),o(n,{label:a(t)("contact.props.birth_place")},{default:l(()=>[c(u(e.employee.contact.birthPlace),1)]),_:1},8,["label"]),o(n,{label:a(t)("contact.props.nationality")},{default:l(()=>[c(u(e.employee.contact.nationality),1)]),_:1},8,["label"]),o(n,{label:a(t)("contact.props.mother_tongue")},{default:l(()=>[c(u(e.employee.contact.motherTongue),1)]),_:1},8,["label"])])]),_:1})):f("",!0)]),_:1})],64)}}});export{H as default};
