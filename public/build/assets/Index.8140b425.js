import{q as g,s as _,r as s,o as v,k as B,l as u,f as l,e as i,b as t}from"./app.537b83f5.js";const V={class:"grid grid-cols-3 gap-6"},k={class:"col-span-3 sm:col-span-1"},y={class:"col-span-3 sm:col-span-1"},A={class:"col-span-3 sm:col-span-1"},C={name:"ConfigFeature"},T=Object.assign(C,{setup(U){const c="config/",n=g(c),p={enableTodo:!1,enableBackup:!1,enableActivityLog:!1,type:"feature"},a=_({...p});return(r,e)=>{const f=s("CardHeader"),d=s("BaseSwitch"),m=s("FormAction"),b=s("ConfigPage");return v(),B(b,null,{default:u(()=>[l(m,{"no-card":"","init-url":c,"data-fetch":"feature","init-form":p,form:a,action:"store","stay-on":"",redirect:"Config"},{default:u(()=>[l(f,{first:"",title:r.$trans("config.feature.feature_config"),description:r.$trans("config.feature.feature_info")},null,8,["title","description"]),i("div",V,[i("div",k,[l(d,{modelValue:a.enableTodo,"onUpdate:modelValue":e[0]||(e[0]=o=>a.enableTodo=o),name:"enableTodo",label:r.$trans("config.feature.props.todo"),error:t(n).enableTodo,"onUpdate:error":e[1]||(e[1]=o=>t(n).enableTodo=o)},null,8,["modelValue","label","error"])]),i("div",y,[l(d,{modelValue:a.enableBackup,"onUpdate:modelValue":e[2]||(e[2]=o=>a.enableBackup=o),name:"enableBackup",label:r.$trans("config.feature.props.backup"),error:t(n).enableBackup,"onUpdate:error":e[3]||(e[3]=o=>t(n).enableBackup=o)},null,8,["modelValue","label","error"])]),i("div",A,[l(d,{modelValue:a.enableActivityLog,"onUpdate:modelValue":e[4]||(e[4]=o=>a.enableActivityLog=o),name:"enableActivityLog",label:r.$trans("config.feature.props.activity_log"),error:t(n).enableActivityLog,"onUpdate:error":e[5]||(e[5]=o=>t(n).enableActivityLog=o)},null,8,["modelValue","label","error"])])])]),_:1},8,["form"])]),_:1})}}});export{T as default};
