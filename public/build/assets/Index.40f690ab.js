import{u,m as l,h as f,s as _,t as g,r as a,o as p,k as d,l as h,f as C}from"./app.537b83f5.js";const v={name:"TeamConfig"},T=Object.assign(v,{setup(w){const o=u(),s=l(),n=f(),i=[{name:"TeamConfigRole",icon:"fas fa-user-tag",label:"team.config.role.role"},{name:"TeamConfigPermission",icon:"fas fa-key",label:"team.config.permission.permission"}],t=_({}),c=async()=>{await n.dispatch("team/get",{uuid:o.params.uuid}).then(e=>{Object.assign(t,e)}).catch(e=>{s.push({name:"TeamList"})})};return g(async()=>{await c()}),(e,b)=>{const r=a("router-view"),m=a("ModuleConfig");return p(),d(m,{navigations:i},{default:h(()=>[C(r,{team:t},null,8,["team"])]),_:1})}}});export{T as default};