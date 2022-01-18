<!-- start page title -->
@php
$title = isset($pageTitle) && $pageTitle ? $pageTitle : $breadTitle;
@endphp
<div class="theme-bread-style p-3">
    <div class="d-sm-flex">
        <ol class="breadcrumb m-0 p-0">
            @isset($breadSingle)
                <li class="breadcrumb-item text-muted mt-1">{{ $breadSingle }}</li>
            @else
                <li class="breadcrumb-item"><a href="{!! isset($breadLink) ? trim($breadLink) : url('/') !!}">{{ $breadTitle }}</a></li>
                @isset($breadSubTitle)
                    <li class="breadcrumb-item"><a href="{!! isset($breadSubLink) ? trim($breadSubLink) : 'javascript: void(0);' !!}">{{ $breadSubTitle }}</a></li>
                @endisset
                @isset($breadSubTitle1)
                    <li class="breadcrumb-item"><a href="{!! isset($breadSubLink1) ? trim($breadSubLink1) : 'javascript: void(0);' !!}">{{ $breadSubTitle1 }}</a></li>
                @endisset
                <li class="breadcrumb-item active">{{ isset($activeTitle) ? $activeTitle : $title }}</li>
            @endisset
        </ol>
    </div>
</div>
<!-- end page title -->
