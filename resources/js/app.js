$(function ()
{

    'use strict';

    /**
     * Normalize statements
     */
     $.fn.hasAttr = function(name) {
        return this.attr(name) !== undefined;
     };

    /**
     * Sweet confirm then delete an item with ajax call
     */
    $('.delete-confirm').on('click', function (e)
    {
        e.preventDefault();
        var title = $(this).data('title'),
            text = $(this).data('text'),
            confirmText = $(this).data('confirm_text'),
            parent = $(this).data('parent'),
            $this = $(this);

        Swal.fire({
            title: title ? title : 'Are you sure to delete this item?',
            text: text ? text : "The item will be removed permanently!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText ? confirmText : 'Yes, delete it!'
        }).then((result) =>
        {
            if (result.value) {
                if ($(this).hasClass('action-ajax')) {
                    // Handle ajax request upon confirm
                    let url = $(this).data('url'),
                        param = $(this).data('param');


                    const response = fetchCall(url, param, 'POST');

                    if (response instanceof Error) {
                        toastr.error('Ajax request failed', 'Sorry!');
                    } else {
                        response.then(json =>
                        {
                            if (json.success) {
                                toastr.success(json.message, 'Success!');

                                $this.closest(parent).remove();
                            } else {
                                toastr.error(json.message, 'Error!');
                            }
                            return;

                        });
                    }
                } else if ($(this).hasClass('action-form')) {
                    // Handle form submission upon confirm
                    var targetForm = $(this).data('target-form');
                    if (targetForm && $(targetForm).length > 0) {
                        $(targetForm).trigger('submit');
                    } else {
                        $(this).closest('form').trigger('submit');
                    }
                }

            }
        });
    });

    /**
     * Initialize select2 feature in select input fields
     */
    if ($("select.select2").length > 0) {
        $(".select2").select2({
            placeholder: "Please Select"
        });
    }

    if ($('.select-source').length > 0) {
        $('.select-source').each(function ()
        {
            processSelectOptions(this);
        });

        $(document).on('change', '.select-source', function() {
            processSelectOptions(this);
        });
    }

});
