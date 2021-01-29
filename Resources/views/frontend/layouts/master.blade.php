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


    <link rel="stylesheet" href="{{vh_theme_assets_url("BtFourPointFour", "css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{vh_theme_assets_url("BtFourPointFour", "css/site.css")}}">


    @yield("head")

</head>
<body>

@include("btfourpointfour::frontend.layouts.partials.top")

<div class="container page-container">

    <div class="row">

        <div class="col-md-8">
            @yield("content")
        </div>

        @include("btfourpointfour::frontend.layouts.partials.sidebar")

    </div>

</div>



@include("btfourpointfour::frontend.layouts.partials.footer")

<script src="{{vh_theme_assets_url("BtFourPointFour", "js/jquery-3.4.1.slim.min.js")}}"></script>
<script src="{{vh_theme_assets_url("BtFourPointFour", "js/popper.min.js")}}"></script>
<script src="{{vh_theme_assets_url("BtFourPointFour", "js/bootstrap.min.js")}}"></script>

@yield("scripts")


</body>
</html>
