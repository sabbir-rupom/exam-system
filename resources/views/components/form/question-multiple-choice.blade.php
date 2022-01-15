<div class="panel-body pt-2">
    @for ($i = 1; $i <= 2; $i++)

        <div class="row option-row mb-3" data-index="{{ $i }}">
            <label class="col-sm-2 col-form-label text-center">
                Option #<span class="counter">{{ $i }}</span>
            </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" required placeholder="enter option detail" name="option[]">
            </div>
            <div class="col-sm-2 text-center">
                <div class="form-check form-check-right mt-2">
                    @if ($type <= 1)
                    <input class="form-check-input checkbox-array" data-input="answer" type="radio">
                    <input type="hidden" class="depend-input-array" name="answer[]">
                    @else
                    <input class="form-check-input checkbox-array" data-input="answer" type="checkbox">
                    <input type="hidden" class="depend-input-array" name="answer[]">
                    @endif
                    <label class="form-check-label">
                        Is answer?
                    </label>
                </div>
            </div>
        </div>

    @endfor
</div>
<div class="panel-footer row">
    <div class="col-md-10 offset-md-2">
        <button type="button" class="btn btn-success btn-add-more" data-target=".option-row">
            <i class="fas fa-plus"></i>
        </button>
        <button type="button" class="btn btn-danger btn-remove-more" data-target=".option-row"
            data-min="2">
            <i class="fas fa-minus"></i>
        </button>
    </div>
</div>
