
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
                modal: {},
                toolbox: {
                    question: '<div class="toolbox question">'
                        + '<button class="btn btn-sm btn-danger btn-action" data-action="remove" data-type="question" title="Remove this">X</div>'
                        + '</div>',
                },
                parent: {}
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

        console.log(this.paper)

        return this;
    }

    buildForm()
    {
        this.setElement('header').setElement('footer').setElement('body');

        if (this.questions.used.length < this.paper.amount) {
            this.btnNewItem('main');
        }

        this.bindEvents();

        return;
    }

    btnNewItem(parent)
    {

        if ($('#button--addItem').length <= 0) {
            let addBtn = $('<div/>', {
                class: 'd-flex justify-content-center mt-3',
            });

            $(this.element.body).append(
                addBtn.append(
                    $('<button/>', {
                        text: 'Add Item',
                        id: 'button--addItem',
                        class: 'btn btn-lg btn-outline-secondary btn-action'
                    }).attr({
                        'data-parent': parent,
                        'data-action': 'add',
                    })
                )
            );
        }

        return this;
    }

    bindEvents()
    {
        let $this = this;

        $(this.element.header).on('click', function ()
        {
            $this.formTextbox('header', $this.paper.header);
        });
        $(this.element.footer).on('click', function ()
        {
            $this.formTextbox('footer', $this.paper.footer);
        });

        $(document).on('click', '.btn-action', function ()
        {
            let action = $(this).data('action');

            switch (action) {
                case 'add':
                    $this.addItem(this);
                    break;
                case 'remove':
                    $this.removeItem(this);
                    break;
                case 'new-question':
                    $this.showQuestionList();
                    break;
                case 'new-section':
                    $this.addSection();

                    break;
            }
        });
    }

    showQuestionList()
    {
        $(this.element.modal).modal('hide');

        var table = $('<table>'), questions = this.questions.all;

        var tr = $('<tr>');

        for (key in questions) {
            if (this.questions.used[questions[key].id]) {
                continue;
            } else {
                tr.append('<td>#</td>');
                tr.append('<td>' + questions[key].question + '</td>');
                tr.append('<td>' +
                    '<button class="btn btn-success btn-sm" data-action="add-question" data-id="' + questions[key].id + '"'
                    + '</td>');
            }
        }
        table.append(tr);

        $(this.element.modal).find('.modal-body').html(table);

        $(this.element.modal).delay(1000).modal('show');

        return;
    }

    addSection()
    {

    }

    addItem(dom)
    {

        let parent = $(dom).attr('data-parent'), itemDiv = null;

        $(this.element.modal).find('.modal-title').html('Add New Item');
        $(this.element.modal).find('.modal-footer').html('');
        $(this.element.modal).find('button.btn-save').attr('data-save', 'item');

        itemDiv = $('<div/>', {
            class: 'd-flex justify-content-center my-2',
        });

        itemDiv.append(
            $('<div/>', {
                class: 'btn btn-lg btn-outline-secondary btn-action me-2',
            }).attr('data-action', 'new-question').html('Add Question')
        );
        itemDiv.append(
            $('<div/>', {
                class: 'btn btn-lg btn-outline-secondary btn-action',
            }).attr('data-action', 'new-section').html('Add Section')
        );

        $(this.element.modal).find('.modal-body').html(itemDiv);

        $(this.element.modal).modal('show');
    }

    removeItem(item)
    {
        let type = $(item).data('type');

        if (type === 'question') {
            let qItem = $(item).closest('.e-question');
            let qid = parseInt(qItem.data('question')), tempArr = this.questions.used;

            delete tempArr[qid];

            this.questions.used = tempArr;

            qItem.remove();

            this.btnNewItem(
                qItem.data('parent')
            );
        }
    }

    setElement(type)
    {
        if (type === 'header') {
            $(this.element.header).html(this.paper.header);
        } else if (type === 'footer') {
            $(this.element.footer).html(this.paper.footer);
        } else {
            // generate question body
            for (let i in this.paper.main) {
                this.generateQuestionBody(this.paper.main[i])
            }

            sortable(this.element.body, {
                forcePlaceholderSize: true,
            })[0].addEventListener('sortupdate', function (e)
            {
                console.log('sort action');
            });

        }

        return this;
    }

    generateQuestionBody(obj)
    {
        let qDiv = '';
        if (obj.group) {

        } else {
            qDiv = $('<div/>', {
                class: 'item e-question e-question-' + obj.question.id,
            }).attr('data-parent', 'main');

            qDiv.html(`<div class="q-text">${obj.question.value}</div>`);
            qDiv.append(this.element.toolbox.question);
            qDiv.attr('data-question', obj.question.id);
        }

        $(this.element.body).append(qDiv);

        return;
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

        return;
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
