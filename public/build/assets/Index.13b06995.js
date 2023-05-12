import{u as R,s as L,t as T,r as u,o as c,k as f,l as e,e as F,v as r,x as n,d as $,f as a,m as M,A as O,p as b,y as U,b as i,a as j,z as q,F as A}from"./app.537b83f5.js";const E={class:"grid grid-cols-3 gap-6"},z={class:"col-span-3 sm:col-span-1"},G={class:"col-span-3 sm:col-span-1"},J={__name:"Filter",emits:["hide"],setup(B,{emit:y}){const _=R(),D={employees:[],startDate:"",endDate:""},m=L({...D}),g=L({employees:[],isLoaded:!_.query.employees});return T(async()=>{g.employees=_.query.employees?_.query.employees.split(","):[],g.isLoaded=!0}),(p,l)=>{const h=u("BaseSelectSearch"),s=u("DatePicker"),d=u("FilterForm");return c(),f(d,{"init-form":D,form:m,multiple:["employees"],onHide:l[3]||(l[3]=o=>y("hide"))},{default:e(()=>[F("div",E,[F("div",z,[g.isLoaded?(c(),f(h,{key:0,multiple:"",name:"employees",label:p.$trans("global.select",{attribute:p.$trans("employee.employee")}),modelValue:m.employees,"onUpdate:modelValue":l[0]||(l[0]=o=>m.employees=o),"value-prop":"uuid","init-search":g.employees,"search-key":"name","search-action":"employee/list"},{selectedOption:e(o=>[r(n(o.value.name)+" ("+n(o.value.codeNumber)+") ",1)]),listOption:e(o=>[r(n(o.option.name)+" ("+n(o.option.codeNumber)+") ",1)]),_:1},8,["label","modelValue","init-search"])):$("",!0)]),F("div",G,[a(s,{start:m.startDate,"onUpdate:start":l[1]||(l[1]=o=>m.startDate=o),end:m.endDate,"onUpdate:end":l[2]||(l[2]=o=>m.endDate=o),name:"dateBetween",as:"range",label:p.$trans("general.date_between")},null,8,["start","end","label"])])])]),_:1},8,["form"])}}},K={name:"LeaveAllocationList"},W=Object.assign(K,{setup(B){const y=M(),_=O("emitter");let D=["filter"];b("leave-allocation:create")&&D.unshift("create");let m=[];b("leave-allocation:export")&&(m=["print","pdf","excel"]);const g="leave/allocation/",p=U(!1),l=L({}),h=s=>{Object.assign(l,s)};return(s,d)=>{const o=u("PageHeaderAction"),I=u("PageHeader"),w=u("ParentTransition"),v=u("DataCell"),k=u("FloatingMenuItem"),N=u("FloatingMenu"),S=u("DataRow"),V=u("BaseButton"),H=u("DataTable"),P=u("ListItem");return c(),f(P,{"init-url":g,onSetItems:h},{header:e(()=>[a(I,{title:s.$trans("leave.allocation.allocation"),navs:[{label:s.$trans("leave.leave"),path:"Leave"}]},{default:e(()=>[a(o,{url:"leave/allocations/",name:"LeaveAllocation",title:s.$trans("leave.allocation.allocation"),actions:i(D),"dropdown-actions":i(m),onToggleFilter:d[0]||(d[0]=t=>p.value=!p.value)},null,8,["title","actions","dropdown-actions"])]),_:1},8,["title","navs"])]),filter:e(()=>[a(w,{appear:"",visibility:p.value},{default:e(()=>[a(J,{onRefresh:d[1]||(d[1]=t=>i(_).emit("listItems")),onHide:d[2]||(d[2]=t=>p.value=!1)})]),_:1},8,["visibility"])]),default:e(()=>[a(w,{appear:"",visibility:!0},{default:e(()=>[a(H,{header:l.headers,meta:l.meta,module:"leave.allocation",onRefresh:d[4]||(d[4]=t=>i(_).emit("listItems"))},{actionButton:e(()=>[i(b)("leave-allocation:create")?(c(),f(V,{key:0,onClick:d[3]||(d[3]=t=>i(y).push({name:"LeaveAllocationCreate"}))},{default:e(()=>[r(n(s.$trans("global.add",{attribute:s.$trans("leave.allocation.allocation")})),1)]),_:1})):$("",!0)]),default:e(()=>[(c(!0),j(A,null,q(l.data,t=>(c(),f(S,{key:t.uuid},{default:e(()=>[a(v,{name:"employee"},{default:e(()=>[r(n(t.employee.name)+" ("+n(t.employee.codeNumber)+") ",1)]),_:2},1024),a(v,{name:"designation"},{default:e(()=>[r(n(t.employee.designation),1)]),_:2},1024),a(v,{name:"branch"},{default:e(()=>[r(n(t.employee.branch),1)]),_:2},1024),a(v,{name:"startDate"},{default:e(()=>[r(n(t.startDateDisplay),1)]),_:2},1024),a(v,{name:"endDate"},{default:e(()=>[r(n(t.endDateDisplay),1)]),_:2},1024),a(v,{name:"createdAt"},{default:e(()=>[r(n(t.createdAt),1)]),_:2},1024),a(v,{name:"action"},{default:e(()=>[a(N,null,{default:e(()=>[a(k,{icon:"fas fa-arrow-circle-right",onClick:C=>i(y).push({name:"LeaveAllocationShow",params:{uuid:t.uuid}})},{default:e(()=>[r(n(s.$trans("general.show")),1)]),_:2},1032,["onClick"]),i(b)("leave-allocation:edit")?(c(),f(k,{key:0,icon:"fas fa-edit",onClick:C=>i(y).push({name:"LeaveAllocationEdit",params:{uuid:t.uuid}})},{default:e(()=>[r(n(s.$trans("general.edit")),1)]),_:2},1032,["onClick"])):$("",!0),i(b)("leave-allocation:create")?(c(),f(k,{key:1,icon:"fas fa-copy",onClick:C=>i(y).push({name:"LeaveAllocationDuplicate",params:{uuid:t.uuid}})},{default:e(()=>[r(n(s.$trans("general.duplicate")),1)]),_:2},1032,["onClick"])):$("",!0),i(b)("leave-allocation:delete")?(c(),f(k,{key:2,icon:"fas fa-trash",onClick:C=>i(_).emit("deleteItem",{uuid:t.uuid})},{default:e(()=>[r(n(s.$trans("general.delete")),1)]),_:2},1032,["onClick"])):$("",!0)]),_:2},1024)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["header","meta"])]),_:1})]),_:1})}}});export{W as default};
