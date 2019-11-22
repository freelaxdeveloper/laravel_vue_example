<!DOCTYPE html>
  <html lang=en>
    <head>
      <meta http-equiv=Content-Type content="text/html; charset=utf-8">
      <meta name="csrf-token" content="{{ @csrf_token() }}">
      <meta name="widget" content="{{ $widget }}">
      <meta name="category" content="{{ $widgetCategory }}">
      {{-- <meta name="token" content="{{ $token }}">
      <meta name="user" content="{{ $user }}">
      <meta name="push_id" content="{{ $push_id ?? null }}">
      <meta name="type" content="{{ $type ?? null }}"> --}}
      <link href='https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css' rel="stylesheet" type="text/css">
  </head>
<body>
  
  {{--  <div id="app" :widget="{{ json_encode($widget) }}"></div>  --}}
  <div id="app"></div>

  <script src="{{ mix('/js/widget.js') }}"></script>

</body>
</html>
