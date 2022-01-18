$(function ()
{

    'use strict';

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

            }
        });
    });

});
