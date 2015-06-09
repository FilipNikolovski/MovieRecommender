<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movie Recommender</title>

    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    @yield('styles')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
@include('header')

    <!--Login-->
    @include('partials.login')
    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    @include('footer')

<!-- /.container -->
<script>
    var url_base = '{{url()}}';
</script>
<script type="text/javascript" src="{{asset('js/app.min.js')}}"></script>
@yield('scripts')
</body>

</html>
