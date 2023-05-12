import{u as M,m as _,h as G,A as H,s as W,q as J,E as K,t as Q,r as c,o as r,k as b,l as y,d as o,I as X,v as m,x as l,a as i,f,F as q,e as k,b as u,z as j,n as A}from"./app.537b83f5.js";const Y={key:3,class:"grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2"},Z={class:"mt-4 grid grid-cols-3 gap-4"},ee={class:"col-span-3"},te={class:"mt-4 grid grid-cols-3 gap-4"},ae={class:"col-span-3 sm:col-span-1"},se={class:"col-span-3 sm:col-span-2 flex items-end"},ne={key:0,class:"space-x-2 flex flex-wrap"},re=["onClick"],oe={key:1,class:"flex flex-wrap"},le=["onClick"],ie={class:"mt-4 grid grid-cols-3 gap-4"},de={class:"col-span-3 sm:col-span-1"},ue={class:"col-span-3 sm:col-span-1"},pe={name:"TaskRepeatList"},ye=Object.assign(pe,{props:{task:{type:Object,default(){return{}}}},emits:["refresh"],setup(n,{emit:F}){const p=n;M(),_(),G(),H("emitter");const x={shouldRepeat:!1,frequency:null,days:[],dates:[],dayWiseCount:1,startDate:"",endDate:""},V="task/repeat/",R=W({frequencies:[],days:[],dates:[]}),d=J(V),a=W({...x}),O=e=>{a.days.includes(e)?a.days.splice(a.days.indexOf(e),1):a.days.push(e)},C=e=>a.days.includes(e),z=e=>{a.dates.includes(e)?a.dates.splice(a.dates.indexOf(e),1):a.dates.push(e)},w=e=>a.dates.includes(e),E=e=>{Object.assign(R,e)},B=()=>{var e,s,g,D,h,v;Object.assign(x,{shouldRepeat:p.task.shouldRepeat,startDate:(e=p.task.repeatation)==null?void 0:e.startDate,endDate:(s=p.task.repeatation)==null?void 0:s.endDate,frequency:(g=p.task.repeatation)==null?void 0:g.frequency,days:((D=p.task.repeatation)==null?void 0:D.days)||[],dates:((h=p.task.repeatation)==null?void 0:h.dates)||[],dayWiseCount:((v=p.task.repeatation)==null?void 0:v.dayWiseCount)||1}),Object.assign(a,X(x))},N=()=>{F("refresh")};return K(()=>p.task.repeatation,e=>{B()},{deep:!0}),Q(async()=>{B()}),(e,s)=>{const g=c("BaseAlert"),D=c("BaseDataView"),h=c("BaseSwitch"),v=c("BaseSelect"),P=c("BaseInput"),$=c("DatePicker"),I=c("FormAction"),L=c("BaseCard");return n.task.uuid?(r(),b(L,{key:0},{default:y(()=>{var U,S;return[n.task.shouldRepeat?o("",!0):(r(),b(g,{key:0,design:"info",size:"xs"},{default:y(()=>[m(l(e.$trans("task.repeat.doesnt_repeat")),1)]),_:1})),n.task.shouldRepeat&&n.task.repeatation.nextRepeatDate?(r(),b(g,{key:1,design:"info",size:"xs"},{default:y(()=>[m(l(e.$trans("task.repeat.repeat_on_date",{attribute:n.task.repeatation.nextRepeatDateDisplay})),1)]),_:1})):o("",!0),n.task.shouldRepeat&&!n.task.repeatation.nextRepeatDate?(r(),b(g,{key:2,design:"error",size:"xs"},{default:y(()=>[m(l(e.$trans("task.repeat.repeat_over")),1)]),_:1})):o("",!0),n.task.shouldRepeat&&!((U=n.task.permission)!=null&&U.isActionable)?(r(),i("dl",Y,[f(D,{label:n.task.repeatation.frequencyDisplay,class:"col-span-1 sm:col-span-2"},{default:y(()=>[n.task.repeatation.frequency=="day_wise"?(r(),i(q,{key:0},[m(l(n.task.repeatation.daysDisplay),1)],64)):n.task.repeatation.frequency=="date_wise"?(r(),i(q,{key:1},[m(l(n.task.repeatation.datesDisplay),1)],64)):n.task.repeatation.frequency=="day_wise_count"?(r(),i(q,{key:2},[m(l(n.task.repeatation.dayWiseCount)+" "+l(e.$trans("list.durations.days")),1)],64)):o("",!0)]),_:1},8,["label"]),f(D,{label:e.$trans("task.repeat.props.start_date")},{default:y(()=>[m(l(n.task.repeatation.startDateDisplay),1)]),_:1},8,["label"]),f(D,{label:e.$trans("task.repeat.props.end_date")},{default:y(()=>[m(l(n.task.repeatation.endDateDisplay),1)]),_:1},8,["label"])])):o("",!0),(S=n.task.permission)!=null&&S.isActionable?(r(),b(I,{key:4,"no-card":"","no-data-fetch":"","cancel-action":"","pre-requisites":{uuid:n.task.uuid},onSetPreRequisites:E,"keep-adding":!1,action:"updateRepeatation",uuid:n.task.uuid,"init-url":V,"init-form":x,form:a,"after-submit":N},{default:y(()=>[k("div",Z,[k("div",ee,[f(h,{reverse:"",modelValue:a.shouldRepeat,"onUpdate:modelValue":s[0]||(s[0]=t=>a.shouldRepeat=t),name:"shouldRepeat",label:e.$trans("task.repeat.props.should_repeat"),error:u(d).shouldRepeat,"onUpdate:error":s[1]||(s[1]=t=>u(d).shouldRepeat=t)},null,8,["modelValue","label","error"])])]),a.shouldRepeat?(r(),i(q,{key:0},[k("div",te,[k("div",ae,[f(v,{modelValue:a.frequency,"onUpdate:modelValue":s[2]||(s[2]=t=>a.frequency=t),name:"frequency",label:e.$trans("task.repeat.props.frequency"),options:R.frequencies,error:u(d).frequency,"onUpdate:error":s[3]||(s[3]=t=>u(d).frequency=t)},null,8,["modelValue","label","options","error"])]),k("div",se,[a.frequency=="day_wise"?(r(),i("div",ne,[(r(!0),i(q,null,j(R.days,t=>(r(),i("span",{class:A(["px-2 py-1 m-1 flex justify-center items-center border-2 border-info rounded-full text-sm cursor-pointer",{"bg-info text-white dark:text-gray-50":C(t.value),"text-gray-800 dark:text-gray-400":!C(t.value)}]),onClick:T=>O(t.value)},l(t.label),11,re))),256))])):o("",!0),a.frequency=="date_wise"?(r(),i("div",oe,[(r(!0),i(q,null,j(R.dates,t=>(r(),i("span",{class:A(["w-8 h-8 m-1 flex justify-center items-center border-2 border-info rounded-full text-sm cursor-pointer",{"bg-info text-white dark:text-gray-50":w(t),"text-gray-800 dark:text-gray-400":!w(t)}]),onClick:T=>z(t)},l(t),11,le))),256))])):o("",!0),a.frequency=="day_wise_count"?(r(),b(P,{key:2,type:"number",modelValue:a.dayWiseCount,"onUpdate:modelValue":s[4]||(s[4]=t=>a.dayWiseCount=t),name:"dayWiseCount","leading-text":e.$trans("task.repeat.props.day"),label:e.$trans("task.repeat.props.day"),error:u(d).dayWiseCount,"onUpdate:error":s[5]||(s[5]=t=>u(d).dayWiseCount=t),autofocus:""},null,8,["modelValue","leading-text","label","error"])):o("",!0)])]),k("div",ie,[k("div",de,[f($,{modelValue:a.startDate,"onUpdate:modelValue":s[6]||(s[6]=t=>a.startDate=t),name:"startDate",label:e.$trans("task.repeat.props.start_date"),"no-clear":"",error:u(d).startDate,"onUpdate:error":s[7]||(s[7]=t=>u(d).startDate=t)},null,8,["modelValue","label","error"])]),k("div",ue,[f($,{modelValue:a.endDate,"onUpdate:modelValue":s[8]||(s[8]=t=>a.endDate=t),name:"endDate",label:e.$trans("task.repeat.props.end_date"),"no-clear":"",error:u(d).endDate,"onUpdate:error":s[9]||(s[9]=t=>u(d).endDate=t)},null,8,["modelValue","label","error"])])])],64)):o("",!0)]),_:1},8,["pre-requisites","uuid","form"])):o("",!0)]}),_:1})):o("",!0)}}});export{ye as default};
