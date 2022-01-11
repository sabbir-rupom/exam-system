$(function ()
{

    'use strict';

    if($('input[name="question_type"]').length > 0) {
        let qVal = $('input[name="question_type"]:checked').val();

        if(qVal < 3) {
            $('.block-action').show();
        } else {
            $('.block-action').hide();
        }

        $('input[name="question_type"]').on('change', function() {
            qVal = $(this).val();
            if(qVal < 3) {
                $('.block-action').show();
            } else {
                $('.block-action').hide();
            }
        });
    }

});