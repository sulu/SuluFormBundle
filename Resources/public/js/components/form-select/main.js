/**
 * handles form selection
 *
 * @class FormSelect
 * @constructor
 */
define([], function () {

    'use strict';

    var defaults = {
            visibleItems: 999,
            instanceName: null,
            idsParameter: 'ids',
            preselected: null,
            idKey: 'id',
            titleKey: 'title',
            resultKey: '',
            translations: {
                overlayTitle: 'form-select.title',
                noTitle: 'public.no-title'
            }
        },

        /**
         * namespace for events
         * @type {string}
         */
        eventNamespace = 'sulu.form-select.',

        /**
         * raised when the overlay data has been changed
         * @event sulu.form-select.data-changed
         */
        DATA_CHANGED = function() {
            return createEventName.call(this, 'data-changed');
        },

        /**
         * returns normalized event names
         */
        createEventName = function(postFix) {
            return eventNamespace + (this.options.instanceName ? this.options.instanceName + '.' : '') + postFix;
        },

        templates = {
            skeleton: function(options) {
                return [
                    // form-select as class to reuse the styling
                    '<div class="single-internal-link container form-element" id="', options.ids.container, '">',
                    '   <a class="fa-tasks icon action choose" href="#" id="', options.ids.button, '"></a>',
                    '   <a class="fa-times-circle clear" href="#" id="', options.ids.clearButton, '"></a>',
                    '   <input type="text" class="form-element preview-update trigger-save-button" readonly="readonly" id="', options.ids.input, '"/>',
                    '</div>'
                ].join('');
            },

            data: function(options) {
                return[
                    '<div id="', options.ids.list, '"/>'
                ].join('');
            }
        },

        /**
         * returns id for given type
         */
        getId = function(type) {
            return '#' + this.options.ids[type];
        },

        render = function () {
            // init ids
            this.options.ids = {
                container: 'form-select-' + this.options.instanceName + '-container',
                input: 'form-select-' + this.options.instanceName + '-input',
                button: 'form-select-' + this.options.instanceName + '-button',
                clearButton: 'form-select-' + this.options.instanceName + '-clear-button',
                list: 'single-internal-link-' + this.options.instanceName + '-list'
            };
            this.sandbox.dom.html(this.$el, templates.skeleton(this.options));

            // init container
            this.$container = this.sandbox.dom.find(getId.call(this, 'container'), this.$el);
            this.$input = this.sandbox.dom.find(getId.call(this, 'input'), this.$el);
            this.$button = this.sandbox.dom.find(getId.call(this, 'button'), this.$el);

            // set preselected values
            if (!!this.sandbox.dom.data(this.$el, 'form-select')) {
                var data = this.sandbox.dom.data(this.$el, 'form-select');
                setData.call(this, data);
            } else {
                setData.call(this, this.options.preselected);
            }

            // sandbox event handling
            bindCustomEvents.call(this);

            // start overlay
            initOverlay.call(this);

            bindDomEvents.call(this);
        },

        setData = function(data) {
            this.data = data;
            this.sandbox.dom.data(this.$el, 'form-select', this.data);

            if (!!data) {
                $('#' + this.options.ids.clearButton).show();
            } else {
                $('#' + this.options.ids.clearButton).hide();
            }
        },

        bindCustomEvents = function() {
            // TODO: Bind events
        },

        bindDomEvents = function() {
            this.sandbox.dom.on('#' + this.options.ids.clearButton, 'click', function() {
                setData.call(this, '');
                this.$input.val('');

                return false;
            }.bind(this));
        },

        initOverlay = function() {
            var $element = this.sandbox.dom.createElement('<div/>');

            this.sandbox.dom.append(this.$el, $element);
            this.sandbox.start([
                {
                    name: 'overlay@husky',
                    options: {
                        triggerEl: this.$el,
                        cssClass: 'form-select-overlay',
                        el: $element,
                        container: this.$el,
                        removeOnClose: false,
                        instanceName: 'form-select.' + this.options.instanceName,
                        slides: [
                            {
                                title: this.sandbox.translate(this.options.translations.overlayTitle),
                                data: templates.data(this.options),
                                buttons: [
                                    {
                                        type: 'cancel'
                                    }
                                ]
                            }
                        ]
                    }
                }
            ]);
        };

    return {
        initialize: function () {
            // extend default options
            this.options = this.sandbox.util.extend({}, defaults, this.options);

            render.call(this);
        }
    };
});
