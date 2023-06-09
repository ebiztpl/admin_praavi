import{h as $,u as j,m as E,A as F,s as M,r as s,o as d,a as y,f as l,l as e,b as t,F as L,k as m,v as n,x as i,e as h,p as O,d as _,z}from"./app.537b83f5.js";const U={class:"space-y-4"},q={key:1,class:"px-4 pt-4 grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2"},G=["innerHTML"],J={name:"LeaveAllocationShow"},W=Object.assign(J,{setup(K){$();const b=j(),v=E(),a=F("$trans"),k={},B="leave/allocation/",D=[{key:"type",label:a("leave.type.type"),visibility:!0},{key:"allotted",label:a("leave.allocation.props.allotted"),visibility:!0},{key:"used",label:a("leave.allocation.props.used"),visibility:!0},{key:"action",label:"",visibility:!0}],o=M({...k}),w=f=>{Object.assign(o,f)};return(f,p)=>{const A=s("PageHeaderAction"),V=s("PageHeader"),c=s("ListItemView"),S=s("ListContainerVertical"),g=s("BaseCard"),u=s("DataCell"),C=s("DataRow"),T=s("SimpleTable"),x=s("BaseDataView"),H=s("BaseButton"),I=s("ShowButton"),P=s("DetailLayoutVertical"),N=s("ShowItem"),R=s("ParentTransition");return d(),y(L,null,[l(V,{title:t(a)(t(b).meta.trans,{attribute:t(a)(t(b).meta.label)}),navs:[{label:t(a)("leave.leave"),path:"Leave"},{label:t(a)("leave.allocation.allocation"),path:"LeaveAllocationList"}]},{default:e(()=>[l(A,{name:"LeaveAllocation",title:t(a)("leave.allocation.allocation"),actions:["list"]},null,8,["title"])]),_:1},8,["title","navs"]),l(R,{appear:"",visibility:!0},{default:e(()=>[l(N,{"init-url":B,uuid:t(b).params.uuid,onSetItem:w,onRedirectTo:p[1]||(p[1]=r=>t(v).push({name:"LeaveAllocation"}))},{default:e(()=>[o.uuid?(d(),m(P,{key:0},{detail:e(()=>[l(g,{"no-padding":"","no-content-padding":""},{title:e(()=>[n(i(t(a)("global.detail",{attribute:t(a)("leave.allocation.allocation")})),1)]),default:e(()=>[l(S,null,{default:e(()=>[l(c,{label:t(a)("employee.props.name")},{default:e(()=>[n(i(o.employee.name),1)]),_:1},8,["label"]),l(c,{label:t(a)("employee.props.code_number")},{default:e(()=>[n(i(o.employee.codeNumber),1)]),_:1},8,["label"]),l(c,{label:t(a)("company.department.department")},{default:e(()=>[n(i(o.employee.department),1)]),_:1},8,["label"]),l(c,{label:t(a)("company.designation.designation")},{default:e(()=>[n(i(o.employee.designation),1)]),_:1},8,["label"]),l(c,{label:t(a)("company.branch.branch")},{default:e(()=>[n(i(o.employee.branch),1)]),_:1},8,["label"]),l(c,{label:t(a)("employee.employment_status.employment_status")},{default:e(()=>[n(i(o.employee.employmentStatus),1)]),_:1},8,["label"]),l(c,{label:t(a)("leave.allocation.props.start_date")},{default:e(()=>[n(i(o.startDateDisplay),1)]),_:1},8,["label"]),l(c,{label:t(a)("leave.allocation.props.end_date")},{default:e(()=>[n(i(o.endDateDisplay),1)]),_:1},8,["label"]),l(c,{label:t(a)("general.created_at")},{default:e(()=>[n(i(o.createdAt),1)]),_:1},8,["label"]),l(c,{label:t(a)("general.updated_at")},{default:e(()=>[n(i(o.updatedAt),1)]),_:1},8,["label"])]),_:1})]),_:1})]),default:e(()=>[h("div",U,[l(g,{"no-padding":"","no-content-padding":"","bottom-content-padding":""},{title:e(()=>[n(i(t(a)("leave.type.type")),1)]),footer:e(()=>[l(I,null,{default:e(()=>[t(O)("leave-allocation:edit")?(d(),m(H,{key:0,design:"primary",onClick:p[0]||(p[0]=r=>t(v).push({name:"LeaveAllocationEdit",params:{uuid:o.uuid}}))},{default:e(()=>[n(i(t(a)("general.edit")),1)]),_:1})):_("",!0)]),_:1})]),default:e(()=>[o.records.length>0?(d(),m(T,{key:0,header:D},{default:e(()=>[(d(!0),y(L,null,z(o.records,r=>(d(),m(C,{key:r.uuid},{default:e(()=>[l(u,{name:"type"},{default:e(()=>[n(i(r.leaveType.name),1)]),_:2},1024),l(u,{name:"allotted"},{default:e(()=>[n(i(r.allotted),1)]),_:2},1024),l(u,{name:"used"},{default:e(()=>[n(i(r.used),1)]),_:2},1024),l(u,{name:"action"})]),_:2},1024))),128))]),_:1})):_("",!0),o.description?(d(),y("dl",q,[l(x,{class:"col-span-1 sm:col-span-2",label:t(a)("leave.allocation.props.description")},{default:e(()=>[h("div",{innerHTML:o.description},null,8,G)]),_:1},8,["label"])])):_("",!0)]),_:1})])]),_:1})):_("",!0)]),_:1},8,["uuid"])]),_:1})],64)}}});export{W as default};
