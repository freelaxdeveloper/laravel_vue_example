webpackJsonp([3],{AN01:function(t,n){t.exports={render:function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-item-group",[e("v-btn",{attrs:{small:""}},[t.icon?e("v-icon",{attrs:{left:"",dark:""},domProps:{textContent:t._s(t.icon)}}):t._e(),t._v(" Кнопка\n  ")],1),t._v(" "),e("v-container",{attrs:{"grid-list-md":""}},[e("v-layout",{attrs:{wrap:""}},t._l(t.icons,function(n,r){return e("v-flex",{key:r,attrs:{xs1:""}},[e("v-item",{scopedSlots:t._u([{key:"default",fn:function(r){var o=r.active,c=r.toggle;return e("v-card",{staticClass:"d-flex align-center",attrs:{color:o?"primary":"",dark:"",height:"48"},nativeOn:{click:function(t){return c(t)}}},[e("v-scroll-y-transition",[e("v-icon",{attrs:{left:"",dark:""},domProps:{textContent:t._s(n)},on:{click:function(e){t.icon=o?"":n}}})],1)],1)}}])})],1)}),1)],1)],1)},staticRenderFns:[]}},"BqY+":function(t,n,e){var r=e("VU/8")(e("a/qT"),e("AN01"),!1,null,null,null);t.exports=r.exports},"a/qT":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=e("mtWM"),o=e.n(r);n.default={data:function(){return{icon:"",icons:[]}},methods:{fetchIcons:function(){var t=this;o.a.get("/icons").then(function(n){t.icons=n.data})}},created:function(){this.fetchIcons()}}}});