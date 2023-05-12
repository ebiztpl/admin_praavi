import{h as k,u as H,m as P,s as T,r as o,o as u,a as V,f as t,l as a,b as l,F as A,k as c,v as s,x as i,p as I,d as g,e as _}from"./app.537b83f5.js";const N={class:"grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2"},L=["innerHTML"],R={name:"CompanyDesignationShow"},F=Object.assign(R,{setup(j){k();const p=H(),m=P(),b={},f="company/designation/",n=T({...b}),y=e=>{Object.assign(n,e)};return(e,d)=>{const B=o("PageHeaderAction"),$=o("PageHeader"),r=o("BaseDataView"),C=o("BaseButton"),h=o("ShowButton"),v=o("BaseCard"),D=o("ShowItem"),w=o("ParentTransition");return u(),V(A,null,[t($,{title:e.$trans(l(p).meta.trans,{attribute:e.$trans(l(p).meta.label)}),navs:[{label:e.$trans("company.company"),path:"Company"},{label:e.$trans("company.designation.designation"),path:"CompanyDesignationList"}]},{default:a(()=>[t(B,{name:"CompanyDesignation",title:e.$trans("company.designation.designation"),actions:["list"]},null,8,["title"])]),_:1},8,["title","navs"]),t(w,{appear:"",visibility:!0},{default:a(()=>[t(D,{"init-url":f,uuid:l(p).params.uuid,onSetItem:y,onRedirectTo:d[1]||(d[1]=S=>l(m).push({name:"Designation"}))},{default:a(()=>[n.uuid?(u(),c(v,{key:0},{name:a(()=>[s(i(n.name),1)]),footer:a(()=>[t(h,null,{default:a(()=>[l(I)("designation:edit")?(u(),c(C,{key:0,design:"primary",onClick:d[0]||(d[0]=S=>l(m).push({name:"CompanyDesignationEdit",params:{uuid:n.uuid}}))},{default:a(()=>[s(i(e.$trans("general.edit")),1)]),_:1})):g("",!0)]),_:1})]),default:a(()=>[_("dl",N,[t(r,{label:e.$trans("company.designation.props.name")},{default:a(()=>[s(i(n.name),1)]),_:1},8,["label"]),t(r,{label:e.$trans("company.designation.props.alias")},{default:a(()=>[s(i(n.alias),1)]),_:1},8,["label"]),t(r,{label:e.$trans("company.designation.props.parent")},{default:a(()=>[s(i(n.parent?n.parent.name:"-"),1)]),_:1},8,["label"]),t(r,{class:"col-span-1 sm:col-span-2",label:e.$trans("company.designation.props.description")},{default:a(()=>[_("div",{innerHTML:n.description},null,8,L)]),_:1},8,["label"]),t(r,{label:e.$trans("general.created_at")},{default:a(()=>[s(i(n.createdAt),1)]),_:1},8,["label"]),t(r,{label:e.$trans("general.updated_at")},{default:a(()=>[s(i(n.updatedAt),1)]),_:1},8,["label"])])]),_:1})):g("",!0)]),_:1},8,["uuid"])]),_:1})],64)}}});export{F as default};
