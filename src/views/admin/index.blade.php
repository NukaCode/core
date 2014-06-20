<style>
    div.full {
        margin-left: -2%;
        margin-right: -1%;
    }

    .box {
        border-radius: 5px;
        border: 1px solid #000;
        box-shadow: rgba(255,255,255, .1) 0 1px 0, rgba(0,0,0, .8) 0 1px 7px 0px inset;
    }

    .box-primary {
        background-color: #5097b5;
    }

    .box-primary i {
        color: #091216;
    }

    .box-success {
        background-color: #62c462;
    }

    .box-success i {
        color: #122f12;
    }

    .box-info {
        background-color: #3b81ba;
    }

    .box-info i {
        color: #04080c;
    }

    .box-warning {
        background-color: #e38928;
    }

    .box-warning i {
        color: #211304;
    }

    .box-danger {
        background-color: #ba403b;
    }

    .box-danger i {
        color: #0c0404;
    }

    .box-inverse {
        background-color: #343838;
    }

    .box-inverse i {
        color: #000;
    }

    .box i {
        opacity: .2;
    }

    .box .title {
        opacity: .7;
    }

    .box .bar {
        text-align: center;
        background: rgba(0, 0, 0, .2);
    }

    .box .bar:hover {
        background: rgba(0, 0, 0, .6);
    }

    .box .bar a {
        color: #fff;
        font-weight: bold;
    }
</style>

<div class="full">
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group">
                <li class="list-group-item"><a class="ajaxLink" id="site" data-location="admin/site">Site</a></li>
                <li class="list-group-item"><a class="ajaxLink" id="users" data-location="admin/user">Users</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div id="ajaxContent">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        var url   = location.href;
        var parts = url.split('#');

        if (parts[1] != null) {
            $('#'+ parts[1]).parent().addClass('active');
            $('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#ajaxContent').load($('#'+ parts[1]).attr('data-location'));
        } else {
            $('#site').parent().addClass('active');
            $('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#ajaxContent').load($('#site').attr('data-location'));
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
            $('#'+ target).toggle();
        }
    </script>
@stop