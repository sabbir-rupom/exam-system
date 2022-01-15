<div class="panel-body pt-2">
    <div class="row option-row mb-3" data-index="1">
        <label class="col-sm-2 col-form-label text-center">
            Answer #<span class="counter">1</span>
        </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" required placeholder="enter answer" name="option[]">
        </div>
    </div>
</div>
<div class="panel-footer row">
    <div class="col-md-10 offset-md-2">
        <button type="button" class="btn btn-success btn-add-more" data-target=".option-row">
            <i class="fas fa-plus"></i>
        </button>
        <button type="button" class="btn btn-danger btn-remove-more" style="display: none" data-target=".option-row"
            data-min="1">
            <i class="fas fa-minus"></i>
        </button>
    </div>
</div>
