@if (!isset($col) || !$col)
    <div class="form-check {{ isset($div_class) ? $div_class : '' }}">
        @if (!isset($right))
            <label class="form-check-label" for="{{ isset($id) ? $id : "input--$name" }}">
                {{ $label }}
            </label>
        @endif
        <input class="form-check-input {{ isset($class) ? $class : '' }}"
            type="checkbox"
            id="{{ isset($id) ? $id : "input--$name" }}"
            {{ isset($checked) && $checked ? 'checked=""' : '' }}
            >
    </div>
@else
    {{-- <div class="d-inline-flex mt-4">
        @if (!isset($right))
            <span>
                <label class="mt-2">{{ $label }}</label>
            </span>
        @endif
        <span class="p-2">
            <input type="{{ $type }}"
                id="{{ isset($id) ? $id : "input--$name" }}"
                name="{{ $name }}"
                {{ isset($checked) && $checked ? 'checked=""' : '' }}
                value="{{ isset($value) ? $value : 1 }}"
                switch="bool" {{ isset($attr) ? $attr : '' }} >

            <label class="ms-2" for="input--{{ $name }}" data-on-label="Yes"
                data-off-label="No"></label>
        </span>
    </div> --}}
@endif
