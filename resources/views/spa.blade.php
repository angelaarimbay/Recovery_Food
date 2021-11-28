@php
$config = [
    'appName' => config('app.name'),
    'locale' => ($locale = app()->getLocale()),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
    'tomorrow' => config('app.dateTomorrow'),
    'maxdate' => config('app.maxdate'),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/4.5.95/css/materialdesignicons.css">

</head>

<body>
    <div id="app"> </div>
    <script>
        window.config = <?php echo json_encode($config); ?>
    </script>
    <script src="{{ mix('dist/js/app.js') }}"></script>
</body>

</html>
