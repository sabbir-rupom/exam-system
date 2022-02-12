@if (!isset($col) || !$col)
    <div class="form-group {{ isset($div_class) ? $div_class : '' }}">
        <label for="input--{{ $name }}">{{ $label }}</label>
        <input
            type="{{ $type }}"
            class="{{ isset($class) ? $class : '' }}"
            id="{{ isset($id) ? $id : "input--$name" }}"
            placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
            value="{{ isset($value) ? $value : '' }}"
            {{ isset($name) ? "name='$name'" : '' }}
            {{ isset($require) && $require  ? 'required' : '' }}
            {{ isset($attr) ? $attr : '' }} >

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
            <input
            type="{{ $type }}"
            class="{{ isset($class) ? $class : '' }}"
            id="{{ isset($id) ? $id : "input--$name" }}"
            placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
            value="{{ isset($value) ? $value : $value }}"
            {{ isset($name) ? "name='$name'" : '' }}
            {{ isset($require) && $require  ? 'required' : '' }}
            name="name"
            {{ isset($attr) ? $attr : '' }} >
        </div>

        @if (isset($require) && $require)
            @error($name)
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        @endif
    </div>
@endif
