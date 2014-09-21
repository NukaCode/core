<div class="col-md-{{ $size }} box box-{{ $color }}">
    <div class="row">
        <div class="col-md-8">
            <h3>{{ $header }}</h3>
            <h4 class="title">{{ $subHeader }}</h4>
        </div>
        <div class="col-md-4">
            <h3><i class="fa fa-2x {{ $icon }}"></i></h3>
        </div>
    </div>
    @if (!isset($editText) || $editText != null)
        <div class="row bar">
            <div class="col-md-12">
                <a href="javascript: void(0);" class="customLink" data-location="/admin/user/{{ $editLink }}">Customize</a>
            </div>
        </div>
    @endif
</div>