
class QuestionPaper
{
    constructor()
    {
        this.questions = {
            all: [],
            used: []
        },
            this.paper = {},
            this.element = {
                header: {},
                body: {},
                footer: {},
                modal: {}
            };

        console.clear();
    }

    init(obj)
    {
        this.paper = JSON.parse($($(obj).data('json')).val());
        this.questions.all = JSON.parse($($(obj).data('questions')).val());
        this.questions.used = this.paper.questions;

        this.element.header = $(obj).data('form-header');
        this.element.body = $(obj).data('form-body');
        this.element.footer = $(obj).data('form-footer');
        this.element.modal = $(obj).data('form-modal');

        return this;
    }

    buildForm()
    {
        this.setElement('header').setElement('footer');

        let $this = this;

        $(this.element.header).on('click', function ()
        {
            $this.formTextbox('header', $this.paper.header);
        });
        $(this.element.footer).on('click', function ()
        {
            $this.formTextbox('footer', $this.paper.footer);
        });

    }

    setElement(type)
    {
        if (type === 'header') {
            $(this.element.header).html(this.paper.header);
        } else if (type === 'footer') {
            $(this.element.footer).html(this.paper.footer);
        }

        return this;
    }

    formTextbox(action, value)
    {
        let textArea = $('<textarea class="form-control" id="editor--richText" />'),
            title = '';


        if (action === 'header') {
            title = 'Set paper header';
        } else if (action === 'footer') {
            title = 'Set paper footer';

        } else {
            return;
        }

        $(this.element.modal).find('.modal-body').html(textArea);
        $(this.element.modal).find('.modal-title').html(title);
        $(this.element.modal).find('button.btn-save').attr('data-save', action);
        $(this.element.modal).modal('show');

        textArea.val(value);

        tinymce.init({
            selector: "textarea#editor--richText",
            height: 300,
            menubar: '',
            plugins: [
                "autolink link lists preview hr anchor",
                "code wordcount fullscreen ",
                "paste"
            ],
            toolbar: "undo redo | styleselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | preview code",
        });
    }
}

$(function ()
{

    'use strict';

    var qPaper = new QuestionPaper();

    qPaper.init($('#builder--panel')).buildForm();

    // qPaper.questions = Object.values(qPaper.questionSet);
    // console.log(qPaper);

    let actionSave = $(qPaper.element.modal).find('button.btn-save');
    actionSave.on('click', function ()
    {
        tinyMCE.triggerSave();

        let action = actionSave.data('save'),
            textValue = $(qPaper.element.modal).find('textarea').val();

        console.log(textValue);

        qPaper.paper[action] = textValue;

        qPaper.setElement(action);

        $(qPaper.element.modal).modal('hide');
    });


});
