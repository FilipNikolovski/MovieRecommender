@extends('layout')
@section('content')
    <div class="row" style="margin-top:5px;margin-bottom:10px;padding-top:40px;">
        <div class="col-lg-12">
            <h1 class="page-header">{{$movie['original_title']}}</h1>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="movieId" value="{{$movie['id']}}">
        <div class="col-lg-4 col-md-5 col-xs-10 col-sm-8">
            <div id="raty"></div>
            <?php $imgSrc = (isset($movie['poster_path'])) ? 'http://image.tmdb.org/t/p/w500' . $movie['poster_path'] : asset('images/no_image.jpg'); ?>
            <img class="img-responsive" src="{{$imgSrc}}" alt="{{$movie['original_title']}}"/>
            @if(!empty($username))
                <button type="button" id="add-to-favorite" class="btn btn-primary">Add to favorite</button>
                <button type="button" id="add-to-watchlist" class="btn btn-warning" style="float:right">Add to watchlist</button>
            @endif
        </div>
        <div class="col-lg-8 col-md-7 col-xs-7">
            <div class="col-lg-4 col-md-7 col-xs-7">
                <h4>Status: <span class="label label-info">{{$movie['status']}}</span></h4>
            </div>
            <div class="col-lg-4 col-md-7 col-xs-7">
                <h4>Release date: <span class="label label-success">{{$movie['release_date']}}</span></h4>
            </div>
            <div class="col-lg-4 col-md-7 col-xs-7">
                <h4>Votes average: <span class="label label-danger">{{$movie['vote_average']}}</span></h4>
            </div>
        </div>
        <div class="col-lg-8 col-md-10 col-xs-12 col-sm-12">
            <h4>Overview:</h4>

            <div class="well">{{$movie['overview']}}</div>
        </div>
        <div class="col-lg-8 col-md-7 col-xs-7">

            <h4>Genres:
                @if(!empty($movie['genres']))
                    @foreach($movie['genres'] as $genre)
                        <span class="label label-warning" style="margin-right:5px;">{{$genre['name']}}</span>
                    @endforeach
            </h4>
            @else
                <span>There are no genres for this movie</span>
            @endif
        </div>
        <div class="col-lg-8 col-md-10 col-xs-10 col-sm-10">
            <h4>Reviews:</h4>

            <div class="well">
                @if(!empty($reviews) && $reviews->total() > 0)
                    @foreach($reviews as $review)
                        <div class="row">
                            <h4>Author: <span>{{$review['author']}}</span></h4>
                            <span>{{$review['content']}}</span>
                        </div>
                    @endforeach
                @else
                    <span>Currently there are no reviews for this movie.</span>
                    @endif
                            <!-- Pagination -->
                    <div class="row text-center">
                        <div class="col-lg-12">
                            {!!$reviews->render()!!}
                        </div>
                    </div>
                    <!-- /.row -->
                    <hr>
            </div>
        </div>

            <div class="row" style="margin-top:5px;margin-bottom:10px;padding-top:40px;">
                <div class="col-lg-12">
                    <h2 class="page-header">Similar movies:</h2>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12" id="similar-movies">
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

    </div>
    @if(!empty($videos['results'][0]))
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Trailer:</h2>
            </div>
            <div class="col-lg-12">
                <div class="player">
                    <?php $imgSrc = (isset($movie['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500' . $movie['backdrop_path'] : asset('images/no_image.jpg'); ?>
                    <iframe id="videoPlay" type="text/html"
                            src="http://www.youtube.com/embed/{{$videos['results'][0]['key']}}" width="100%"
                            height="650" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    @endif
@endsection