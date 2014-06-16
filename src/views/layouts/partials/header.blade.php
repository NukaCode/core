<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pageTitle }}</title>

<link rel="shortcut icon" href="{{ URL::to('/img/favicon.ico') }}" />

<!-- Extra styles -->
{{ HTML::style('/vendor/messenger/build/css/messenger.css') }}
{{ HTML::style('/vendor/messenger/build/css/messenger-theme-future.css') }}

<!-- Local styles -->
{{ HTML::style('/css/master.css') }}
{{ HTML::style('http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css') }}

<!-- Css -->
@section('css')
@show
<!-- Css Form -->
@section('cssForm')
@show