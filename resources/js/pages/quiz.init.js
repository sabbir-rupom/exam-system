
class QuizExam
{
    constructor()
    {
        this.questionSet = {},
            this.questions = [],
            this.examId = null,
            this.currentQuestion = null,
            this.prevQuestion = null,
            this.qKey = null,
            this.duration = 0,
            this.answers = [],
            this.quizAnswers = {},
            this.answerOption = null,
            this.answerValue = '',
            this.postData = {},
            this.startTime = null,
            this.endTime = null,
            this.endFlag = false,
            this.isAdmin = false,
            this.currentBlock = null,
            this.viewBlock = null;

        console.clear();
    }

    timer()
    {
        if (!this.duration || this.duration <= 0) {
            return;
        }
        let timeleft = this.duration * 60 * 1000;
        let $this = this;

        var examCountdown = setInterval(function ()
        {
            if (timeleft <= 0) {
                /**
                 * Perform action upon countdown is over
                 */
                clearInterval(examCountdown);
                quizTimer(0);
                $this.finishExam(false);
            } else {
                quizTimer(timeleft);
                timeleft = timeleft - 1000;
            }
        }, 1010);
    }

    finishExam($this)
    {
        if ($this === false) {
            this.submitQuizAnswers();
        } else {
            let confirm = handleConfirmation($this);

            if (confirm instanceof Error) {
                toastr.error(confirm.message, 'Error!');
            } else {
                confirm.then(value =>
                {
                    if (value) {
                        this.submitQuizAnswers();
                    }
                });
            }
        }
    }

    submitQuizAnswers()
    {
        pageLoader();

        this.endTime = new Date();
        const submitForm = $('#form--quiz_finish');

        let inputHtml = '', qas = Object.keys(this.quizAnswers);
        inputHtml += `<input type="hidden" name="quiz_answer" value='${JSON.stringify(this.quizAnswers)}'>`;
        // if (qas.length > 0) {
        //     qas.forEach(qid =>
        //     {
        //         inputHtml += `<input type="hidden" name="q_option[${qid}]" value="${this.quizAnswers[qid].option}">`;
        //         inputHtml += `<input type="hidden" name="q_value[${qid}]" value="${this.quizAnswers[qid].value}">`;
        //     });
        // }
        inputHtml += `<input type="hidden" name="start_time" value="${convertUTCtoDatetime(this.startTime)}">`;
        inputHtml += `<input type="hidden" name="end_time" value="${convertUTCtoDatetime(this.endTime)}">`;
        inputHtml += `<input type="hidden" name="exam_id" value="${this.examId}">`;

        submitForm.append(inputHtml).trigger('submit');
    }

    showNext()
    {
        if (this.qKey == null) {
            this.qKey = 0;
            $('#quiz--q_block').html('');
        } else {
            this.prevQuestion = this.currentQuestion;
            this.qKey++;
        }

        this.processAnswer();

        this.currentQuestion = this.questions[this.qKey];

        this.processQuiz();

    }

    showPrevious()
    {
        this.qKey--;
        this.prevQuestion = this.currentQuestion;

        this.processAnswer();
        this.currentQuestion = this.questions[this.qKey];

        this.quizStatus();
        this.buttonControls();

        this.viewBlock.hide();
        $('.question-block-' + this.currentQuestion).show();

    }

    refreshQuestionBlocks()
    {
        this.viewBlock = $('.question-block');
        this.currentBlock = $('.question-block-' + this.currentQuestion);

        if (this.viewBlock == null || this.currentBlock == null) {
            return;
        }

        this.viewBlock.hide();
        if (this.viewBlock.length > 0 && this.currentBlock) {
            this.currentBlock.show();
        }
    }

    switchQuestionView(qid)
    {
        if (this.answers.includes(qid)) {
            this.currentQuestion = qid;

            this.qKey = parseInt(Object.keys(this.questions).find(
                key => this.questions[key] === this.currentQuestion)
            );

        }

        this.quizStatus();
    }

    viewAnswers()
    {
        let $this = this, tdHtml = '';

        $this.processAnswer();
        $this.quizStatus();

        this.questions.forEach(function (value, index)
        {
            if ($('.question-block-' + value).length > 0) {
                tdHtml += `<tr><td><button class="btn btn-default view-question" data-block="${value}">Question ${index + 1}</button></td>`;
                if ($this.answers.includes(value)) {
                    tdHtml += '<td class="text-success text-center">Answered</td>';
                } else {
                    tdHtml += '<td class="text-danger text-center">Skipped</td>';
                }
                tdHtml += '</tr>';
            }
        });

        $('#quiz--review_modal').modal('toggle');
        $('#quiz--review_modal table tbody').html(tdHtml);
    }

