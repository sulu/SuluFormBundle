define(["jquery","underscore"],function(a,b){"use strict";var c={activeTab:"general",data:{},instanceName:"form",newTitle:"sulu_form.forms.new_form"},d={general:{name:"general",url:"/admin/api/form/templates/form.html",formSelector:"#form-form"}},e="sulu_form.forms.",f="sulu.form.forms.";return{view:!0,layout:{content:{width:"max",topSpace:!0,leftSpace:!1,rightSpace:!1}},initialize:function(){this.options=this.sandbox.util.extend(!0,{},c,this.options),this.saved=!0,this.bindCustomEvents(),this.render()},bindCustomEvents:function(){this.sandbox.on("sulu.toolbar.save",this.save.bind(this)),this.sandbox.on("sulu.toolbar.delete",this["delete"].bind(this))},render:function(){this.setHeaderInfos(),this.renderForm(d[this.options.activeTab].url)},renderForm:function(c){a.ajax({url:c+"?locale="+this.options.language,method:"GET",dataType:"html",async:!1,success:function(a){var c=this.getActiveFormSelector();this.sandbox.dom.html(this.$el,b.template(a,{translate:this.sandbox.translate,options:this.options})),this.sandbox.form.create(c),this.sandbox.form.setData(c,this.options.data).then(function(){this.sandbox.start(c),this.bindFormEvents(),this.sandbox.dom.find("input[autofocus]").first().focus()}.bind(this))}.bind(this)})},bindFormEvents:function(){var a=this.getActiveFormSelector();this.sandbox.dom.on(a,"keyup",this.activateSaveButton.bind(this),"input, textarea"),this.sandbox.dom.on(a,"change",this.activateSaveButton.bind(this),'input[type="checkbox"], select'),this.sandbox.on("husky.select.width.selected.item",this.activateSaveButton.bind(this)),this.sandbox.on("husky.ckeditor.changed",this.activateSaveButton.bind(this)),this.sandbox.on("sulu.content.changed",this.activateSaveButton.bind(this)),this.sandbox.on("husky.overlay.alert.closed",this.activateSaveButton.bind(this)),this.initSortableBlock(),this.sandbox.dom.on(a,"form-add",function(a,b,c,d){var e=this.sandbox.dom.children(this.$find('[data-mapper-property="'+b+'"]')),f=void 0!==d&&e.length>d?e[d]:this.sandbox.dom.last(e);this.sandbox.start(f),this.initSortableBlock(),this.activateSaveButton()}.bind(this)),this.sandbox.dom.on(a,"form-remove",function(){this.activateSaveButton()}.bind(this)),this.sandbox.dom.on(a,"init-sortable",function(a){this.initSortableBlock(),this.sandbox.emit("sulu.content.changed")}.bind(this))},initSortableBlock:function(){var a,b=this.sandbox.dom.find(".sortable",this.$el);b&&b.length>0&&(this.sandbox.dom.sortable(b,"destroy"),a=this.sandbox.dom.sortable(b,{handle:".move",forcePlaceholderSize:!0}),this.sandbox.dom.unbind(a,"sortupdate"),a.bind("sortupdate",function(a){this.sandbox.emit("sulu.content.changed")}.bind(this)))},getActiveFormSelector:function(){return d[this.options.activeTab].formSelector},activateSaveButton:function(){this.saved===!0&&(this.sandbox.emit("sulu.header.toolbar.item.enable","save",!1),this.saved=!1)},setHeaderInfos:function(){this.options.data.id||this.sandbox.emit("sulu.header.toolbar.item.disable","settings",!1)},"delete":function(){this.options.data.id&&this.sandbox.emit(f+"delete",[this.options.data.id],null,function(){this.sandbox.sulu.unlockDeleteSuccessLabel(),this.sandbox.emit(f+"navigate-list")}.bind(this))},save:function(){var a=this.getActiveFormSelector();if(this.sandbox.form.validate(a)){var b=this.sandbox.form.getData(a);b.id=this.options.data.id,b.locale=this.options.data.locale,this.options.data=b,this.sandbox.emit("sulu.header.toolbar.item.loading","save"),this.sandbox.emit(f+"save",this.options.data,this.savedCallback.bind(this,!this.options.data.id))}},savedCallback:function(a,b,c){c===!0?(this.setHeaderInfos(),this.sandbox.emit("sulu.header.toolbar.item.disable","save",!0),this.saved=!0,a===!0?this.sandbox.emit(f+"navigate-to",b.id):this.sandbox.emit(f+"navigate-to",b.id),this.sandbox.emit("sulu.labels.success.show",e+"save.success","labels.success")):(this.sandbox.emit("sulu.header.toolbar.item.enable","save",!1),1===b.code?this.sandbox.emit("sulu.labels.error.show",e+"save.error-unique","labels.error"):this.sandbox.emit("sulu.labels.error.show",e+"save.error","labels.error"))}}});