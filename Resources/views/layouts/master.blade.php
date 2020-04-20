<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BtFourPointFour</title>
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <base href="{{\URL::to('/')}}">
    <meta name="current-url" id="current_url" content="{{ url()->current() }}">

    <meta name="debug" id="debug" content="true">

    <link  href="{{vh_theme_assets_url("BtFourPointFour", "css/site.css")}}"
           rel="stylesheet" media="screen">

    @yield("head");

</head>
<body>
<div>

    @yield("content");

</div>



<script src="{{vh_theme_assets_url("BtFourPointFour", "js/script.js")}}"></script>

@yield("scripts");


</body>
</html>
