@foreach($quizes as $quiz)
<div class="col-md-6">
    <div class="card border  badge-holder">
        <div class="card-body rectangle-card rounded">
            @if($quiz->result==\App\Models\Quiz::RESULT_PASS)
            <span class="notify-badge-right passed-badge">{!! exam_status($quiz->result) !!}</span>
            @elseif($quiz->result==\App\Models\Quiz::RESULT_FAIL)
            <span class="notify-badge-right failed-badge">{!! exam_status($quiz->result) !!}</span>
            @else
            <span class="notify-badge-right pending-badge">{!! exam_status($quiz->result) !!}</span>
            @endif

            <h5 class="card-para-text">Basic Quiz</h5>
            <p class="large-text">{{$quiz->quiz_name}}</p>
            <div class="px-3">

                <div class="row bg-white px-0">
                    <div class="col-4 text-center px-0 small-text">@lang('translation.Questions')</div>
                    <div class="col-4 text-center px-0 small-text">@lang('translation.total_answers')</div>
                    <div class="col-4 text-center px-0 small-text ">@lang('translation.specific_date')</div>
                    <div class="col-4 text-center px-0 font-weight-bold">{{ $quiz->questions }}</div>
                    <div class="col-4 text-center px-0 font-weight-bold">{{ $quiz->answers }}</div>
                    <div class="col-4 text-center px-0 font-weight-bold">{{ $quiz->quiz_created_at }}</div>
                </div>
            </div>
            @if ($quiz->result <= 0) <div class="d-flex justify-content-start mt-3 px-0 py-2">
                <a href="{{ route('student.quiz.exam', [ 'quizResult' => $quiz->exam_id ]) }}"
                    class="card-button mx-0">@lang('translation.take_quiz_small')</a>
        </div>

        @else

        <div class="d-flex justify-content-start mt-3 px-0 py-2">
            <a href="{{ route('quiz.result.view', [ 'quizResult' => $quiz->exam_id ]) }}" class="card-button mx-0">@lang('translation.view_result_small')</a>
        </div>
        @endif



    </div>
</div>
</div>
@endforeach



<div class="col-12"></div>


<div class="col-12" style="display: flex;justify-content: center;">{{$quizes->links()}}</div>