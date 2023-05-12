import{o as a,a as c,e,h as x,c as d,r as i,f as o,n as k,b as t,F as A,p as F,g as h,i as B,j as U,w as C,k as $,d as w,l as D,u as H}from"./app.537b83f5.js";function j(f,s){return a(),c("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z","clip-rule":"evenodd"})])}function E(f,s,n){!window.Echo||window.Echo.private(f).listen("."+s,u=>{n(u)})}const R={class:"hidden lg:flex lg:shrink-0"},V={class:"h-0 flex-1 flex flex-col overflow-x-hidden scroller-thin-y scroller-hidden"},q={class:"px-0 mt-6"},O={__name:"AppSidebar",setup(f){const s=x(),n=d(()=>s.getters["layout/getSidebarType"]),u=d(()=>n.value==="mini"),p=d(()=>n.value==="full"),l=d(()=>n.value==="pinned");d(()=>p.value||l.value);const m=()=>{l.value||s.dispatch("layout/setSidebarType","full")},_=()=>{l.value||s.dispatch("layout/setSidebarType","mini")};return(v,y)=>{const b=i("MobileSidebar"),g=i("AppNavigation");return a(),c(A,null,[o(b),e("div",R,[e("div",{onMouseover:m,onMouseleave:_,class:k(["flex flex-col transition-all duration-200 ease-out border-r border-primary dark:border-gray-700 pt-5 pb-4 bg-primary dark:bg-dark-header",{"absolute top-0 left-0 z-40 h-full":!t(l),"w-16":t(u),"w-64":t(p)||t(l)}])},[e("div",V,[e("nav",q,[o(g)])])],34)])],64)}}},I={class:"relative z-10 shrink-0 flex justify-between h-16 bg-black dark:bg-dark-header dark:border-b dark:border-gray-700"},G={class:"flex"},J={class:"flex items-center"},K=["src"],Q=["src"],W=e("span",{class:"sr-only"},"Pinned Sidebar",-1),X={key:0,class:"far fa-circle h-6 w-6","aria-hidden":"true"},Y={key:1,class:"fas fa-dot-circle h-6 w-6","aria-hidden":"true"},Z=e("span",{class:"sr-only"},"Open Mobile Sidebar",-1),ee={class:"flex justify-between items-center space-x-4 px-4"},te={key:1},se=e("i",{class:"text-white fas fa-cog"},null,-1),oe={key:2,class:"hidden sm:block"},ne=e("i",{class:"fas fa-circle h-4 w-4 text-danger"},null,-1),ae=[ne],ie={class:"flex items-center"},re={__name:"AppHeader",setup(f){const s=x(),n=F("config:store"),u=h("assets.logoLight"),p=h("layout.display").value=="dark"?h("assets.iconLight"):h("assets.icon"),l=h("system.mode"),m=h("system.enableMaintenanceMode"),_=d(()=>s.getters["layout/getSidebarType"]==="pinned"),v=B("isStaff"),y=r=>{s.dispatch("layout/setMobileSidebar",r)},b=r=>{s.dispatch("layout/setUserLayout",r)},g=()=>{let r=_.value?"mini":"pinned";b({sidebar:r})};return(r,S)=>{const T=i("BaseBadge"),L=i("TimesheetClock"),P=i("TeamSelection"),z=i("router-link"),N=i("ProfileDropdown"),M=U("tooltip");return a(),c("div",I,[e("div",G,[e("div",J,[e("img",{src:t(u),class:"hidden sm:block h-12 ml-4 mr-2"},null,8,K),e("img",{src:t(p),class:"sm:hidden h-12 mx-2"},null,8,Q),C((a(),c("button",{type:"button",class:"h-full w-full px-4 text-gray-500 focus:outline-none hidden lg:block",onClick:g},[W,t(_)?(a(),c("i",Y)):(a(),c("i",X))])),[[M,r.$trans("global.toggle",{attribute:r.$trans("general.sidebar")})]]),t(l)?w("",!0):(a(),$(T,{key:0,class:"hidden sm:block",design:"danger",label:r.$trans("general.demo")},null,8,["label"])),e("button",{type:"button",class:"h-full w-full px-2 sm:px-4 text-gray-500 focus:outline-none lg:hidden",onClick:S[0]||(S[0]=ce=>y(!0))},[Z,o(t(j),{class:"h-6 w-6","aria-hidden":"true"})])])]),e("div",ee,[t(v)?(a(),$(L,{key:0})):w("",!0),o(P),t(n)?(a(),c("div",te,[o(z,{to:{name:"Config"}},{default:D(()=>[se]),_:1})])):w("",!0),t(m)?C((a(),c("div",oe,ae)),[[M,r.$trans("general.under_maintenance")]]):w("",!0),e("div",ie,[o(N)])])])}}},le={class:"relative h-screen flex overflow-hidden bg-gray-200 dark:bg-dark-body"},ue={__name:"App",setup(f){const s=x(),n=H(),u=d(()=>s.getters["layout/getSidebarType"]==="pinned"),p=d(()=>!n.meta.noPadding),l=B("uuid");return E(`users.${l.value}`,"test.event",m=>{var _=new Audio("/notification.mp3");_.play()}),(m,_)=>{const v=i("NotificationBar"),y=i("router-view"),b=i("FooterCredit"),g=i("ReLogin");return a(),c(A,null,[o(v,{type:"app"}),e("div",le,[o(O),e("div",{class:k(["flex-1 flex flex-col w-0 overflow-hidden",{"lg:ml-16":!t(u)}])},[o(re),e("main",{class:k(["flex-1 relative z-0 focus:outline-none scroller-thin-y scroller-hidden",{"overflow-y-auto":t(n).query.view!="board","overflow-y-hidden":t(n).query.view=="board"}])},[e("div",{class:k(["space-y-4",{"lg:px-4 py-4":t(p)}])},[o(y)],2),o(b)],2)],2)]),o(g)],64)}}};export{ue as default};