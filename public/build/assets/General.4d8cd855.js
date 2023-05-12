import{u as y,A as x,q as R,c as F,s as c,r as s,o as L,a as P,f as d,b as o,l as m,F as S,e as i,v as B,x as T}from"./app.537b83f5.js";const D={class:"grid grid-cols-3 gap-4"},E={class:"col-span-3 sm:col-span-1"},M={class:"col-span-3 sm:col-span-1"},A=i("div",{class:"col-span-3 sm:col-span-1"},null,-1),j={class:"col-span-3 sm:col-span-1"},w={class:"col-span-3 sm:col-span-1"},C={class:"col-span-3 sm:col-span-1"},k={class:"col-span-3"},H={class:"col-span-3 sm:col-span-1"},O={class:"col-span-3 sm:col-span-1"},$=i("div",{class:"col-span-3 sm:col-span-1"},null,-1),G={class:"col-span-3 sm:col-span-1"},z={class:"col-span-3 sm:col-span-1"},J=i("div",{class:"col-span-3 sm:col-span-1"},null,-1),K={class:"col-span-3 sm:col-span-1"},Q={class:"col-span-3 sm:col-span-1"},W={name:"EmployeeConfigGeneral"},Z=Object.assign(W,{setup(X){const f=y(),u=x("$trans"),b="config/",n=R(b),_=F(()=>u("global.placeholder_info",{attribute:p.datePlaceholders})),p=c({datePlaceholders:""}),N={enableMiddleNameField:!1,enableThirdNameField:!1,codeNumberPrefix:"",codeNumberDigit:"",codeNumberSuffix:"",uniqueIdNumber1Label:"",uniqueIdNumber2Label:"",uniqueIdNumber3Label:"",isUniqueIdNumber1Required:!1,isUniqueIdNumber2Required:!1,isUniqueIdNumber3Required:!1,type:"employee"},r=c({...N}),I=q=>{Object.assign(p,{datePlaceholders:q.datePlaceholders.map(e=>e.value).join(", ")})};return(q,e)=>{const U=s("PageHeader"),t=s("BaseSwitch"),a=s("BaseInput"),V=s("BaseAlert"),g=s("FormAction"),v=s("ParentTransition");return L(),P(S,null,[d(U,{title:o(u)(o(f).meta.label),navs:[{label:o(u)("employee.employee"),path:"Employee"}]},null,8,["title","navs"]),d(v,{appear:"",visibility:!0},{default:m(()=>[d(g,{"pre-requisites":{data:["datePlaceholders"]},onSetPreRequisites:I,"init-url":b,"data-fetch":"employee",action:"store","init-form":N,form:r,"stay-on":"",redirect:"Employee"},{default:m(()=>[i("div",D,[i("div",E,[d(t,{vertical:"",modelValue:r.enableMiddleNameField,"onUpdate:modelValue":e[0]||(e[0]=l=>r.enableMiddleNameField=l),name:"enableMiddleNameField",label:o(u)("employee.config.props.enable_middle_name_field"),error:o(n).enableMiddleNameField,"onUpdate:error":e[1]||(e[1]=l=>o(n).enableMiddleNameField=l)},null,8,["modelValue","label","error"])]),i("div",M,[d(t,{vertical:"",modelValue:r.enableThirdNameField,"onUpdate:modelValue":e[2]||(e[2]=l=>r.enableThirdNameField=l),name:"enableThirdNameField",label:o(u)("employee.config.props.enable_third_name_field"),error:o(n).enableThirdNameField,"onUpdate:error":e[3]||(e[3]=l=>o(n).enableThirdNameField=l)},null,8,["modelValue","label","error"])]),A,i("div",j,[d(a,{type:"text",modelValue:r.codeNumberPrefix,"onUpdate:modelValue":e[4]||(e[4]=l=>r.codeNumberPrefix=l),name:"codeNumberPrefix",label:o(u)("employee.config.props.number_prefix"),error:o(n).codeNumberPrefix,"onUpdate:error":e[5]||(e[5]=l=>o(n).codeNumberPrefix=l)},null,8,["modelValue","label","error"])]),i("div",w,[d(a,{type:"number",modelValue:r.codeNumberDigit,"onUpdate:modelValue":e[6]||(e[6]=l=>r.codeNumberDigit=l),name:"codeNumberDigit",label:o(u)("employee.config.props.number_digit"),error:o(n).codeNumberDigit,"onUpdate:error":e[7]||(e[7]=l=>o(n).codeNumberDigit=l)},null,8,["modelValue","label","error"])]),i("div",C,[d(a,{type:"text",modelValue:r.codeNumberSuffix,"onUpdate:modelValue":e[8]||(e[8]=l=>r.codeNumberSuffix=l),name:"codeNumberSuffix",label:o(u)("employee.config.props.number_suffix"),error:o(n).codeNumberSuffix,"onUpdate:error":e[9]||(e[9]=l=>o(n).codeNumberSuffix=l)},null,8,["modelValue","label","error"])]),i("div",k,[d(V,{design:"info"},{default:m(()=>[B(T(o(_)),1)]),_:1})]),i("div",H,[d(a,{type:"text",modelValue:r.uniqueIdNumber1Label,"onUpdate:modelValue":e[10]||(e[10]=l=>r.uniqueIdNumber1Label=l),name:"uniqueIdNumber1Label",label:o(u)("employee.config.props.unique_id_number1_label"),error:o(n).uniqueIdNumber1Label,"onUpdate:error":e[11]||(e[11]=l=>o(n).uniqueIdNumber1Label=l)},null,8,["modelValue","label","error"])]),i("div",O,[d(t,{vertical:"",modelValue:r.isUniqueIdNumber1Required,"onUpdate:modelValue":e[12]||(e[12]=l=>r.isUniqueIdNumber1Required=l),name:"uniqueIdNumber1Required",label:o(u)("employee.config.props.unique_id_number1_required"),error:o(n).isUniqueIdNumber1Required,"onUpdate:error":e[13]||(e[13]=l=>o(n).isUniqueIdNumber1Required=l)},null,8,["modelValue","label","error"])]),$,i("div",G,[d(a,{type:"text",modelValue:r.uniqueIdNumber2Label,"onUpdate:modelValue":e[14]||(e[14]=l=>r.uniqueIdNumber2Label=l),name:"uniqueIdNumber2Label",label:o(u)("employee.config.props.unique_id_number2_label"),error:o(n).uniqueIdNumber2Label,"onUpdate:error":e[15]||(e[15]=l=>o(n).uniqueIdNumber2Label=l)},null,8,["modelValue","label","error"])]),i("div",z,[d(t,{vertical:"",modelValue:r.isUniqueIdNumber2Required,"onUpdate:modelValue":e[16]||(e[16]=l=>r.isUniqueIdNumber2Required=l),name:"uniqueIdNumber2Required",label:o(u)("employee.config.props.unique_id_number2_required"),error:o(n).isUniqueIdNumber2Required,"onUpdate:error":e[17]||(e[17]=l=>o(n).isUniqueIdNumber2Required=l)},null,8,["modelValue","label","error"])]),J,i("div",K,[d(a,{type:"text",modelValue:r.uniqueIdNumber3Label,"onUpdate:modelValue":e[18]||(e[18]=l=>r.uniqueIdNumber3Label=l),name:"uniqueIdNumber3Label",label:o(u)("employee.config.props.unique_id_number3_label"),error:o(n).uniqueIdNumber3Label,"onUpdate:error":e[19]||(e[19]=l=>o(n).uniqueIdNumber3Label=l)},null,8,["modelValue","label","error"])]),i("div",Q,[d(t,{vertical:"",modelValue:r.isUniqueIdNumber3Required,"onUpdate:modelValue":e[20]||(e[20]=l=>r.isUniqueIdNumber3Required=l),name:"uniqueIdNumber3Required",label:o(u)("employee.config.props.unique_id_number3_required"),error:o(n).isUniqueIdNumber3Required,"onUpdate:error":e[21]||(e[21]=l=>o(n).isUniqueIdNumber3Required=l)},null,8,["modelValue","label","error"])])])]),_:1},8,["form"])]),_:1})],64)}}});export{Z as default};
