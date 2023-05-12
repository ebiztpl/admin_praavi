import{s as B,r as t,o as m,k as d,l as e,e as C,f as a,u as P,m as j,A as w,y as A,b as u,d as y,v as p,x as _,a as L,z as M,F as N}from"./app.537b83f5.js";const O={class:"grid grid-cols-3 gap-6"},U={class:"col-span-3 sm:col-span-1"},x={__name:"Filter",props:{preRequisites:{type:Object,default(){return{}}}},emits:["hide"],setup(g,{emit:c}){const f={search:""},l=B({...f});return(v,r)=>{const i=t("BaseInput"),b=t("FilterForm");return m(),d(b,{"init-form":f,form:l,onHide:r[1]||(r[1]=n=>c("hide"))},{default:e(()=>[C("div",O,[C("div",U,[a(i,{type:"text",modelValue:l.search,"onUpdate:modelValue":r[0]||(r[0]=n=>l.search=n),name:"search",label:v.$trans("general.search")},null,8,["modelValue","label"])])])]),_:1},8,["form"])}}},S={name:"TeamConfigRoleList"},E=Object.assign(S,{props:{team:{type:Object,default(){return{name:""}}}},setup(g){const c=P(),f=j(),l=w("emitter"),v="team/role/",r=A(!1),i=B({}),b=n=>{Object.assign(i,n)};return(n,o)=>{const I=t("PageHeaderAction"),k=t("PageHeader"),F=t("ParentTransition"),$=t("DataCell"),R=t("FloatingMenuItem"),T=t("FloatingMenu"),D=t("DataRow"),h=t("BaseButton"),V=t("DataTable"),H=t("ListItem");return m(),d(H,{"init-url":v,uuid:u(c).params.uuid,onSetItems:b},{header:e(()=>[g.team.uuid?(m(),d(k,{key:0,title:n.$trans("team.config.role.role"),navs:[]},{default:e(()=>[a(I,{url:`teams/${g.team.uuid}/roles/`,name:"TeamConfigRole",title:n.$trans("team.config.role.role"),actions:["create","filter"],"dropdown-actions":["print","pdf","excel"],onToggleFilter:o[0]||(o[0]=s=>r.value=!r.value)},null,8,["url","title"])]),_:1},8,["title"])):y("",!0)]),filter:e(()=>[a(F,{appear:"",visibility:r.value},{default:e(()=>[a(x,{onRefresh:o[1]||(o[1]=s=>u(l).emit("listItems")),onHide:o[2]||(o[2]=s=>r.value=!1)})]),_:1},8,["visibility"])]),default:e(()=>[a(F,{appear:"",visibility:!0},{default:e(()=>[a(V,{header:i.headers,meta:i.meta,module:"team.config.role",onRefresh:o[4]||(o[4]=s=>u(l).emit("listItems"))},{actionButton:e(()=>[a(h,{onClick:o[3]||(o[3]=s=>u(f).push({name:"TeamConfigRoleCreate"}))},{default:e(()=>[p(_(n.$trans("global.add",{attribute:n.$trans("team.config.role.role")})),1)]),_:1})]),default:e(()=>[(m(!0),L(N,null,M(i.data,s=>(m(),d(D,{key:s.uuid},{default:e(()=>[a($,{name:"name"},{default:e(()=>[p(_(s.label),1)]),_:2},1024),a($,{name:"createdAt"},{default:e(()=>[p(_(s.createdAt),1)]),_:2},1024),a($,{name:"action"},{default:e(()=>[s.isDefault?y("",!0):(m(),d(T,{key:0},{default:e(()=>[a(R,{icon:"fas fa-trash",onClick:q=>u(l).emit("deleteItem",{uuid:u(c).params.uuid,moduleUuid:s.uuid})},{default:e(()=>[p(_(n.$trans("general.delete")),1)]),_:2},1032,["onClick"])]),_:2},1024))]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["header","meta"])]),_:1})]),_:1},8,["uuid"])}}});export{E as default};