    processAnswer()
    {
        if (this.currentBlock == null) {
            return;
        }

        const questionType = this.currentBlock.find('.quiz-question-type').val();
        let option = null, arr = [], answer = {};

        switch (questionType) {
            case 'single':
                // Handle single / input radio button choice
                option = this.currentBlock.find('.quiz-option:checked').val();
                if (option) {
                    answer = {
                        question: this.currentQuestion,
                        option: parseInt(option),
                        value: ''
                    };
                }
                break;
            case 'multiple':
                // Handle multiple / input checkbox choices
                option = this.currentBlock.find('.quiz-option:checked').serializeArray();
                if (option && option.length > 0) {
                    option.forEach(element =>
                    {
                        arr.push(element.value);
                    });
                }
                answer = {
                    question: this.currentQuestion,
                    option: null,
                    value: JSON.stringify(arr)
                };
                break;
            case 'mapping':
                // handle mapping / left hand selection & right hand selection choices
                let mleft = this.currentBlock.find('select[name="shuffle_left"]').val(),
                    mright = this.currentBlock.find('select[name="shuffle_right"]').val();

                if (mleft && mright && mleft > 0 && mright > 0) {
                    answer = {
                        question: this.currentQuestion,
                        option: null,
                        value: JSON.stringify({
                            left: mleft,
                            right: mright
                        })
                    };
                }
                break;
        }

        if (answer.question) {
            if (!this.answers.includes(answer.question)) {
                this.answers.push(answer.question);
            }
            this.answerOption = answer.option;
            this.answerValue = answer.value;

            this.quizAnswers[answer.question] = {
                value: answer.value,
                option: answer.option,
            };
        }
    }

    buttonControls()
    {
        if ((this.qKey + 1) in this.questions) {
            $('.btn-quiz.quiz-next').show();
        } else {
            $('.btn-quiz.quiz-next').hide();
        }
        if ((this.qKey - 1) in this.questions) {
            $('.btn-quiz.quiz-prev').show();
        } else {
            $('.btn-quiz.quiz-prev').hide();
        }

        if (!$(".btn-quiz.quiz-end").is(":visible")) {
            $('.btn-quiz.quiz-end').show();
        }

        if (this.viewBlock && this.viewBlock.length > 1) {
            $('.btn-quiz.quiz-review').show();
            $('.btn-quiz.terminate').remove();
        }
    }

    quizStatus()
    {

        $('#text--ques_amount').html(this.questionSet.length);
        $('#text--ques_number').html(this.qKey + 1);
        $('#text--ques_answered').html(this.answers ? this.answers.length : 0);

        this.refreshQuestionBlocks();
        this.buttonControls();
    }



    processQuiz()
    {
        if ($('.question-block-' + this.currentQuestion).length <= 0) {
            this.postData.fetch = 1;
        }

        this.postData.next_question = this.currentQuestion;
        this.postData.question = this.prevQuestion;
        this.postData.exam_id = this.examId;
        this.postData.option = this.answerOption;
        this.postData.value = this.answerValue;
        const response = fetchCall('/ajax/quiz/exam/update', this.postData, 'POST');

        if (response instanceof Error) {
            toastr.error(response.message, 'Error!');
        } else {
            response.then(json =>
            {
                if (json.success) {
                    if (json.html && $('.question-block-' + this.currentQuestion).length <= 0) {
                        $('#quiz--q_block').append(json.data);

                    }
                    this.quizStatus();
                    if (this.startTime === undefined || this.startTime === null) {
                        this.startTime = new Date();
                        this.timer();
                    }

                } else {
                    toastr.error(json.message, 'Error!');
                }
            });
        }
    }
}


$(function ()
{

    'use strict';

    /**
     * Ask confirmation before retaking a quiz
     */
    $('.confirm-quiz-action').on('click', function (e)
    {
        e.preventDefault();

    });

    const isQuizExam = $('#quiz--ques_set').length > 0 ? true : false;

    if (isQuizExam) {
        startQuiz();
    }

});

/**
 * Start quiz exam
 */
function startQuiz()
{
    var quiz = new QuizExam();

    quiz.duration = parseInt($('#quiz--duration').val());
    quiz.examId = parseInt($('#quiz--exam_id').val());
    quiz.questionSet = JSON.parse($('#quiz--ques_set').val());
    quiz.questions = Object.values(quiz.questionSet);

    /* Fetch 1st question */
    quiz.showNext();

    /**
     * Fetch next question
     */
    $(document).on('click', '.quiz-next', function ()
    {
        quiz.showNext();
    });

    /**
     * Show previous question
     */
    $(document).on('click', '.quiz-prev', function ()
    {
        quiz.showPrevious();
    });

    /**
     * process final answer and finish quiz exam
     */
    $(document).on('click', '.quiz-end', function (e)
    {
        e.preventDefault();

        quiz.finishExam(this);
    });

    /**
     * Review answered questions
     */
    $(document).on('click', '.quiz-review', function ()
    {
        quiz.viewAnswers();
    });

    $(document).on('click', '.view-question', function ()
    {
        let qid = parseInt($(this).data('block'));
        quiz.switchQuestionView(qid);
        $('#quiz--review_modal').modal('toggle');
    });
}

/**
 * Render countdown time string in Hours:Miniutes:Seconds
 *
 * @param {int} timeleft In miliseconds
 * @returns void
 */
function quizTimer(timeleft)
{
    let hours = 0,
        minutes = 0,
        seconds = 0,
        timestring = '';

    if (timeleft > 1000) {
        hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
    }

    if (hours < 10) {
        hours = `0${hours}`
    }
    if (minutes < 10) {
        minutes = `0${minutes}`
    }
    if (seconds < 10) {
        seconds = `0${seconds}`
    }

    // Result is output to the specific element
    timestring = `${hours}:${minutes}:${seconds}`;
    document.getElementById("quiz--time_left").innerHTML = timestring;

    return;
}
