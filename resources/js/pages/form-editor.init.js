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
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor ",
                "code wordcount fullscreen media ",
                "table paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview media fullpage | code",
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
            }
        });
    }

    if($('textarea.basic-rich-text').length > 0) {
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
