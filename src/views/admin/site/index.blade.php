<div class="row" style="margin: 0 auto;">
    <div class="col-md-2 box box-primary">
        <div class="row">
            <div class="col-md-8">
                <h3>{{ ucfirst(Config::get('core::theme.theme.style')) }}</h3>
                <h4 class="title">Theme</h4>
            </div>
            <div class="col-md-4">
                <h3><i class="fa fa-2x fa-css3"></i></h3>
            </div>
        </div>
        <div class="row bar">
            <div class="col-md-12">
                <a href="admin/site/theme" data-toggle="modal" data-target="#remoteModal">Customize</a>
            </div>
        </div>
    </div>
    <div class="col-md-2 box box-laravel">
        <div class="row">
            <div class="col-md-8">
                <h3>{{ $laravelVersion }}</h3>
                <h4 class="title">Laravel</h4>
            </div>
            <div class="col-md-4">
                <h3><i class="fa fa-2x fa-code"></i></h3>
            </div>
        </div>
        <div class="row bar">
            <div class="col-md-12">
                <a href="http://packagist.org/packages/laravel/framework" target="_blank">Packagist</a>
                &nbsp;|&nbsp;
                <a href="http://laravel.com/docs" target="_blank">Documentation</a>
            </div>
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Theme Options</div>
            <table class="table table-condensed table-striped table-hover">
                <tbody>
                    <tr>
                        <td>Style</td>
                        <td>{{ Config::get('core::theme.theme.style') }}</td>
                    </tr>
                    <tr>
                        <td>Source</td>
                        <td>{{ Config::get('core::theme.theme.src') }}</td>
                    </tr>
                    <tr>
                        <td>Color: Gray</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.gray') }};"></i>
                            {{ Config::get('core::theme.colors.gray') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Color: Primary</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.primary') }};"></i>
                            {{ Config::get('core::theme.colors.primary') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Color: Info</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.info') }};"></i>
                            {{ Config::get('core::theme.colors.info') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Color: Success</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.success') }};"></i>
                            {{ Config::get('core::theme.colors.success') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Color: Warning</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.warning') }};"></i>
                            {{ Config::get('core::theme.colors.warning') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Color: Danger</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.danger') }};"></i>
                            {{ Config::get('core::theme.colors.danger') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Color: Menu</td>
                        <td>
                            <i class="fa fa-square" style="color: {{ Config::get('core::theme.colors.menu') }};"></i>
                            {{ Config::get('core::theme.colors.menu') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Laravel Details</div>
            <table class="table table-condensed table-striped table-hover">
                <tbody>
                    <tr>
                        <td>Laravel</td>
                        <td style="width: 20%;">{{ $laravelVersion }}</td>
                        <td style="width: 20%;" class="text-right">{{ HTML::link('http://packagist.org/packages/laravel/framework', 'View', ['target' => '_blank']) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Nuka Code Package Versions</div>
            <table class="table table-condensed table-striped table-hover">
                <tbody>
                    @foreach ($packages as $package => $details)
                        <tr>
                            <td>{{ Str::title($package) }}</td>
                            <td style="width: 20%;">{{ $details['version'] }}</td>
                            <td style="width: 20%;" class="text-right">{{ HTML::link('http://packagist.org/packages/nukacode/'. $package, 'View', ['target' => '_blank']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>