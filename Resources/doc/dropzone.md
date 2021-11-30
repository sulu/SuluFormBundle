# Dropzone

## 1. The Form Theme

To use a dropzone in forms you need edit your form theme

```twig
{%- block form_start -%}
    {# Form need an id to access the element over js #}
    {% set attr = attr|merge({ id: 'dynamic-form' }) %}

    {{ parent() }}
{%- endblock form_start -%}

{%- block file_widget -%}
    {# Dropzone #}
    <div id="dropzone-{{ form.vars.id }}"
         data-name="{{ form.vars.full_name }}"
         data-accept="{{ form.vars.attr.accept|default() }}"
         data-max="{{ form.vars.attr.max|default(10) }}"
         class="upload-files">
        <div class="dz-message">
            <button type="button" class="upload-button">Choose</button>
        </div>
    </div>
{%- endblock -%}
```

## 2. Form submit handling with multiple dropzones

The following JS will show you how you can submit a form
over multiple dropzones:

```js
var $ = require('jquery');
var Dropzone = require('dropzone');

var component = function() {
    return {
        $el: null,
        dropzones: [],

        /**
         * Initialize component.
         */
        initialize: function($el) {
            this.$el = $el;
            this.initializeDropzones();
            this.$el.submit(this.submit.bind(this));

            return true;
        },

        /**
         * Handles the submit event of form.
         *
         * @param {Object} event
         *
         * @returns {Boolean}
         */
        submit: function(event) {
            if (!this.hasFiles()) {
                // Default form submit.
                return true;
            }

            // Submit over dropzone.
            event.preventDefault();

            // Do submit for first dropzone with files.
            this.submitDropzones();

            // Avoid default behaviour.
            return false;
        },

        /**
         * Upload dropzone files and submit the form afterwards.
         */
        submitDropzones: function() {
            for (var i = 0, length = this.dropzones.length; i < length; i++) {
                if (this.dropzones[i].getQueuedFiles().length) {
                    this.dropzones[i].processQueue();
                    break;
                }
            }
        },

        /**
         * Initializes all dropzones in this form.
         */
        initializeDropzones: function() {
            var dropzones = [];

            Dropzone.autoDiscover = false;

            // Create dropzones.
            this.$el.find('.upload-files').each(function(index, el) {
                var $dropzone = $(el);

                // Need to slice [] because its added by dropzone.
                var paramName = $dropzone.data('name');
                paramName = paramName.substr(0, paramName.length - 2);

                // Add new dropzone.
                dropzones.push(
                    this.createDropzone(
                        $dropzone.attr('id'),
                        paramName,
                        $dropzone.data('max'),
                        $dropzone.data('accept')
                    )
                );
            }.bind(this));

            this.dropzones = dropzones;
        },

        /**
         * Destroys each dropzone in the form.
         */
        destroyDropzones: function() {
            for (var i = 0, length = this.dropzones.length; i < length; i++) {
                this.dropzones[i].destroy();
            }
        },

        /**
         *  Returns a boolean if there is at least one dropzone in the form that has files.
         *
         * @returns {Boolean}
         */
        hasFiles: function() {
            // Has dropzones.
            if (!this.dropzones.length) {
                return false;
            }

            // Has files in dropzone.
            for (var i = 0, length = this.dropzones.length; i < length; i++) {
                if (this.dropzones[i].getQueuedFiles().length) {
                    return true;
                }
            }
        },

        /**
         * Creates a dropzone with the given params.
         *
         * @param {String} id
         * @param {String} paramName
         * @param {Number} maxFiles
         * @param {Boolean} accept
         *
         * @return {Dropzone}
         */
        createDropzone: function(id, paramName, maxFiles, accept) {
            var self = this;

            // Get form action url.
            var url = this.$el.attr('action');
            if (!url) {
                url = window.location.href;
            }

            // Create new dropzone.
            return new Dropzone('#' + id, {
                paramName: paramName,
                url: url,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: maxFiles,
                maxFiles: maxFiles,
                maxFilesize: 1, // Max. 1 MB.
                acceptedFiles: accept,
                clickable: ['#' + id],
                previewTemplate: [
                    '<div class="dz-preview dz-file-preview">',
                    '    <img data-dz-thumbnail />',
                    '    <span class="dz-name" data-dz-name></span>',
                    '    <span class="dz-upload"><span data-dz-uploadprogress></span></span>',
                    '    <span class="dz-remove" data-dz-remove></span>',
                    '    <div class="dz-error-message"><span data-dz-errormessage></span></div>',
                    '</div>'
                ].join(''),
                init: function() {
                    this.on('sendingmultiple', self.sendingDropzone.bind(self));
                    this.on('successmultiple', self.successDropzone.bind(self));
                    this.on('errormultiple', self.errorDropzone.bind(self));
                }
            })
        },

        /**
         * Create dropzone with the given params.
         *
         * @param {Object} data
         * @param {Object} xhr
         * @param {Object} formData
         */
        sendingDropzone: function(data, xhr, formData) {
            // Disable all submit buttons in form.
            this.$el.find('[type=submit]').prop('disabled', true);

            // Add fields to form data.
            $.each(this.$el.serializeArray(), function(index, item) {
                formData.append(item.name, item.value);
            });

            // Add other dropzone files.
            for (var i = 0, length = this.dropzones.length; i < length; i++) {
                var files = this.dropzones[i].getQueuedFiles();

                // Append files only if it's not the same dropzone.
                if (files.length && files[0].name !== data[0].name) {
                    for (var x = 0, fileLength = files.length; x < fileLength; x++) {
                        formData.append(
                            this.dropzones[i]._getParamName(x),
                            files[x],
                            files[x].name
                        );
                    }
                }
            }
        },

        /**
         * Called after all dropzones have been sent successfully.
         *
         * @param {Object} file
         * @param {Object} response
         */
        successDropzone: function(file, response) {
            var $newForm = $(response).find('#' + this.id);

            // On success no form is displayed we can redirect to.
            if (!$newForm.length) {
                window.location.href = '?send=true';

                return;
            }

            // Destroy dropzones on form error to keep files.
            this.destroyDropzones();

            // Replace form with.
            this.$el.html($newForm.html());

            // Reinitialize dropzones.
            this.initializeDropzones();

            // Scroll to first error here.
            // Initialize other js libraries.
        },

        /**
         * Called when a dropzone has an error.
         */
        errorDropzone: function() {
            // Enable submit buttons.
            this.$el.find('[type=submit]').prop('disabled', false);
        }
    };
}();

// Initialize Form.
component.initialize($('#dynamic-form'));
```

## jQuery Validation

Replace the following line

```js
this.$el.submit(this.submit.bind(this));
```

with:

```js
this.$el.validate({
    submitHandler: this.submit.bind(this);
});
```

change the submit function to the following:

```js
/**
 * Handles the submit event of form.
 *
 * @param {Object} form
 *
 * @returns {Boolean}
 */
submit: function(form) {
    if (!this.hasFiles()) {
        // Submit form normally.
        form.submit();
        return;
    }

    // Do submit for first dropzone with files.
    this.submitDropzones();
},
```
