<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token('my_nonce') }}">

    <title>Laravel</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- <link rel="stylesheet" href="{{ WPB_ASSETS . '/css/vendors.css' }}" /> -->

</head>
<body>
    <div id="wpb-spa-app"></div>

    <script src="{{ WPB_ASSETS . '/js/vendors.js' }}"></script>
    <script src="{{ WPB_ASSETS . '/js/runtime.js' }}"></script>
    <script src="{{ WPB_ASSETS . '/js/spa.js' }}"></script>
    <script src="{{ WPB_ASSETS . '/js/style.js' }}"></script>
</body>
</html>
