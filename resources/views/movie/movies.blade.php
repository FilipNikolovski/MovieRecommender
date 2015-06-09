@extends('layout')
@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="padding-top:30px;">
                Top Playing Movies
            </h1>
        </div>
    </div>
    <!-- /.row -->

    <!-- Projects Row -->
    <div class="row">
        @if(!empty($movies))
            @foreach($movies as $movie)
                <div class="col-md-6">
                    <a href="{{url('/movies/' . $movie['id'])}}">
                        <?php $posterPath = (isset($movie['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500'.$movie['backdrop_path'] : asset('images/no_image.jpg'); ?>
                        <img class="img-responsive" src="{{$posterPath}}" alt="{{$movie['original_title']}}">
                    </a>

                    <h3>
                        <a href="{{url('/movies/' . $movie['id'])}}">{{$movie['original_title']}}</a>
                    </h3>

                    <p>{{str_limit($movie['overview'], 75)}}</p>
                </div>
            @endforeach
        @endif
    </div>
    <!-- /.row -->
    <hr>

    <!-- Pagination -->
    <div class="row text-center">
        <div class="col-lg-12">
            {!!$movies->render()!!}
        </div>
    </div>
    <!-- /.row -->
    <hr>

    <!-- Top Rated -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">
                Top Rated
            </h2>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12" id="top-rated">
            <div class="list-item animated infinite pulse">
            </div>
            <div class="list-item animated infinite pulse">
            </div>
            <div class="list-item animated infinite pulse">
            </div>
            <div class="list-item animated infinite pulse">
            </div>
        </div>
    </div>
    <!-- /.row -->
    <hr>

    <!-- Popular -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">
                Popular
            </h2>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12" id="popular">
            <div class="list-item animated infinite pulse">
            </div>
            <div class="list-item animated infinite pulse">
            </div>
            <div class="list-item animated infinite pulse">
            </div>
            <div class="list-item animated infinite pulse">
            </div>
        </div>
    </div>
    <!-- /.row -->
    <hr>
    </div>
@endsection