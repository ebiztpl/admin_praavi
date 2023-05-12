import{h as C,u as P,m as V,s as A,r as n,o as p,a as H,f as a,l as e,b as m,F as I,k as y,v as l,x as s,p as N,d as f,e as T}from"./app.537b83f5.js";const j={class:"grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2"},O={name:"EmployeeDocumentShow"},F=Object.assign(O,{props:{employee:{type:Object,default(){return{}}}},setup(d){C();const r=P(),c=V(),_={},b="employee/document/",o=A({..._}),g=t=>{Object.assign(o,t)};return(t,i)=>{const $=n("PageHeaderAction"),B=n("PageHeader"),u=n("BaseDataView"),D=n("ListMedia"),h=n("BaseButton"),w=n("ShowButton"),S=n("BaseCard"),v=n("ShowItem"),E=n("ParentTransition");return p(),H(I,null,[a(B,{title:t.$trans(m(r).meta.trans,{attribute:t.$trans(m(r).meta.label)}),navs:[{label:t.$trans("employee.employee"),path:"Employee"},{label:d.employee.contact.name,path:{name:"EmployeeShow",params:{uuid:d.employee.uuid}}}]},{default:e(()=>[a($,{name:"EmployeeDocument",title:t.$trans("employee.document.document"),actions:["list"]},null,8,["title"])]),_:1},8,["title","navs"]),a(E,{appear:"",visibility:!0},{default:e(()=>[a(v,{"init-url":b,uuid:m(r).params.uuid,"module-uuid":m(r).params.muuid,onSetItem:g,onRedirectTo:i[1]||(i[1]=k=>m(c).push({name:"EmployeeDocument",params:{uuid:d.employee.uuid}}))},{default:e(()=>[o.uuid?(p(),y(S,{key:0},{title:e(()=>[l(s(o.type.name),1)]),footer:e(()=>[a(w,null,{default:e(()=>[m(N)("employee:edit")?(p(),y(h,{key:0,design:"primary",onClick:i[0]||(i[0]=k=>m(c).push({name:"EmployeeDocumentEdit",params:{uuid:d.employee.uuid,muuid:o.uuid}}))},{default:e(()=>[l(s(t.$trans("general.edit")),1)]),_:1})):f("",!0)]),_:1})]),default:e(()=>[T("dl",j,[a(u,{label:t.$trans("employee.document.props.title")},{default:e(()=>[l(s(o.title),1)]),_:1},8,["label"]),a(u,{class:"col-span-1 sm:col-span-2",label:t.$trans("employee.document.props.description")},{default:e(()=>[l(s(o.description),1)]),_:1},8,["label"]),a(u,{label:t.$trans("employee.document.props.start_date")},{default:e(()=>[l(s(o.startDateDisplay),1)]),_:1},8,["label"]),a(u,{label:t.$trans("employee.document.props.end_date")},{default:e(()=>[l(s(o.endDateDisplay),1)]),_:1},8,["label"]),a(u,{class:"col-span-1 sm:col-span-2"},{default:e(()=>[a(D,{media:o.media,url:`/app/employees/${d.employee.uuid}/documents/${o.uuid}/`},null,8,["media","url"])]),_:1}),a(u,{label:t.$trans("general.created_at")},{default:e(()=>[l(s(o.createdAt),1)]),_:1},8,["label"]),a(u,{label:t.$trans("general.updated_at")},{default:e(()=>[l(s(o.updatedAt),1)]),_:1},8,["label"])])]),_:1})):f("",!0)]),_:1},8,["uuid","module-uuid"])]),_:1})],64)}}});export{F as default};
