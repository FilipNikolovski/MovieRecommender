@extends('layout')
@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="padding-top:30px;">
                Top rated TV Shows
            </h1>
        </div>
    </div>
    <!-- /.row -->

    <!-- Projects Row -->
    <div class="row">
        @if(!empty($movies))
            @foreach($movies as $movie)
                <div class="col-md-6 portfolio-item">
                    <a href="{{url('/movie/' . $movie['id'])}}">
                        <?php $posterPath = (isset($movie['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500'.$movie['backdrop_path'] : ''; ?>
                        <img class="img-responsive" src="{{$posterPath}}" alt="{{$movie['original_title']}}">
                    </a>

                    <h3>
                        <a href="{{url('/movie/' . $movie['id'])}}">{{$movie['original_title']}}</a>
                    </h3>

                    <p>{{str_limit($movie['overview'], 150)}}</p>
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

    <!-- Latest TV Shows-->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">
                Latest TV Shows
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

    <!-- Popular TV Shows -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">
                Popular TV Shows
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