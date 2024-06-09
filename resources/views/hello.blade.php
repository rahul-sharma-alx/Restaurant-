<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localization</title>
</head>
<body>
    <a href="{{url('msg/')}}" >Eng</a>
    <a href="{{url('msg/hi')}}" >Hi</a>
    <h1>{{ __('welcome') }}</h1>
    <p>{{ __('welcome') }}</p>
    <h1>@lang('lang.welcome')</h1>
    <p>@lang('lang.welcome')</p>
</body>
</html>