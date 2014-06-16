<div class="row">
    <div class="col-md-2 box box-primary">
        <div class="row">
            <div class="col-md-8">
                <h3>{{ ucfirst(Config::get('core::theme.style')) }}</h3>
                <h4 class="title">Theme</h4>
            </div>
            <div class="col-md-4">
                <h3><i class="fa fa-2x fa-css3"></i></h3>
            </div>
        </div>
        <div class="row bar">
            <div class="col-md-12">
                <a href="javascript:void(0);">Customize</a>
            </div>
        </div>
    </div>
    <div class="col-md-2 box box-success">
        <div class="row">
            <div class="col-md-8">
                <h3>{{ ucfirst(Config::get('database.default')) }}</h3>
                <h4 class="title">Database</h4>
            </div>
            <div class="col-md-4">
                <h3><i class="fa fa-2x fa-database"></i></h3>
            </div>
        </div>
        <div class="row bar">
            <div class="col-md-12">
                <a href="javascript:void(0);">Customize</a>
            </div>
        </div>
    </div>
</div>

{{ bForm::submit('Test', ['class' => 'btn btn-info']) }}
{{ bForm::submit('Test', ['class' => 'btn btn-success']) }}
{{ bForm::submit('Test', ['class' => 'btn btn-warning']) }}
{{ bForm::submit('Test', ['class' => 'btn btn-danger']) }}
{{ bForm::submit('Test', ['class' => 'btn btn-inverse']) }}