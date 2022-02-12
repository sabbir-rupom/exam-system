
@if (!isset($col) || !$col)
<div class="form-group {{ isset($div_class) ? $div_class : '' }}">
    <label for="input--{{ $name }}">{{ $label }}</label>
    <textarea class="{{ isset($class) ? $class : '' }}"
        {{ isset($name) ? "name='$name'" : '' }}
        placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
        id="{{ isset($id) ? $id : "input--$name" }}"
        {{ isset($require) && $require  ? 'required' : '' }}
        {{ isset($attr) ? $attr : '' }} >{{ isset($value) ? $value : '' }}</textarea>

        @if (isset($require) && $require)
            @error($name)
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        @endif

</div>
@else
<div class="row mb-3">
    <label class="col-lg-2 col-md-4 col-form-label text-end">
        {{ $label }}
    </label>
    <div class="col-lg-10 col-md-8">
        <textarea class="{{ isset($class) ? $class : '' }}"
        {{ isset($name) ? "name='$name'" : '' }}
            placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
            id="{{ isset($id) ? $id : "input--$name" }}"
            {{ isset($require) && $require  ? 'required' : '' }}
            {{ isset($attr) ? $attr : '' }} >{{ isset($value) ? $value : '' }}</textarea>
    </div>

    @if ($require)
        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    @endif
</div>
@endif
