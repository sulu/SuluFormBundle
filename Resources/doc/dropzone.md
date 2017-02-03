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
    <div id="dropzone-{{ form.vars.name }}"
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
        $el: $('#dynamic-form'),
        dropzones: [],

        /**
         * @method initialize
         */
        initialize: function() {
            this.initializeDropzones();
            this.$el.submit(this.submit.bind(this));

            return true;
        },

        /**
         * @method submit
         */
        submit: function(event) {
            if (!this.hasFiles()) {
                // default form submit
                return true;
            }

            // submit over dropzone
            event.preventDefault();

            // do submit for first dropzone with files
            this.submitViaDropzone().bind(this);

            // avoid default behaviour
            return false;
        },

        /**
         * @method submitDropzones
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
         * @method initializeDropzone
         */
        initializeDropzones: function() {
            var dropzones = [];

            Dropzone.autoDiscover = false;

            // create dropzones
            this.$el.find('.upload-files').each(function(index, el) {
                var $dropzone = $(el);

                // need to slice [] because its added by dropzone
                var paramName = $dropzone.data('name');
                paramName = paramName.substr(0, paramName.length - 2);

                // add new dropzone
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
         * @method destroyDropzones
         */
        destroyDropzones: function() {
            for (var i = 0, length = this.dropzones.length; i < length; i++) {
                this.dropzones[i].destroy();
            }
        },

        /**
         * @method hasFiles
         */
        hasFiles: function() {
            // has dropzones
            if (!this.dropzones.length) {
                return false;
            }

            // has files in dropzone
            for (var i = 0, length = this.dropzones.length; i < length; i++) {
                if (this.dropzones[i].getQueuedFiles().length) {
                    return true;
                }
            }
        },

        /**
         * @method createDropzone
         */
        createDropzone: function(id, paramName, maxFiles, accept) {
            var self = this;

            // get form action url
            var url = this.$el.attr('action');
            if (!url) {
                url = window.location.href;
            }

            // create new dropzone
            return new Dropzone('#' + id, {
                paramName: paramName,
                url: url,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: maxFiles,
                maxFiles: maxFiles,
                maxFilesize: 1, // max 1 MB
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
         * @method createDropzone
         */
        sendingDropzone: function(data, xhr, formData) {
            // disable all submit buttons in form
            this.$el.find('[type=submit]').prop('disabled', true);

            // add fields to form data
            $.each(this.$el.serializeArray(), function(index, item) {
                formData.append(item.name, item.value);
            });

            // add other dropzone files
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
         * @method successDropzone
         */
        successDropzone: function(file, response) {
            var $newForm = $(response).find('#' + this.id);

            // on success no form is displayed we can redirect to
            if (!$newForm.length) {
                window.location.href = '?send=true';

                return;
            }

            // on error destroy dropzones
            this.destroyDropzones();

            // replace form with
            this.$el.html($newForm.html());

            // reinitilize dropzones
            this.initializeDropzones();

            // scroll to first error here
            // initialize other js libraries
        },

        /**
         * @method errorDropzone
         */
        errorDropzone: function() {
            // enable submit buttons
            this.$el.find('[type=submit]').prop('disabled', false);
        }
    };
}();

component.initialize();
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
 * @method submit
 */
submit: function(form) {
    if (!this.hasFiles()) {
        // submit form normally
        form.submit();
        return;
    }

    // do submit for first dropzone with files
    this.submitViaDropzone().bind(this);
},
```
