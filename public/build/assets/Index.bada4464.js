import{u as L,m as j,h as z,p as h,y as M,c as O,s as S,t as W,r as a,o as s,a as m,f as t,l as e,b as r,F as _,k as f,v as C,x as c,d as E,z as b,e as D,n as J,J as U}from"./app.537b83f5.js";import{_ as G}from"./Filter.6e803d1b.js";const I={name:"AttendanceList"},Y=Object.assign(I,{setup(K){const d=L(),x=j(),$=z();let B=[];h("attendance:config")&&B.unshift("config");let k=[];h("attendance:export")&&(k=["print","pdf","excel"]);const v="attendance/",i=M(!1),P=O(()=>U(d.query.dayWise)),l=S({headers:[],data:[],meta:{total:0}}),p=async()=>{i.value=!0,await $.dispatch(v+"listAttendance",{params:d.query}).then(o=>{i.value=!1,Object.assign(l,o)}).catch(o=>{i.value=!1})};return W(async()=>{d.query.date&&await p()}),(o,w)=>{const V=a("BaseButton"),N=a("PageHeaderAction"),R=a("PageHeader"),A=a("ParentTransition"),T=a("BaseDataView"),g=a("DataCell"),H=a("DataRow"),q=a("DataTable"),F=a("BaseCard");return s(),m(_,null,[t(R,{title:o.$trans(r(d).meta.label),navs:[]},{default:e(()=>[t(N,{url:"attendance/",name:"Attendance",title:o.$trans("attendance.attendance"),actions:r(B),"dropdown-actions":r(k)},{default:e(()=>[r(h)("attendance:mark")?(s(),f(V,{key:0,design:"white",onClick:w[0]||(w[0]=n=>r(x).push({name:"AttendanceMark"}))},{default:e(()=>[C(c(o.$trans("attendance.mark")),1)]),_:1})):E("",!0)]),_:1},8,["title","actions","dropdown-actions"])]),_:1},8,["title"]),t(A,{appear:"",visibility:!0},{default:e(()=>[t(G,{onAfterFilter:p,"init-url":v,"date-as":"month","day-wise-filter":""})]),_:1}),t(A,{appear:"",visibility:!0},{default:e(()=>[t(F,{"no-padding":"","no-content-padding":"","is-loading":i.value},{default:e(()=>[t(q,{header:l.headers,meta:l.meta,module:"attendance",onRefresh:p},{default:e(()=>[(s(!0),m(_,null,b(l.data,n=>(s(),f(H,{key:n.uuid},{default:e(()=>[t(g,{name:"employee"},{default:e(()=>[t(T,{label:n.name+" ("+n.codeNumber+")",revert:""},{default:e(()=>[C(c(n.designation)+" "+c(n.branch),1)]),_:2},1032,["label"])]),_:2},1024),r(P)?(s(!0),m(_,{key:0},b(n.attendances,(u,y)=>(s(),f(g,{name:`day${y}`},{default:e(()=>[D("span",{class:J(["font-semibold","text-xs","text-"+u.color])},c(u.code),3)]),_:2},1032,["name"]))),256)):(s(!0),m(_,{key:1},b(n.summary,(u,y)=>(s(),f(g,{align:"center",name:`type_${y}`},{default:e(()=>[D("span",null,c(u),1)]),_:2},1032,["name"]))),256))]),_:2},1024))),128))]),_:1},8,["header","meta"])]),_:1},8,["is-loading"])]),_:1})],64)}}});export{Y as default};