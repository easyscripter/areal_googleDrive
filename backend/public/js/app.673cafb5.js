(function(e){function t(t){for(var o,i,l=t[0],s=t[1],c=t[2],u=0,p=[];u<l.length;u++)i=l[u],Object.prototype.hasOwnProperty.call(a,i)&&a[i]&&p.push(a[i][0]),a[i]=0;for(o in s)Object.prototype.hasOwnProperty.call(s,o)&&(e[o]=s[o]);d&&d(t);while(p.length)p.shift()();return n.push.apply(n,c||[]),r()}function r(){for(var e,t=0;t<n.length;t++){for(var r=n[t],o=!0,l=1;l<r.length;l++){var s=r[l];0!==a[s]&&(o=!1)}o&&(n.splice(t--,1),e=i(i.s=r[0]))}return e}var o={},a={app:0},n=[];function i(t){if(o[t])return o[t].exports;var r=o[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,i),r.l=!0,r.exports}i.m=e,i.c=o,i.d=function(e,t,r){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},i.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)i.d(r,o,function(t){return e[t]}.bind(null,o));return r},i.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="/";var l=window["webpackJsonp"]=window["webpackJsonp"]||[],s=l.push.bind(l);l.push=t,l=l.slice();for(var c=0;c<l.length;c++)t(l[c]);var d=s;n.push([0,"chunk-vendors"]),r()})({0:function(e,t,r){e.exports=r("56d7")},"3dd8":function(e,t,r){"use strict";r("87ed")},"56d7":function(e,t,r){"use strict";r.r(t);r("e260"),r("e6cf"),r("cca6"),r("a79d");var o=r("2b0e"),a=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{attrs:{id:"app"}},[r("CSidebar",{attrs:{colorScheme:"Dark"}},[r("CSidebarNav",[r("CSidebarNavTitle",[r("a",{staticClass:"nav-title",attrs:{href:"/"}},[e._v("Areal Google Drive")])]),r("CSidebarNavDropdown",{attrs:{icon:"cil-storage",name:"Диски"}},[r("CSidebarNavItem",{attrs:{to:"/my-drive/folder/root",name:"Мой диск"}}),r("CSidebarNavItem",{attrs:{to:"/common-drives",name:"Общие диски"}})],1),r("CSidebarNavItem",{attrs:{to:"/export",icon:"cil-cloud-download",name:"Экспорт"}}),r("CSidebarNavItem",{attrs:{icon:"cil-code",name:"Логи"}}),r("CButton",{attrs:{color:"primary"},on:{click:function(t){return e.auth()}}},[e._v("Войти в Google")])],1)],1),r("CWrapper",[r("router-view",{key:e.$route.fullPath})],1)],1)},n=[],i=r("1da1"),l=(r("96cf"),r("b0c0"),{data:function(){return{user_data:{}}},mounted:function(){var e=this;this.$http.get("https://areal-gdrive.com/api/v1/user").then((function(t){return e.user_data={name:t.data.name,email:t.data.email,avatar:t.data.avatar}}))},methods:{auth:function(){var e=this;return Object(i["a"])(regeneratorRuntime.mark((function t(){var r,o;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,e.$gAuth.getAuthCode();case 2:return r=t.sent,t.next=5,e.$http.post("https://areal-gdrive.com/api/v1/google-login",{code:r,redirect_uri:"postmessage"});case 5:o=t.sent,console.log(o);case 7:case"end":return t.stop()}}),t)})))()}}}),s=l,c=(r("5c0b"),r("2877")),d=Object(c["a"])(s,a,n,!1,null,null,null),u=d.exports,p=r("8c4f"),f=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{attrs:{id:"main-page"}},[r("CWrapper",{staticClass:"main-section"},[r("CHeader"),r("router-view")],1)],1)},m=[],v={components:{}},h=v,C=(r("3dd8"),Object(c["a"])(h,f,m,!1,null,null,null)),g=C.exports,b=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("CWrapper",{staticClass:"folder-explorer__section"},[r("CCard",{attrs:{bodyWrapper:""}},[r("CCardBody",[r("CDataTable",{attrs:{items:e.files,fields:e.fields},scopedSlots:e._u([{key:"Name",fn:function(t){var o=t.item;return[r("td",[r("img",{attrs:{src:o.icon,alt:"Иконка"}}),r("div",{staticClass:"file-name"},[!0!==o.type.includes("application/vnd.google-apps")?r("a",{staticClass:"file-name__link",attrs:{href:o.webContentLink,download:""}},[e._v(e._s(o.name))]):"application/vnd.google-apps.folder"!==o.type?r("a",{staticClass:"file-name__link",attrs:{target:"_blank",href:o.webviewLink}},[e._v(e._s(o.name))]):r("p",{staticClass:"file-name__folder",on:{click:function(t){return e.goIntoFolder(o.id)}}},[e._v(e._s(o.name))])])])]}},{key:"ModifiedTime",fn:function(t){var o=t.item;return[r("td",[e._v(" "+e._s(o.modifiedTime.toString())+" ")])]}},{key:"Size",fn:function(t){var o=t.item;return[r("td",[e._v(" "+e._s((o.size/1058816).toFixed(2)||"-")+" MB ")])]}}])}),r("CButton",{staticClass:"m-2",attrs:{color:"primary"},on:{click:e.goPrevFolder}},[r("CIcon",{attrs:{name:"cil-arrow-left"}})],1)],1)],1)],1)],1)},_=[],y={props:{folderId:{type:String,default:"root"}},data:function(){return{files:[],fields:[{key:"Name",label:"Название"},{key:"ModifiedTime",label:"Последние изменения"},{key:"Size",label:"Размер файла"}]}},mounted:function(){var e=this;this.$http.get("https://areal-gdrive.com/api/v1/files/".concat(this.folderId)).then((function(t){e.files=t.data.data}))},methods:{goIntoFolder:function(e){this.$router.push({name:"folder",params:{folderId:e}})},goPrevFolder:function(){this.$router.go(-1)}}},k=y,x=(r("8faf"),Object(c["a"])(k,b,_,!1,null,null,null)),w=x.exports,D=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{attrs:{id:"common-disks__page"}},[r("CWrapper",{staticClass:"folder-section"},[r("CCard",{attrs:{bodyWrapper:""}},[r("CCardBody",[r("CBreadcrumbRouter"),r("CDataTable",{attrs:{items:e.disks,fields:e.fields},scopedSlots:e._u([{key:"DiskName",fn:function(t){var o=t.item;return[r("td",[r("div",{staticClass:"drive",on:{click:function(t){return e.goToDisk(o.id)}}},[r("CIcon",{attrs:{size:"lg",name:"cil-storage"}}),r("p",{staticClass:"drive__name"},[e._v(" "+e._s(o.name)+" ")])],1)])]}}])})],1)],1)],1)],1)},O=[],S={data:function(){return{disks:[],fields:[{key:"DiskName",label:"Имя Диска"}]}},mounted:function(){var e=this;this.$http.get("https://areal-gdrive.com/api/v1/sharedDrives").then((function(t){e.disks=t.data}))},methods:{goToDisk:function(e){this.$router.push({name:"commonFolder",params:{folderId:e}})}}},T=S,N=(r("a3cd"),Object(c["a"])(T,D,O,!1,null,null,null)),j=N.exports,I=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{attrs:{id:"main-page"}},[r("CCard",{attrs:{bodyWrapper:""}},[r("CRow",[r("CCol",{attrs:{md:"6"}},[r("CCard",[r("CCardHeader",[e._v(" Экспорт документов Google Drive ")]),r("CCardBody",[r("CInput",{attrs:{label:"Имя папки:",placeholder:"Укажите папку, в которую будет происходить экспорт"},model:{value:e.folderNameToExportDrive,callback:function(t){e.folderNameToExportDrive=t},expression:"folderNameToExportDrive"}}),r("CButton",{staticClass:"m-2",attrs:{color:"info",size:e.md},on:{click:e.exportToGoogleDrive}},[e._v(" Экспортировать ")])],1),r("CCardFooter",[r("p",{staticClass:"result"},[e._v(e._s(e.resultOfExportDrive))])])],1)],1),r("CCol",{attrs:{md:"6"}},[r("CCard",[r("CCardHeader",[e._v(" Скачать на локальный диск ")]),r("CCardBody",[r("CInput",{attrs:{label:"Имя папки:",placeholder:"Укажите папку, в которую будет происходить скачивание"},model:{value:e.folderNameToDownload,callback:function(t){e.folderNameToDownload=t},expression:"folderNameToDownload"}}),r("CButton",{staticClass:"m-2",attrs:{color:"info",size:e.md}},[e._v(" Скачать файлы ")])],1)],1)],1)],1)],1)],1)},$=[],E={name:"ExportPage",data:function(){return{folderNameToExportDrive:"",folderNameToDownload:"",resultOfExportDrive:"",resultOfDownload:""}},methods:{exportToGoogleDrive:function(){var e=this;this.$http.get("https://areal-gdrive.com/api/v1/export/".concat(this.folderNameToExportDrive)).then((function(t){return e.resultOfExportDrive=t.data})).catch((function(t){e.resultOfExportDrive="Файлы были экспортированы неудачно!",console.log(t)}))}}},P=E,B=Object(c["a"])(P,I,$,!1,null,"4773b6ea",null),F=B.exports;o["a"].use(p["a"]);var M=[{path:"/my-drive",component:g,children:[{path:"folder/:folderId",name:"folder",component:w,props:!0}]},{path:"/common-drives",component:j},{path:"/common-drives/folder/:folderId",component:w,name:"commonFolder",props:!0},{path:"/export",component:F,name:"ExportPage"}],W=new p["a"]({mode:"history",base:"/",routes:M}),z=W,G=r("cf2b"),A=r.n(G),H=r("bc3a"),R=r.n(H),L=r("2f12"),q=r("42d4"),J=r("6ee8"),U=r("40db"),K=r("e283"),Q=r("705e"),V=r("99bf"),X=r("8ae9"),Y=r("ed18"),Z=r.n(Y),ee=r("c9bf"),te={clientId:"744887238689-i3p531fodl1jjeknp61h738pq9juqbpk.apps.googleusercontent.com",scope:"profile email",prompt:"select_account"};o["a"].use(ee["a"],te),o["a"].prototype.$http=R.a,o["a"].config.productionTip=!1,o["a"].use(A.a),Z.a.config(),new o["a"]({router:z,icons:{cilCode:L["a"],cilHome:q["a"],cibGoogle:J["a"],cilSettings:U["a"],cilStorage:K["a"],cilArrowLeft:Q["a"],cilUser:V["a"],cilCloudDownload:X["a"]},render:function(e){return e(u)}}).$mount("#app")},"5c0b":function(e,t,r){"use strict";r("9c0c")},"682d":function(e,t,r){},8199:function(e,t,r){},"87ed":function(e,t,r){},"8faf":function(e,t,r){"use strict";r("8199")},"9c0c":function(e,t,r){},a3cd:function(e,t,r){"use strict";r("682d")}});
//# sourceMappingURL=app.673cafb5.js.map