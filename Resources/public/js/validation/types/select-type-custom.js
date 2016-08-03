define([
    'type/default',
    'form/util'
], function(Default) {

    'use strict';

    return function($el, options) {
        var defaults = {
                id: 'id',
                label: 'value',
                required: false
            },

            typeInterface = {
                setValue: function(data) {

                    if (data === undefined || data === '' || data === null) {
                        return;
                    }

                    if (typeof data === 'object') {
                        this.$el.data({
                            'selection': data[this.options.id],
                            'selectionValues': data[this.options.label]
                        }).trigger('data-changed');
                    } else {
                        this.$el.data({
                            'selection': data
                        }).trigger('data-changed');
                    }
                },

                getValue: function() {
                    // For single select
                    var data = {},
                        ids = this.$el.data('selection'),
                        values = this.$el.data('selection-values'),
                        returnValue = this.$el.attr('data-mapper-return-value');

                    if (!ids || ids.length === 0) {
                        return '';
                    }

                    // check if 'data-mapper-return-value' is defined
                    if (typeof returnValue !== 'undefined') {
                        if (returnValue === 'id') {
                            return Array.isArray(ids) ? ids[0] : ids;
                        } else if(returnValue === 'value'){
                            return Array.isArray(values) ? values[0] : values;
                        }
                    }
                    // return value if property type is set to string
                    if (this.$el.attr('data-mapper-property-type') === 'string') {
                        return Array.isArray(values) ? values[0] : values;
                    }

                    data[this.options.label] = Array.isArray(values) ? values[0] : values;
                    data[this.options.id] = Array.isArray(ids) ? ids[0] : ids;

                    return data;
                },

                needsValidation: function() {
                    var val = this.getValue();
                    return !!val;
                },

                validate: function() {
                    var value = this.getValue();
                    if (typeof value === 'object' && value.hasOwnProperty('id')) {
                        return !!value.id;
                    } else {
                        return value !== '' && typeof value !== 'undefined';
                    }
                }
            };

        return new Default($el, defaults, options, 'select-custom', typeInterface);
    };
});
