define(["jquery"],function(a){"use strict";var b={toolbarId:"dynamic-toolbar",toolbarKey:"dynamics",listId:"dynamic-list",endPointUrl:"/admin/api/form/dynamics",fieldsAction:"/admin/api/form/dynamics/fields"};return{layout:function(){return{extendExisting:!0,content:{width:"fixed",leftSpace:!0,rightSpace:!0}}},initialize:function(){this.render(),this.initPreview()},initPreview:function(){this.sandbox.emit("sulu.preview.initialize",null,!0)},getUrlParameters:function(){return{form:this.options.data()[this.options.property],webspaceKey:this.options.webspace,locale:this.options.language,view:this.options.view,typeId:this.options.id,type:this.options.type,sortBy:"created",sortOrder:"desc"}},render:function(){this.sandbox.dom.html(this.$el,'<div id="'+b.toolbarId+'"></div><div id="'+b.listId+'"></div>');var c=this.getUrlParameters(),d="?"+a.param(c);this.sandbox.sulu.initListToolbarAndList.call(this,b.toolbarKey,b.fieldsAction+d,{el:this.$find("#"+b.toolbarId),template:this.sandbox.sulu.buttons.get({settings:{options:{id:"settings",dropdownItems:{"export":{options:{title:"public.export",icon:"download",callback:function(){var d=a("<div/>");a("body").append(d);var e={el:d,urlParameter:c,url:b.endPointUrl+".csv"};App.start([{name:"csv-export@suluform",options:e}]).fail(function(){console.warn("Ignore error! For date-range specific export at least Sulu 1.5 is needed. Automatic fallback to default export."),App.start([{name:"csv-export@suluadmin",options:e}])})}.bind(this)}},columnOptions:{options:{type:"columnOptions"}}}}}}),hasSearch:!1,instanceName:this.instanceName},{el:this.$find("#"+b.listId),instanceName:this.instanceName,url:b.endPointUrl+d,resultKey:"dynamics",viewOptions:{table:{selectItem:!1,fullWidth:!0}}})}}});