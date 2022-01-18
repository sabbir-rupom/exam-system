$(function ()
{

    'use strict';

    var qVal = 0, questionType = $('input[name="question_type"]'),
        url = '/ajax/component/get',
        target = '';

    if (questionType.length > 0) {
        qVal = $('input[name="question_type"]:checked').val();

        questionType.on('change', function ()
        {
            if ($(this).val() !== qVal) {
                qVal = $(this).val();
                target = questionType.data('target');

                const response = fetchCall(url, {
                    name: 'question',
                    type: 'option',
                    value: qVal
                }, 'POST');

                if (response instanceof Error) {
                    toastr.error('Ajax error', 'Error!')
                } else {
                    response.then(json =>
                    {
                        if (json.success && json.data.html) {
                            if (target && $(target).length > 0) {
                                $(target).html(json.data.content);
                            } else {
                                toastr.error('Target dom not found', 'Error!')
                            }
                        } else {
                            toastr.error(json.message, 'Error!')
                        }

                    });
                }

                let fieldLabel = $(this).data('label-target');

                if (fieldLabel) {
                    $(fieldLabel).html($(this).data('label-text'))
                }
            }
        });
    }

    /**
     * Clone a specific html form block and
     * append to target block based on available commands
     */
    let cloneCounter = 1;
    $(document).on('click', 'button.btn.btn-add-more', function ()
    {
        let targetElem = $($(this).data('target'));
        let block = targetElem.first().clone();
        targetElem.parent('div').append(block);

        if ($('button.btn.btn-remove-more').is(':hidden')) {
            $('button.btn.btn-remove-more').fadeIn();
        }

        var newBlock = $($(this).data('target') + ':last');
        newBlock.find('select,textarea,input[type="text"],input[type="number"]').removeAttr('required').val('');
        newBlock.find('input[type="checkbox"],input[type="radio"]').prop('checked', false);
        if (newBlock.attr('data-index')) {
            cloneCounter = parseInt(newBlock.attr('data-index')) + targetElem.length;
            newBlock.attr('data-index', cloneCounter);
        } else {
            cloneCounter = targetElem.length + 1;
        }
        newBlock.find('span.counter').text(cloneCounter);
    });

    /**
     * Remove a html element block based on available command
     */
    $(document).on('click', 'button.btn.btn-remove-more', function ()
    {
        let targetElem = $($(this).data('target'));
        let targetLength = targetElem.length,
            min = $(this).attr('data-min') ? parseInt($(this).data('min')) : 1;

        if (targetLength > min) {
            targetElem.last().remove();
        }
        if (targetLength - 1 <= min) {
            $('button.btn.btn-remove-more').fadeOut();
        }
    });

    /**
     * Handle cloned input-checkbox array index problem for multiple choice question
     */
    $(document).on('change', '.checkbox-array', function ()
    {

        if($(this).attr('type') === 'radio') {
            if ($(this).is(':checked')) {
                $('input.checkbox-array').prop('checked', false);
                $('input.checkbox-array').siblings('input[type=hidden]').val('');

                $(this).prop('checked', true);
                $(this).siblings('input[type=hidden]').val(1);
            }
        } else {
            if ($(this).is(':checked')) {
                $(this).siblings('input[type=hidden]').val(1);
            } else {
                $(this).siblings('input[type=hidden]').val('');
            }
        }
    });

    const templateInput = 'textarea.q-rich-text';
    if ($(templateInput).length > 0) {
        tinymce.init({
            selector: templateInput,
            height: 300,
            menubar: '',
            branding: false,
            plugins: [
                "advlist autolink link image lists preview hr anchor ",
                "code wordcount fullscreen ",
                "table paste"
            ],
            toolbar: "undo redo | styleselect | bold italic | forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview code",
            image_title: true,
            paste_data_images: true,
            paste_image_maxsize: 5,
            paste_postprocess: function (plugin, args)
            {
                let node = args.node.childNodes[0];
                let success = true;
                if (node.nodeName.toLowerCase() === 'img' && typeof node === "object") {
                    const img = new Image();
                    img.onload = function ()
                    {
                        if (this.width > 4000 || this.height > 4000) {
                            toastr['error']('Please reduce the image under 4000x4000', 'Too large image!');

                            success = false;
                        }
                    }
                    img.src = node.getAttribute('src');
                }


                return false;
            },

            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta)
            {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                /*
                    Note: In modern browsers input[type="file"] is functional without
                    even adding it to the DOM, but that might not be the case in some older
                    or quirky browsers like IE, so you might want to add it to the DOM
                    just in case, and visually hide it. And do not forget do remove it
                    once you do not need it anymore.
                */

                input.onchange = function ()
                {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function ()
                    {
                        /*
                            Note: Now we need to register the blob in TinyMCEs image blob
                            registry. In the next release this part hopefully won't be
                            necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
        });
    }

});
