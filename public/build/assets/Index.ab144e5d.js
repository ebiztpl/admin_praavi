import{u as G,m as J,h as K,y as Q,s as S,q as X,t as Y,r as o,o as s,a as c,f as i,l as n,b as l,k as f,d as $,F as h,I as Z,v as d,x as r,z as D,e as k}from"./app.537b83f5.js";import{_ as x}from"./Filter.82ce0271.js";const ee={class:"p-2"},te={class:"divide-y divide-gray-200 dark:divide-gray-700"},ae={class:"col-span-3 sm:col-span-1"},ne={key:0,class:"col-span-3 sm:col-span-2"},oe={class:"col-span-3 sm:col-span-1"},se={class:"col-span-3 sm:col-span-1"},re={name:"AttendanceWorkShiftAssign"},de=Object.assign(re,{setup(ie){const u=G(),A=J(),P=K(),g={employees:[]},w="attendance/workShift/",v=Q(!1),y=S({workShifts:[]}),b=X(w),m=S({...g}),V=S({meta:{}}),R=e=>{m.employees.forEach(_=>{_.workShifts.length==0&&(_.workShift=e.uuid)})},B=async()=>{v.value=!0,await P.dispatch(w+"fetchEmployee",{params:u.query}).then(e=>{v.value=!1,g.employees=e.data,V.meta=e.meta,Object.assign(m,Z(g))}).catch(e=>{v.value=!1})},U=e=>{Object.assign(y,e)},C=async()=>{await B()};return Y(async()=>{u.query.startDate&&u.query.endDate&&await B()}),(e,_)=>{const F=o("BaseButton"),E=o("PageHeaderAction"),N=o("PageHeader"),O=o("ParentTransition"),T=o("DropdownItem"),H=o("DropdownButton"),W=o("BaseAlert"),q=o("BaseDataView"),j=o("BaseSelect"),I=o("BaseTextarea"),z=o("FormAction"),L=o("Pagination"),M=o("BaseCard");return s(),c(h,null,[i(N,{title:e.$trans(l(u).meta.trans,{attribute:e.$trans(l(u).meta.label)}),navs:[{label:e.$trans("attendance.attendance"),path:"Attendance"},{label:e.$trans("attendance.work_shift.work_shift"),path:"AttendanceWorkShiftReport"}]},{default:n(()=>[i(E,null,{default:n(()=>[i(F,{design:"white",onClick:_[0]||(_[0]=a=>l(A).push({name:"AttendanceWorkShiftReport"}))},{default:n(()=>[d(r(e.$trans("global.report",{attribute:e.$trans("attendance.work_shift.work_shift")})),1)]),_:1})]),_:1})]),_:1},8,["title","navs"]),i(O,{appear:"",visibility:!0},{default:n(()=>[i(x,{onAfterFilter:B,"init-url":w})]),_:1}),l(u).query.startDate&&l(u).query.endDate?(s(),f(M,{key:0,"no-padding":"","no-content-padding":"","is-loading":v.value},{title:n(()=>[d(r(e.$trans("attendance.work_shift.assign")),1)]),action:n(()=>[y.workShifts?(s(),f(H,{key:0,label:e.$trans("attendance.work_shift.work_shift")},{default:n(()=>[(s(!0),c(h,null,D(y.workShifts,a=>(s(),c("div",{key:a.uuid},[i(T,{as:"span",onClick:p=>R(a)},{default:n(()=>[d(r(a.name)+" ("+r(a.code)+") ",1)]),_:2},1032,["onClick"])]))),128))]),_:1},8,["label"])):$("",!0)]),default:n(()=>[k("div",ee,[m.employees.length==0?(s(),f(W,{key:0,size:"xs",design:"error"},{default:n(()=>[d(r(e.$trans("general.errors.record_not_found")),1)]),_:1})):$("",!0)]),m.employees.length?(s(),f(z,{key:0,"no-card":"","button-padding":"","keep-adding":!1,"stay-on":!0,"init-url":w,"pre-requisites":!0,"pre-requisite-custom-url":"assignPreRequisite",onSetPreRequisites:U,action:"assign","init-form":g,form:m,"after-submit":C},{default:n(()=>[k("div",te,[(s(!0),c(h,null,D(m.employees,(a,p)=>(s(),c("div",{class:"grid grid-cols-3 gap-6 px-4 py-2",key:a.uuid},[k("div",ae,[i(q,{label:a.name+" ("+a.codeNumber+")",revert:""},{default:n(()=>[d(r(a.designation)+" "+r(a.branch),1)]),_:2},1032,["label"])]),a.workShifts.length?(s(),c("div",ne,[(s(!0),c(h,null,D(a.workShifts,t=>(s(),f(q,{label:t.name+" ("+t.code+")",revert:""},{default:n(()=>[d(r(t.startDateDisplay)+" - "+r(t.endDateDisplay),1)]),_:2},1032,["label"]))),256))])):(s(),c(h,{key:1},[k("div",oe,[i(j,{modelValue:a.workShift,"onUpdate:modelValue":t=>a.workShift=t,name:`employees.${p}.workShift`,placeholder:e.$trans("attendance.work_shift.work_shift"),options:y.workShifts,"value-prop":"uuid",error:l(b)[`employees.${p}.workShift`],"onUpdate:error":t=>l(b)[`employees.${p}.workShift`]=t},{selectedOption:n(t=>[d(r(t.value.name)+" ("+r(t.value.code)+") ",1)]),listOption:n(t=>[d(r(t.option.name)+" ("+r(t.option.code)+") ",1)]),_:2},1032,["modelValue","onUpdate:modelValue","name","placeholder","options","error","onUpdate:error"])]),k("div",se,[i(I,{rows:1,modelValue:a.remarks,"onUpdate:modelValue":t=>a.remarks=t,name:`employees.${p}.remarks`,placeholder:e.$trans("attendance.work_shift.props.remarks"),error:l(b)[`details.${p}.remarks`],"onUpdate:error":t=>l(b)[`details.${p}.remarks`]=t},null,8,["modelValue","onUpdate:modelValue","name","placeholder","error","onUpdate:error"])])],64))]))),128))])]),_:1},8,["form"])):$("",!0),i(L,{meta:V.meta,onRefresh:B},null,8,["meta"])]),_:1},8,["is-loading"])):$("",!0)],64)}}});export{de as default};
