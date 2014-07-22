<div style="margin-left: -2%; margin-right: -1%;">
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group">
                @foreach ($areas->panels as $key => $area)
                    <li class="list-group-item"><a class="ajaxLink" id="{{ $area->id }}" data-location="{{ $area->link }}">{{ $area->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-10">
            <div id="ajaxContent">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>
</div>

<script>
    @section('onReadyJs')
        $('#remoteModal').on('click', '.closeModal', function (e) {
            var area = $(e.target).data('area');

            $('#remoteModal').modal('hide');

            $('#customizeArea').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#customizeArea').load('/admin/user/'+ area +'-customize');
        });
    @stop
</script>

@section('js')
    <script>
        var url   = location.href;
        var parts = url.split('#');

        if (parts[1] != null) {
            $('#'+ parts[1]).parent().addClass('active');
            $('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#ajaxContent').load($('#'+ parts[1]).attr('data-location'));
        } else {
            $('#{{ $areas->default }}').parent().addClass('active');
            $('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#ajaxContent').load($('#{{ $areas->default }}').attr('data-location'));
        }
        $('.ajaxLink').click(function() {

            $('.ajaxLink').parent().removeClass('active');
            $(this).parent().addClass('active');

            var link = $(this).attr('id');
            $('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#ajaxContent').load($(this).attr('data-location'));
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });

        function collapse (target) {
            $('.'+ target).toggle();
        }
    </script>
@stop