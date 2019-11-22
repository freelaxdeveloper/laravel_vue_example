<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ @csrf_token() }}">
    @isset($user)
      <meta name="api-token" content="{{ $user->api_token }}">
      <meta name="jwt-token" content="{{ $token }}">
    @endisset
    @if(!empty($redirect))
      <meta name="redirect" content="{{ $redirect }}">
    @endif
    <link rel="icon" href="favicon.png" type="image/x-icon">
    <title>Donation Support</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href='https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css' rel="stylesheet" type="text/css">
    <link href='{{ mix('/css/app.css') }}' rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="app"></div>
    <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>
