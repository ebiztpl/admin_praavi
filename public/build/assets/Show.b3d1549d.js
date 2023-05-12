import{h as z,u as G,m as J,s as $,q as K,y as Q,r as n,o as _,a as W,f as a,l as t,b as u,F as X,k as y,v as o,x as r,e as d,p as R,d as L}from"./app.537b83f5.js";const Y={class:"space-y-4"},Z={class:"grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2"},x=["innerHTML"],ee=["innerHTML"],te=["innerHTML"],ae=["innerHTML"],se={class:"grid grid-cols-2 gap-6"},ne={class:"col-span-2 sm:col-span-1"},le={class:"col-span-2 sm:col-span-1"},oe={name:"LeaveRequestShow"},ie=Object.assign(oe,{setup(re){z();const f=G(),B=J(),T={},V={status:"",comment:""},v="leave/request/",h=$({statuses:[]}),b=K(v),c=$({...V}),g=Q(!1),s=$({...T}),S=e=>{Object.assign(h,e)},H=e=>{Object.assign(s,e)},w=()=>{g.value=!0};return(e,l)=>{const M=n("PageHeaderAction"),k=n("PageHeader"),p=n("ListItemView"),C=n("ListContainerVertical"),q=n("BaseCard"),P=n("BaseBadge"),m=n("BaseDataView"),D=n("ListMedia"),I=n("BaseButton"),A=n("ShowButton"),F=n("BaseSelect"),N=n("BaseTextarea"),U=n("FormAction"),E=n("DetailLayoutVertical"),j=n("ShowItem"),O=n("ParentTransition");return _(),W(X,null,[a(k,{title:e.$trans(u(f).meta.trans,{attribute:e.$trans(u(f).meta.label)}),navs:[{label:e.$trans("leave.leave"),path:"Leave"},{label:e.$trans("leave.request.request"),path:"LeaveRequestList"}]},{default:t(()=>[a(M,{name:"LeaveRequest",title:e.$trans("leave.request.request"),actions:["list"]},null,8,["title"])]),_:1},8,["title","navs"]),a(O,{appear:"",visibility:!0},{default:t(()=>[a(j,{"init-url":v,uuid:u(f).params.uuid,onSetItem:H,onRedirectTo:l[5]||(l[5]=i=>u(B).push({name:"LeaveRequest"})),refresh:g.value,onRefreshed:l[6]||(l[6]=i=>g.value=!1)},{default:t(()=>[s.uuid?(_(),y(E,{key:0},{detail:t(()=>[a(q,{"no-padding":"","no-content-padding":""},{title:t(()=>[o(r(e.$trans("global.detail",{attribute:e.$trans("employee.employee")})),1)]),default:t(()=>[a(C,null,{default:t(()=>[a(p,{label:e.$trans("employee.props.name")},{default:t(()=>[o(r(s.employee.name),1)]),_:1},8,["label"]),a(p,{label:e.$trans("employee.props.code_number")},{default:t(()=>[o(r(s.employee.codeNumber),1)]),_:1},8,["label"]),a(p,{label:e.$trans("company.department.department")},{default:t(()=>[o(r(s.employee.department),1)]),_:1},8,["label"]),a(p,{label:e.$trans("company.designation.designation")},{default:t(()=>[o(r(s.employee.designation),1)]),_:1},8,["label"]),a(p,{label:e.$trans("company.branch.branch")},{default:t(()=>[o(r(s.employee.branch),1)]),_:1},8,["label"]),a(p,{label:e.$trans("employee.employment_status.employment_status")},{default:t(()=>[o(r(s.employee.employmentStatus),1)]),_:1},8,["label"])]),_:1})]),_:1})]),default:t(()=>[d("div",Y,[a(q,null,{title:t(()=>[o(r(e.$trans("leave.request.request"))+" ",1),a(P,{label:s.statusDetail.label,design:s.statusDetail.color},null,8,["label","design"])]),footer:t(()=>[a(A,null,{default:t(()=>[u(R)("leave-request:edit")&&s.status=="requested"?(_(),y(I,{key:0,design:"primary",onClick:l[0]||(l[0]=i=>u(B).push({name:"LeaveRequestEdit",params:{uuid:s.uuid}}))},{default:t(()=>[o(r(e.$trans("general.edit")),1)]),_:1})):L("",!0)]),_:1})]),default:t(()=>[d("dl",Z,[a(m,{label:e.$trans("leave.request.props.period")},{default:t(()=>[d("div",{innerHTML:s.period},null,8,x)]),_:1},8,["label"]),a(m,{label:e.$trans("leave.request.props.duration")},{default:t(()=>[d("div",{innerHTML:s.duration},null,8,ee)]),_:1},8,["label"]),a(m,{class:"col-span-1 sm:col-span-2",label:e.$trans("leave.request.props.reason")},{default:t(()=>[d("div",{innerHTML:s.reason},null,8,te)]),_:1},8,["label"]),a(m,{class:"col-span-1 sm:col-span-2",label:e.$trans("leave.request.props.comment")},{default:t(()=>[d("div",{innerHTML:s.comment},null,8,ae)]),_:1},8,["label"]),a(m,{label:e.$trans("general.created_at")},{default:t(()=>[o(r(s.createdAt),1)]),_:1},8,["label"]),a(m,{label:e.$trans("general.updated_at")},{default:t(()=>[o(r(s.updatedAt),1)]),_:1},8,["label"]),a(m,{class:"col-span-1 sm:col-span-2"},{default:t(()=>[a(D,{media:s.media,url:`/app/leave/requests/${s.uuid}/`},null,8,["media","url"])]),_:1})])]),_:1}),u(R)("leave-request:action")?(_(),y(q,{key:0},{title:t(()=>[o(r(e.$trans("leave.request.action")),1)]),default:t(()=>[a(U,{"no-card":"","keep-adding":!1,"init-url":v,"pre-requisites":!0,onSetPreRequisites:S,uuid:s.uuid,"no-data-fetch":!0,action:"status","init-form":V,form:c,"after-submit":w},{default:t(()=>[d("div",se,[d("div",ne,[a(F,{name:"status",label:e.$trans("global.select",{attribute:e.$trans("leave.request.props.status")}),modelValue:c.status,"onUpdate:modelValue":l[1]||(l[1]=i=>c.status=i),options:h.statuses,error:u(b).status,"onUpdate:error":l[2]||(l[2]=i=>u(b).status=i)},null,8,["label","modelValue","options","error"])]),d("div",le,[a(N,{modelValue:c.comment,"onUpdate:modelValue":l[3]||(l[3]=i=>c.comment=i),name:"comment",label:e.$trans("leave.request.props.comment"),error:u(b).comment,"onUpdate:error":l[4]||(l[4]=i=>u(b).comment=i)},null,8,["modelValue","label","error"])])])]),_:1},8,["uuid","form"])]),_:1})):L("",!0)])]),_:1})):L("",!0)]),_:1},8,["uuid","refresh"])]),_:1})],64)}}});export{ie as default};
