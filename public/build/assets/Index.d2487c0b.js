import{h as k,y as w,s as D,t as j,r as d,o as l,k as b,l as a,e,a as h,F as x,z as S,x as t,n as C,A,i as O,w as R,B as N,f as r,v as u,b as g,d as $}from"./app.537b83f5.js";import{C as L,r as T,B as q}from"./index.e4226d08.js";const M={class:"mt-4 w-full grid grid-cols-1 md:grid-cols-3 gap-4"},z={class:"bg-white dark:bg-dark-header shadow rounded-lg p-2 sm:p-4 xl:p-4"},V={class:"flex items-center"},Y={class:"shrink-0"},F={class:"mt-2 text-base font-normal text-gray-500 uppercase"},H={class:"text-2xl sm:text-3xl leading-none font-semibold text-gray-900 dark:text-gray-400"},E={class:"mt-2 text-xs font-normal text-gray-700 uppercase"},I={class:"ml-5 w-0 flex items-center justify-end flex-1 font-bold"},P={name:"DashboardStat"},U=Object.assign(P,{setup(p){const s=k(),c=w(!1),i=D({stats:[]});return j(async()=>{c.value=!0,await s.dispatch("dashboard/getStat").then(n=>{c.value=!1,Object.assign(i,{stats:n.stats})}).catch(n=>{c.value=!1})}),(n,o)=>{const m=d("BaseLoader");return l(),b(m,{"is-loading":c.value},{default:a(()=>[e("div",M,[(l(!0),h(x,null,S(i.stats,_=>(l(),h("div",z,[e("div",V,[e("div",Y,[e("h3",F,t(_.title),1),e("p",H,t(_.count),1),e("h6",E,t(_.secondaryCount)+" "+t(_.secondaryTitle),1)]),e("div",I,[e("div",{class:C(["rounded-full",[_.color]])},[e("i",{class:C([_.icon,"text-white h-12 w-12 flex items-center justify-center"])},null,2)],2)])])]))),256))])]),_:1},8,["is-loading"])}}}),G={class:"fas fa-check"},J={class:"text-2xl font-semibold"},K={class:"p-4 border-b border-gray-200 hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-neutral-700"},Q={class:"flex items-center"},W={class:"shrink-0"},X={class:"ml-5 w-0 flex items-center flex-1"},Z={class:"dark:text-gray-400"},ee={class:"text-sm dark:text-gray-500"},te={name:"DashboardAgenda"},se=Object.assign(te,{setup(p){const s=k(),c=A("moment"),i=O("profile.name"),n=w(!1),o=D([]);return j(async()=>{n.value=!0,await s.dispatch("dashboard/getAgenda").then(m=>{n.value=!1,Object.assign(o,m)}).catch(m=>{n.value=!1})}),(m,_)=>{const B=d("BaseCard");return l(),h(x,null,[R(e("template",G,null,512),[[N,!1]]),r(B,{"no-padding":"","is-loading":n.value},{title:a(()=>[u(t(m.$trans("general.greeting_message",{name:g(i)}))+" ",1),e("h3",J,t(g(c)().format("dddd Do, MMMM YYYY")),1)]),default:a(()=>[(l(!0),h(x,null,S(o,v=>(l(),h("div",K,[e("div",Q,[e("div",W,[e("div",{class:C(["rounded-full p-2",[v.color]])},[e("i",{class:C([v.icon,"text-white h-6 w-6 flex items-center justify-center"])},null,2)],2)]),e("div",X,[e("div",null,[e("p",Z,t(v.title),1),e("p",ee,t(v.date),1)])])])]))),256))]),_:1},8,["is-loading"])],64)}}}),ae={name:"DashboardChart"},oe=Object.assign(ae,{setup(p){L.register(...T);const s=k(),c=w({scales:{x:{stacked:!0},y:{stacked:!0}}}),i=w(!1),n=D({});return j(async()=>{i.value=!0,await s.dispatch("dashboard/getChart").then(o=>{i.value=!1,Object.assign(n,o)}).catch(o=>{i.value=!1})}),(o,m)=>{const _=d("BaseCard");return l(),b(_,{"is-loading":i.value},{title:a(()=>[u(t(o.$trans("global.summary",{attribute:o.$trans("attendance.attendance")})),1)]),default:a(()=>[n.labels?(l(),b(g(q),{key:0,chartData:n,options:c.value},null,8,["chartData","options"])):$("",!0)]),_:1},8,["is-loading"])}}}),le={class:"block text-xs"},ne={key:1,class:"p-2"},re={name:"DashboardLeaveRequestRecord"},ce=Object.assign(re,{props:{records:{type:Array,default:[]}},setup(p){const s=A("$trans");k();const c=[{key:"employee",label:s("employee.employee"),visibility:!0},{key:"type",label:s("leave.type.type"),visibility:!0},{key:"period",label:s("leave.request.props.period"),visibility:!0},{key:"status",label:s("leave.request.props.status"),visibility:!0}];return(i,n)=>{const o=d("DataCell"),m=d("BaseBadge"),_=d("DataRow"),B=d("SimpleTable"),v=d("BaseAlert"),f=d("BaseCard");return l(),b(f,{"no-padding":"","no-content-padding":""},{title:a(()=>[u(t(g(s)("global.recent",{attribute:g(s)("leave.request.request")})),1)]),default:a(()=>[p.records.length>0?(l(),b(B,{key:0,header:c},{default:a(()=>[(l(!0),h(x,null,S(p.records,y=>(l(),b(_,{key:y.uuid},{default:a(()=>[r(o,{name:"employee"},{default:a(()=>[u(t(y.employee.name)+" ("+t(y.employee.codeNumber)+") ",1),e("span",le,t(y.employee.designation)+" @ "+t(y.employee.branch),1)]),_:2},1024),r(o,{name:"type"},{default:a(()=>[u(t(y.leaveType.name),1)]),_:2},1024),r(o,{name:"period"},{default:a(()=>[u(t(y.period),1)]),_:2},1024),r(o,{name:"status"},{default:a(()=>[r(m,{label:y.statusDetail.label,design:y.statusDetail.color},null,8,["label","design"])]),_:2},1024)]),_:2},1024))),128))]),_:1})):$("",!0),p.records.length==0?(l(),h("div",ne,[r(v,{size:"xs",design:"info"},{default:a(()=>[u(t(g(s)("general.errors.record_not_found")),1)]),_:1})])):$("",!0)]),_:1})}}}),ie={class:"block text-xs"},de={key:1,class:"p-2"},_e={name:"DashboardPayrollRecord"},ue=Object.assign(_e,{props:{records:{type:Array,default:[]}},setup(p){const s=A("$trans");k();const c=[{key:"codeNumber",label:s("payroll.props.code_number"),visibility:!0},{key:"employee",label:s("employee.employee"),visibility:!0},{key:"period",label:s("payroll.props.period"),visibility:!0},{key:"total",label:s("payroll.salary_structure.props.net_salary"),visibility:!0}];return(i,n)=>{const o=d("DataCell"),m=d("DataRow"),_=d("SimpleTable"),B=d("BaseAlert"),v=d("BaseCard");return l(),b(v,{"no-padding":"","no-content-padding":""},{title:a(()=>[u(t(g(s)("global.recent",{attribute:g(s)("payroll.payroll")})),1)]),default:a(()=>[p.records.length>0?(l(),b(_,{key:0,header:c},{default:a(()=>[(l(!0),h(x,null,S(p.records,f=>(l(),b(m,{key:f.uuid},{default:a(()=>[r(o,{name:"codeNumber"},{default:a(()=>[u(t(f.codeNumber),1)]),_:2},1024),r(o,{name:"employee"},{default:a(()=>[u(t(f.employee.name)+" ("+t(f.employee.codeNumber)+") ",1),e("span",ie,t(f.employee.designation)+" @ "+t(f.employee.branch),1)]),_:2},1024),r(o,{name:"period"},{default:a(()=>[u(t(f.period),1)]),_:2},1024),r(o,{name:"total"},{default:a(()=>[u(t(f.totalDisplay),1)]),_:2},1024)]),_:2},1024))),128))]),_:1})):$("",!0),p.records.length==0?(l(),h("div",de,[r(B,{size:"xs",design:"info"},{default:a(()=>[u(t(g(s)("general.errors.record_not_found")),1)]),_:1})])):$("",!0)]),_:1})}}}),pe={class:"col-span-1"},me={class:"col-span-1"},he={name:"DashboardRecord"},fe=Object.assign(he,{setup(p){const s=k(),c=w(!1),i=D({});return j(async()=>{c.value=!0,await s.dispatch("dashboard/getRecord").then(n=>{c.value=!1,Object.assign(i,n)}).catch(n=>{c.value=!1})}),(n,o)=>(l(),h(x,null,[e("div",pe,[r(ce,{records:i.leaveRequests},null,8,["records"])]),e("div",me,[r(ue,{records:i.payrolls},null,8,["records"])])],64))}}),ge={key:0},ye={class:"px-4 pt-6 pb-16"},be={class:"-mt-10 px-4 w-full grid grid-cols-1 md:grid-cols-3 gap-4"},ve={class:"col-span-1"},xe={class:"col-span-1 sm:col-span-2"},$e={class:"mt-4 px-4 w-full grid grid-cols-1 lg:grid-cols-2 gap-4"},we={__name:"Index",setup(p){const s=O("isStaff");return(c,i)=>g(s)?(l(),h("div",ge,[e("div",ye,[r(U)]),e("div",be,[e("div",ve,[r(se)]),e("div",xe,[r(oe)])]),e("div",$e,[r(fe)])])):$("",!0)}};export{we as default};