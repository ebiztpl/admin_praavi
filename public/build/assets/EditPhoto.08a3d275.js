import{u as k,A as B,q as E,s as _,t as $,I as j,r as o,o as n,a as C,k as c,b as m,d as p,f as i,l as d,F as P,e as u}from"./app.537b83f5.js";const F={class:"grid grid-cols-1"},O={class:"col-span-1"},I={name:"EmployeeEditPhoto"},H=Object.assign(I,{props:{employee:{type:Object,default(){return{}}}},setup(e){const y=e,s=k(),l=B("emitter"),a={photo:""};E("employee/");const r=_({...a}),h=async()=>{l.emit("employeeUpdated")},b=async()=>{l.emit("employeeUpdated")};return $(async()=>{Object.assign(a,{photo:y.employee.contact.photo}),Object.assign(r,j(a))}),(t,V)=>{const g=o("PageHeader"),v=o("ImageUpload"),f=o("BaseCard"),U=o("ParentTransition");return n(),C(P,null,[e.employee.uuid?(n(),c(g,{key:0,title:t.$trans(m(s).meta.trans,{attribute:t.$trans(m(s).meta.label)}),navs:[{label:t.$trans("employee.employee"),path:"Employee"},{label:e.employee.contact.name,path:{name:"EmployeeShow",params:{uuid:e.employee.uuid}}}]},null,8,["title","navs"])):p("",!0),i(U,{appear:"",visibility:!0},{default:d(()=>[e.employee.uuid?(n(),c(f,{key:0},{default:d(()=>[u("div",F,[u("div",O,[i(v,{label:t.$trans("contact.props.photo"),src:r.photo,"upload-path":`employees/${e.employee.uuid}/photo`,"remove-path":`employees/${e.employee.uuid}/photo`,onUploaded:h,onRemoved:b},null,8,["label","src","upload-path","remove-path"])])])]),_:1})):p("",!0)]),_:1})],64)}}});export{H as default};