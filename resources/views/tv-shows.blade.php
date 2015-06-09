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

    <div class="row">
        @if(!empty($tvShows))
            @foreach($tvShows as $tv)
                <div class="col-md-6">
                    <a href="{{url('/tv-shows/' . $tv['id'])}}">
                        <?php $posterPath = (isset($tv['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500'.$tv['backdrop_path'] : asset('images/no_image.jpg'); ?>
                        <img class="img-responsive" src="{{$posterPath}}" alt="{{$tv['original_name']}}">
                    </a>

                    <h3>
                        <a href="{{url('/tv-shows/' . $tv['id'])}}">{{$tv['original_name']}}</a>
                    </h3>

                    <p>{{$tv['first_air_date']}}</p>
                </div>
            @endforeach
        @endif
    </div>
    <!-- /.row -->

    <!-- Pagination -->
    <div class="row text-center">
        <div class="col-lg-12">
            {!!$tvShows->render()!!}
        </div>
    </div>
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
        <div class="col-lg-12" id="top-rated-tv">
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
        <div class="col-lg-12" id="popular-tv">
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