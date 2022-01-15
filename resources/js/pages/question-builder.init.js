$(function ()
{

    'use strict';

    var qVal = 0, questionType = $('input[name="question_type"]'),
    url = '/ajax/component/get',
    target = '';

    if (questionType.length > 0) {
        qVal = $('input[name="question_type"]:checked').val();

        questionType.on('change', function() {
            if($(this).val() !== qVal) {
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

                if(fieldLabel) {
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

});
