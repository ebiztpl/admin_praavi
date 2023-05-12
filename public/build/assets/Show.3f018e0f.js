import{h as H,q as G,y as q,s as I,E as J,t as te,r as d,o,k as n,l as r,v as l,x as u,a as g,d as i,F as O,z as ae,b as e,I as se,u as oe,m as re,A as N,j as ie,f as b,p as U,e as j,w as E}from"./app.537b83f5.js";const ne={key:0,class:"space-x-1"},le={name:"TaskTagList"},ue=Object.assign(le,{props:{task:{type:Object,default(){return{}}}},emits:["refresh"],setup(S,{emit:y}){const $=S;H();const a={tags:[]},k="task/",F=G(k),h=q(!1),A=I({...a}),T=I({tags:[],isLoaded:!1}),w=p=>{Object.assign(a,{tags:p.map(c=>c.uuid)}),Object.assign(A,se(a)),T.tags=p.map(c=>c.uuid),T.isLoaded=!0},t=()=>{h.value=!1,y("refresh")};return J(()=>$.task.tags,p=>{w(p)}),te(()=>{var p;w(((p=$.task)==null?void 0:p.tags)||[])}),(p,c)=>{const s=d("BaseBadge"),f=d("BaseSelectSearch"),L=d("FormAction"),M=d("BaseDataView");return o(),n(M,{class:"col-span-1 sm:col-span-4"},{label:r(()=>[l(u(p.$trans("general.tags"))+" ",1),S.task.isOwner&&!h.value?(o(),g("i",{key:0,class:"fas fa-edit cursor-pointer",onClick:c[0]||(c[0]=_=>h.value=!0)})):i("",!0)]),default:r(()=>[h.value?i("",!0):(o(),g("div",ne,[(o(!0),g(O,null,ae(S.task.tags||[],_=>(o(),n(s,{design:"primary"},{default:r(()=>[l(u(_.name),1)]),_:2},1024))),256))])),h.value?(o(),n(L,{key:1,"no-card":"","no-data-fetch":"","cancel-action":"",action:"updateTags","keep-adding":!1,"init-url":k,"init-form":a,form:A,"after-submit":t,onCancelled:c[3]||(c[3]=_=>h.value=!1)},{default:r(()=>[T.isLoaded?(o(),n(f,{key:0,tags:"",name:"tags",placeholder:p.$trans("global.select",{attribute:p.$trans("general.tag")}),modelValue:A.tags,"onUpdate:modelValue":c[1]||(c[1]=_=>A.tags=_),error:e(F).tags,"onUpdate:error":c[2]||(c[2]=_=>e(F).tags=_),"init-search":T.tags,"search-action":"tag/list"},null,8,["placeholder","modelValue","error","init-search"])):i("",!0)]),_:1},8,["form"])):i("",!0)]),_:1})}}}),de={key:0,class:"fas fa-star text-warning"},ce={key:1,class:"fa-regular fa-star text-warning"},me={class:"ml-2 space-x-2"},ke={key:0,class:"fas fa-box-archive text-primary dark:text-gray-400"},pe={key:1,class:"fas fa-ban text-danger"},ge={class:"space-x-2"},fe={class:"grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-4"},be={key:0,class:"fas fa-check-circle fa-lg text-success"},ve={name:"TaskShow"},_e=Object.assign(ve,{setup(S){H();const y=oe(),$=re(),a=N("$trans"),k=N("emitter");let F=["list"];const h={},A={status:"",comment:""},T="task/";I({}),G(T),I({...A});const w=q(!1),t=I({...h}),p=c=>{Object.assign(t,c)};return J(()=>y.params.uuid,c=>{w.value=!0}),(c,s)=>{const f=d("BaseButton"),L=d("DropdownItem"),M=d("PageHeaderAction"),_=d("PageHeader"),K=d("BaseTab"),V=d("BaseBadge"),C=d("BaseDataView"),Q=d("EmployeeSummary"),W=d("ProgressBar"),X=d("BaseCard"),Y=d("router-view"),Z=d("ShowItem"),ee=d("ParentTransition"),P=ie("tooltip");return o(),g(O,null,[t.uuid?(o(),n(_,{key:0,title:e(a)(e(y).meta.trans,{attribute:e(a)(e(y).meta.label)}),navs:[{label:e(a)("task.task"),path:"TaskList"},{label:t.codeNumber,path:{name:"TaskShow",params:{uuid:t.uuid}}}]},{default:r(()=>[b(M,{name:"Task",title:e(a)("task.task"),actions:e(F)},{dropdown:r(()=>{var m,v;return[e(U)("task:edit")&&((m=t.permission)==null?void 0:m.isEditable)?(o(),n(L,{key:0,icon:"fas fa-pencil",onClick:s[3]||(s[3]=B=>e($).push({name:"TaskEdit",params:{uuid:t.uuid}}))},{default:r(()=>[l(u(e(a)("global.edit",{attribute:e(a)("task.task")})),1)]),_:1})):i("",!0),e(U)("task:delete")&&((v=t.permission)==null?void 0:v.isDeletable)?(o(),n(L,{key:1,icon:"fas fa-trash",onClick:s[4]||(s[4]=B=>e(k).emit("showDeleteItem",{uuid:t.uuid}))},{default:r(()=>[l(u(e(a)("global.delete",{attribute:e(a)("task.task")})),1)]),_:1})):i("",!0)]}),default:r(()=>{var m,v,B;return[t.isCompleted?i("",!0):(o(),g(O,{key:0},[e(y).name=="TaskChecklistList"&&((m=t.permission)==null?void 0:m.manageChecklist)?(o(),n(f,{key:0,design:"white",onClick:s[0]||(s[0]=x=>e(k).emit("addTaskChecklist"))},{default:r(()=>[l(u(e(a)("global.add",{attribute:e(a)("task.checklist.checklist")})),1)]),_:1})):i("",!0),e(y).name=="TaskMemberList"&&((v=t.permission)==null?void 0:v.manageMember)?(o(),n(f,{key:1,design:"white",onClick:s[1]||(s[1]=x=>e(k).emit("addTaskMember"))},{default:r(()=>[l(u(e(a)("global.add",{attribute:e(a)("task.member.member")})),1)]),_:1})):i("",!0),e(y).name=="TaskMediaList"&&((B=t.permission)==null?void 0:B.manageMedia)?(o(),n(f,{key:2,design:"white",onClick:s[2]||(s[2]=x=>e(k).emit("addTaskMedia"))},{default:r(()=>[l(u(e(a)("global.add",{attribute:e(a)("task.media.media")})),1)]),_:1})):i("",!0)],64))]}),_:1},8,["title","actions"])]),_:1},8,["title","navs"])):i("",!0),b(ee,{appear:"",visibility:!0},{default:r(()=>[b(Z,{"init-url":T,uuid:e(y).params.uuid,onSetItem:p,onRedirectTo:s[15]||(s[15]=m=>e($).push({name:"Task"})),refresh:w.value,onRefreshed:s[16]||(s[16]=m=>w.value=!1)},{default:r(()=>[t?(o(),n(K,{key:0,tabs:[{name:"TaskShowGeneral",icon:"fas fa-home",label:e(a)("general.detail"),path:"TaskShowGeneral"},{name:"TaskMember",icon:"fas fa-users",label:e(a)("task.member.member"),count:t.memberCount,path:"TaskMemberList"},{name:"TaskChecklist",icon:"fas fa-list",label:e(a)("task.checklist.checklist"),count:t.checklistCount,path:"TaskChecklistList"},{name:"TaskMedia",icon:"fas fa-paperclip",label:e(a)("task.media.media"),count:t.mediaCount,path:"TaskMediaList"},{name:"TaskRepeat",icon:"fas fa-repeat",label:e(a)("task.repeat.repeat"),path:"TaskRepeatList"}]},null,8,["tabs"])):i("",!0),t.uuid?(o(),n(X,{key:1},{title:r(()=>{var m;return[(m=t.permission)!=null&&m.toggleFavorite?(o(),g("span",{key:0,class:"cursor-pointer",onClick:s[5]||(s[5]=v=>e(k).emit("showActionItem",{uuid:t.uuid,action:"toggleFavorite",confirmation:!0}))},[t.isFavorite?(o(),g("i",de)):(o(),g("i",ce))])):i("",!0),l(" #"+u(t.codeNumber)+" - "+u(t.title)+" ",1),j("span",me,[t.isArchived?E((o(),g("i",ke,null,512)),[[P,e(a)("general.archived")]]):i("",!0),t.isCancelled?E((o(),g("i",pe,null,512)),[[P,e(a)("general.cancelled")]]):i("",!0),t.repeatedTaskUuid?E((o(),g("i",{key:2,class:"fas fa-rotate-right text-info cursor-pointer",onClick:s[6]||(s[6]=v=>e($).push({name:"TaskShow",params:{uuid:t.repeatedTaskUuid}}))},null,512)),[[P,e(a)("task.repeat.repeated_task")]]):i("",!0)])]}),action:r(()=>{var m,v,B,x,R,z;return[j("div",ge,[(m=t.permission)!=null&&m.markAsComplete?(o(),n(f,{key:0,size:"xs",design:"success",onClick:s[7]||(s[7]=D=>e(k).emit("showActionItem",{uuid:t.uuid,action:"status",data:{status:"complete"},confirmation:!0}))},{default:r(()=>[l(u(e(a)("global.mark",{attribute:e(a)("task.statuses.complete")})),1)]),_:1})):i("",!0),(v=t.permission)!=null&&v.markAsCancel?(o(),n(f,{key:1,size:"xs",design:"danger",onClick:s[8]||(s[8]=D=>e(k).emit("showActionItem",{uuid:t.uuid,action:"status",data:{status:"cancel"},confirmation:!0}))},{default:r(()=>[l(u(e(a)("global.mark",{attribute:e(a)("task.statuses.cancel")})),1)]),_:1})):i("",!0),(B=t.permission)!=null&&B.markAsActive?(o(),n(f,{key:2,size:"xs",design:"success",onClick:s[9]||(s[9]=D=>e(k).emit("showActionItem",{uuid:t.uuid,action:"status",data:{status:"active"},confirmation:!0}))},{default:r(()=>[l(u(e(a)("global.mark",{attribute:e(a)("task.statuses.active")})),1)]),_:1})):i("",!0),(x=t.permission)!=null&&x.markAsIncomplete?(o(),n(f,{key:3,size:"xs",design:"danger",onClick:s[10]||(s[10]=D=>e(k).emit("showActionItem",{uuid:t.uuid,action:"status",data:{status:"incomplete"},confirmation:!0}))},{default:r(()=>[l(u(e(a)("global.mark",{attribute:e(a)("task.statuses.incomplete")})),1)]),_:1})):i("",!0),(R=t.permission)!=null&&R.moveToArchive?(o(),n(f,{key:4,size:"xs",onClick:s[11]||(s[11]=D=>e(k).emit("showActionItem",{uuid:t.uuid,action:"status",data:{status:"archive"},confirmation:!0}))},{default:r(()=>[l(u(e(a)("global.move_to",{attribute:e(a)("general.archive")})),1)]),_:1})):i("",!0),(z=t.permission)!=null&&z.moveFromArchive?(o(),n(f,{key:5,size:"xs",onClick:s[12]||(s[12]=D=>e(k).emit("showActionItem",{uuid:t.uuid,action:"status",data:{status:"unarchive"},confirmation:!0}))},{default:r(()=>[l(u(e(a)("global.move_from",{attribute:e(a)("general.archive")})),1)]),_:1})):i("",!0)])]}),progress:r(()=>[t.hasProgress?(o(),n(W,{key:0,rounded:"",height:"h-2","bg-color":"transparent",percent:t.progress,color:t.progressColor},null,8,["percent","color"])):i("",!0)]),default:r(()=>[j("dl",fe,[b(C,{label:e(a)("task.category.category")},{default:r(()=>[t.category?(o(),n(V,{key:0,design:t.category.color?"custom":"",color:t.category.color},{default:r(()=>[l(u(t.category.name),1)]),_:1},8,["design","color"])):i("",!0)]),_:1},8,["label"]),b(C,{label:e(a)("task.priority.priority")},{default:r(()=>[t.priority?(o(),n(V,{key:0,design:t.priority.color?"custom":"",color:t.priority.color},{default:r(()=>[l(u(t.priority.name),1)]),_:1},8,["design","color"])):i("",!0)]),_:1},8,["label"]),b(C,{label:e(a)("task.props.start_date")},{default:r(()=>[l(u(t.startDateDisplay),1)]),_:1},8,["label"]),b(C,{label:e(a)("task.props.due_date")},{default:r(()=>[l(u(t.dueDateDisplay)+" ",1),t.isCompleted?(o(),g("i",be)):i("",!0),l(),t.isOverdue?(o(),n(V,{key:1,design:"danger"},{default:r(()=>[l(u(t.overdueDaysDisplay),1)]),_:1})):i("",!0)]),_:1},8,["label"]),b(ue,{task:t,onRefresh:s[13]||(s[13]=m=>w.value=!0)},null,8,["task"]),t.owner?(o(),n(C,{key:0,class:"col-span-1 sm:col-span-2",label:e(a)("task.props.owner")},{default:r(()=>[b(Q,{employee:t.owner},null,8,["employee"])]),_:1},8,["label"])):i("",!0),b(C,{label:e(a)("general.created_at")},{default:r(()=>[l(u(t.createdAt),1)]),_:1},8,["label"]),b(C,{label:e(a)("general.updated_at")},{default:r(()=>[l(u(t.updatedAt),1)]),_:1},8,["label"])])]),_:1})):i("",!0),t.uuid?(o(),n(Y,{key:2,task:t,onRefresh:s[14]||(s[14]=m=>w.value=!0)},null,8,["task"])):i("",!0)]),_:1},8,["uuid","refresh"])]),_:1})],64)}}});export{_e as default};