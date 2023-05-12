import{c as j,K as ae,u as A,A as G,s as C,q as K,t as J,r as m,o as c,k as H,l as n,e as s,b as d,v as _,x as a,d as U,f as l,m as ne,h as re,y as z,a as $,F,z as q,I as oe}from"./app.537b83f5.js";function Q(p="USD"){let i=j(()=>ae.getters["config/config"]("system.currencies")).value.find(D=>D.name==p);return i===void 0?{decimal:2,position:"prefix"}:i}function E(p=0,r="USD"){let i=Q(r);return se(p,i.decimal||2)}function O(p=0,r="USD"){let i=Q(r);return p=E(p,r),i.position==="prefix"?i.symbol+""+p:p+" "+i.symbol}function se(p,r){r=Math.abs(parseInt(r))||0;var i=Math.pow(10,r);return Math.round(p*i)/i}const le={class:"grid grid-cols-3 gap-6"},ie={class:"col-span-3 sm:col-span-1"},ue={class:"col-span-3 sm:col-span-1"},de={__name:"FilterGenerate",props:{initUrl:{type:String,default:""}},emits:["hide"],setup(p,{emit:r}){const i=p,D=A();G("moment");const B={employee:"",startDate:"",endDate:""},y=C({...B}),b=K(i.initUrl),g=C({employee:"",isLoaded:!D.query.employee});return J(async()=>{g.employee=D.query.employee,g.isLoaded=!0}),(P,f)=>{const w=m("BaseSelectSearch"),L=m("DatePicker"),h=m("FilterForm");return c(),H(h,{"init-form":B,form:y,onHide:f[5]||(f[5]=t=>r("hide"))},{default:n(()=>[s("div",le,[s("div",ie,[g.isLoaded?(c(),H(w,{key:0,name:"employee",label:P.$trans("global.select",{attribute:P.$trans("employee.employee")}),modelValue:y.employee,"onUpdate:modelValue":f[0]||(f[0]=t=>y.employee=t),"value-prop":"uuid","init-search":g.employee,"additional-search-query":{self:0},"search-action":"employee/list",error:d(b).employee,"onUpdate:error":f[1]||(f[1]=t=>d(b).employee=t)},{selectedOption:n(t=>[_(a(t.value.name)+" ("+a(t.value.codeNumber)+") ",1)]),listOption:n(t=>[_(a(t.option.name)+" ("+a(t.option.codeNumber)+") ",1)]),_:1},8,["label","modelValue","init-search","error"])):U("",!0)]),s("div",ue,[l(L,{start:y.startDate,"onUpdate:start":f[2]||(f[2]=t=>y.startDate=t),end:y.endDate,"onUpdate:end":f[3]||(f[3]=t=>y.endDate=t),name:"dateBetween",as:"range",label:P.$trans("payroll.props.period"),error:d(b).startDate,"onUpdate:error":f[4]||(f[4]=t=>d(b).startDate=t)},null,8,["start","end","label","error"])])])]),_:1},8,["form"])}}},ce={class:"font-semibold"},me={class:"space-y-4"},pe={class:"grid grid-cols-2 gap-4"},ye={class:"col-span-2 sm:col-span-1 space-y-4"},fe={class:"col-span-2 sm:col-span-1 space-y-4"},_e={class:"col-span-2 sm:col-span-1"},be={class:"flex justify-between text-lg font-semibold text-success"},ge={class:"col-span-2 sm:col-span-1"},ve={class:"flex justify-between text-lg font-semibold text-danger"},he={class:"col-span-2 sm:col-span-1"},$e={class:"flex justify-between text-xl font-semibold text-success"},De={class:"grid grid-cols-2 gap-3 mt-4"},Ve={class:"col-span-3"},ke={name:"PayrollForm"},Se=Object.assign(ke,{setup(p){const r=A(),i=ne(),D=re(),B=G("emitter"),y={records:[],remarks:""},b="payroll/",g=K(b),P=j(()=>{let e=0;return v.records.filter(u=>u.payHead.type=="earning").forEach(u=>{e+=E(u.amount)}),O(e)}),f=j(()=>{let e=0;return v.records.filter(u=>u.payHead.type=="deduction").forEach(u=>{e+=E(u.amount)}),O(e)}),w=j(()=>{let e=0;return v.records.forEach(u=>{u.payHead.type=="earning"?e+=E(u.amount):e-=E(u.amount)}),O(e)}),L=z(!1),h=z(!1),t=C({}),v=C({...y}),T=async()=>{h.value=!1,L.value=!0,await D.dispatch(b+"fetchDetail",{params:r.query}).then(e=>{Object.assign(t,{attendanceSummary:e.attendanceSummary,netEarning:e.netEarning,netDeduction:e.netDeduction,netSalary:e.netSalary}),Object.assign(v,{records:e.records}),L.value=!1,h.value=!0}).catch(e=>{L.value=!1})},W=e=>{var u;Object.assign(t,{codeNumber:e.codeNumber,employee:e.employee,period:e.period,attendanceSummary:e.attendanceSummary,netEarning:e.netEarning,netDeduction:e.netDeduction,netSalary:e.netSalary}),Object.assign(y,{records:e.records,remarks:e.remarks}),Object.assign(v,oe(y)),i.push({name:r.name,query:{employee:(u=e.employee)==null?void 0:u.uuid,startDate:e.startDate,endDate:e.endDate}})},X=()=>{h.value=!1},Y=()=>{h.value=!1,B.emit("resetFilter")};return J(async()=>{if(r.params.uuid){h.value=!0;return}r.query.employee&&r.query.startDate&&r.query.endDate&&await T()}),(e,u)=>{const Z=m("ParentTransition"),V=m("ListItemView"),I=m("ListContainerVertical"),N=m("BaseCard"),M=m("BaseLabel"),R=m("BaseInput"),x=m("BaseTextarea"),ee=m("FormAction"),te=m("DetailLayoutVertical");return c(),$(F,null,[l(Z,{appear:"",visibility:!0},{default:n(()=>[d(r).params.uuid?U("",!0):(c(),H(de,{key:0,onAfterFilter:T,"init-url":b}))]),_:1}),h.value?(c(),H(te,{key:0},{detail:n(()=>[d(r).params.uuid&&t.codeNumber?(c(),H(N,{key:0,"no-padding":"","no-content-padding":""},{title:n(()=>[_(a(e.$trans("payroll.props.code_number"))+" "+a(t.codeNumber),1)]),default:n(()=>[l(I,null,{default:n(()=>[l(V,{label:e.$trans("employee.employee")},{default:n(()=>[_(a(t.employee.name),1)]),_:1},8,["label"]),l(V,{label:e.$trans("company.department.department")},{default:n(()=>[_(a(t.employee.department),1)]),_:1},8,["label"]),l(V,{label:e.$trans("company.designation.designation")},{default:n(()=>[_(a(t.employee.designation),1)]),_:1},8,["label"]),l(V,{label:e.$trans("company.branch.branch")},{default:n(()=>[_(a(t.employee.branch),1)]),_:1},8,["label"]),l(V,{label:e.$trans("employee.employment_status.employment_status")},{default:n(()=>[_(a(t.employee.employmentStatus),1)]),_:1},8,["label"]),l(V,{label:e.$trans("payroll.props.period")},{default:n(()=>[s("span",ce,a(t.period),1)]),_:1},8,["label"])]),_:1})]),_:1})):U("",!0),l(N,{"no-padding":"","no-content-padding":""},{title:n(()=>[_(a(e.$trans("global.summary",{attribute:e.$trans("attendance.attendance")})),1)]),default:n(()=>[l(I,null,{default:n(()=>[(c(!0),$(F,null,q(t.attendanceSummary,o=>(c(),H(V,{align:"right",label:o.name+" ("+o.code+")"},{default:n(()=>[_(a(o.count)+" "+a(e.$trans("list.durations."+o.unit)),1)]),_:2},1032,["label"]))),256))]),_:1})]),_:1})]),default:n(()=>[s("div",me,[h.value?(c(),H(N,{key:0,"is-loading":L.value},{default:n(()=>[l(ee,{"no-card":"","init-url":b,action:d(r).params.uuid?"edit":"generate","init-form":y,form:v,"set-form":W,"after-reset":X,redirect:"Payroll",onCompleted:Y},{default:n(()=>[s("div",pe,[s("div",ye,[(c(!0),$(F,null,q(v.records,(o,k)=>(c(),$("div",null,[o.payHead.type=="earning"?(c(),$(F,{key:0},[l(M,{class:"text-success"},{default:n(()=>[_(a(o.payHead.name)+" ("+a(o.payHead.code)+")",1)]),_:2},1024),l(R,{currency:"",modelValue:o.amount,"onUpdate:modelValue":S=>o.amount=S,name:`records.${k}.amount`,placeholder:o.payHead.name,error:d(g)[`records.${k}.amount`],"onUpdate:error":S=>d(g)[`records.${k}.amount`]=S},null,8,["modelValue","onUpdate:modelValue","name","placeholder","error","onUpdate:error"])],64)):U("",!0)]))),256))]),s("div",fe,[(c(!0),$(F,null,q(v.records,(o,k)=>(c(),$("div",null,[o.payHead.type=="deduction"?(c(),$(F,{key:0},[l(M,{class:"text-danger"},{default:n(()=>[_(a(o.payHead.name)+" ("+a(o.payHead.code)+")",1)]),_:2},1024),l(R,{currency:"",modelValue:o.amount,"onUpdate:modelValue":S=>o.amount=S,name:`records.${k}.amount`,placeholder:o.payHead.name,error:d(g)[`records.${k}.amount`],"onUpdate:error":S=>d(g)[`records.${k}.amount`]=S},null,8,["modelValue","onUpdate:modelValue","name","placeholder","error","onUpdate:error"])],64)):U("",!0)]))),256))]),s("div",_e,[s("div",be,[s("span",null,a(e.$trans("payroll.salary_structure.props.net_earning")),1),s("span",null,a(d(P)),1)])]),s("div",ge,[s("div",ve,[s("span",null,a(e.$trans("payroll.salary_structure.props.net_deduction")),1),s("span",null,a(d(f)),1)])]),s("div",he,[s("div",$e,[s("span",null,a(e.$trans("payroll.salary_structure.props.net_salary")),1),s("span",null,a(d(w)),1)])])]),s("div",De,[s("div",Ve,[l(x,{modelValue:v.remarks,"onUpdate:modelValue":u[0]||(u[0]=o=>v.remarks=o),name:"remarks",label:e.$trans("payroll.props.remarks"),error:d(g).remarks,"onUpdate:error":u[1]||(u[1]=o=>d(g).remarks=o)},null,8,["modelValue","label","error"])])])]),_:1},8,["action","form"])]),_:1},8,["is-loading"])):U("",!0)])]),_:1})):U("",!0)],64)}}}),Ue={name:"PayrollAction"},He=Object.assign(Ue,{setup(p){const r=A();return(i,D)=>{const B=m("PageHeaderAction"),y=m("PageHeader"),b=m("ParentTransition");return c(),$(F,null,[l(y,{title:i.$trans(d(r).meta.trans,{attribute:i.$trans(d(r).meta.label)}),navs:[{label:i.$trans("payroll.payroll"),path:"Payroll"}]},{default:n(()=>[l(B,{name:"Payroll",title:i.$trans("payroll.payroll"),actions:["list"]},null,8,["title"])]),_:1},8,["title","navs"]),l(b,{appear:"",visibility:!0},{default:n(()=>[l(Se)]),_:1})],64)}}});export{He as default};
