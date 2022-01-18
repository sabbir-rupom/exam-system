import toastr from 'toastr';

$(function ()
{
    // Skote default example || we wont touch it
    if ($("textarea.full-rich-text").length > 0) {
        tinymce.init({
            selector: "textarea.full-rich-text",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                { title: 'Bold text', inline: 'b' },
                { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
                { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
                { title: 'Example 1', inline: 'span', classes: 'example1' },
                { title: 'Example 2', inline: 'span', classes: 'example2' },
                { title: 'Table styles' },
                { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
            ]
        });
    }

    $('.note-toolbar  [data-toggle=dropdown]').attr("data-bs-toggle", "dropdown");

    // --------------
    // Custom
    // --------------
    const templateInput = $('textarea.rich-text');
    if (templateInput.length > 0) {
        tinymce.init({
            selector: "textarea.rich-text",
            height: 300,
            menubar: '',
            branding: false,
            plugins: [
                "advlist autolink link image lists preview hr anchor ",
                "code wordcount fullscreen ",
                "table paste"
            ],
            toolbar: "undo redo | styleselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview code",
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

    if ($('textarea.basic-rich-text').length > 0) {
        tinymce.init({
            selector: "textarea.basic-rich-text",
            height: 300,
            menubar: '',
            plugins: [
                "autolink link preview hr anchor wordcount lists",
                "paste"
            ],
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link | fullpage | forecolor backcolor emoticons",
        });
    }

});
