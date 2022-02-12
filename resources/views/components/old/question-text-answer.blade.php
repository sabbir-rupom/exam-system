<div class="panel-body pt-2">
    <div class="row mb-3">
        @if ($text === 'short')
        <label class="col-sm-2 col-form-label text-center">
            Input Short Text #<span class="counter">1</span>
        </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="textInput1" placeholder="enter text here" readonly>
        </div>
        @else
        <label class="col-sm-2 col-form-label text-center">
            Input Long Text #<span class="counter">1</span>
        </label>
        <div class="col-sm-8">
            <textarea class="form-control" id="textArea1" placeholder="enter text here" rows="3" readonly></textarea>
        </div>
        @endif
    </div>
</div>
