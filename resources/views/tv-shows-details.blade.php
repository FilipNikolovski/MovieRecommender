@extends('layout')
@section('content')
    <div class="container">
        <div class="row" style="margin-top:5px;margin-bottom:10px;padding-top:40px;">
            <div class="col-lg-12">
                <h1 class="page-header">{{$tvShow['original_name']}}</h1>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="tvShowId" value="{{$tvShow['id']}}">

            <div class="col-lg-4 col-md-5 col-xs-10 col-sm-8">
                @if(!empty($sessionId))
                    <?php if(!empty($accountStates['rated'])) {
                        $readonly = 'true';
                        $score = $accountStates['rated']['value'];
                    } else {
                        $readonly = 'false';
                        $score = 0;
                    }?>
                    <div id="raty" data-readonly="{{$readonly}}" data-score="{{$score}}"></div>
                @endif
                <?php $imgSrc = (isset($tvShow['poster_path'])) ? 'http://image.tmdb.org/t/p/w500' . $tvShow['poster_path'] : asset('images/no_image.jpg'); ?>
                <img class="img-responsive" src="{{$imgSrc}}" alt="{{$tvShow['original_name']}}"/>
                @if(!empty($sessionId))
                    <div style="float:left">
                        <?php $btnStyle = ($accountStates['favorite']) ? 'primary' : 'success'; ?>
                        <?php $flag = ($accountStates['favorite']) ? 'false' : 'true'; ?>
                        <form method="post" action="{{action('MoviesController@postFavorites')}}" id="favoritesForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="media_type" value="tv">
                            <input type="hidden" name="media_id" value="{{$tvShow['id']}}">
                            <input type="hidden" name="favorite" value="{{$flag}}">
                            <button type="submit" id="add-to-favorite"
                                    class="btn btn-{{$btnStyle}}"><?php echo (!$accountStates['favorite']) ? 'Add to favorites' : 'Remove from favorites' ?></button>
                        </form>
                    </div>
                    <div style="float:right;">
                        <?php $btnStyle = ($accountStates['watchlist']) ? 'primary' : 'success'; ?>
                            <?php $flag = ($accountStates['watchlist']) ? 'false' : 'true'; ?>
                        <form method="post" action="{{action('MoviesController@postWatchlist')}}" id="watchlistForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="media_type" value="tv">
                            <input type="hidden" name="media_id" value="{{$tvShow['id']}}">
                            <input type="hidden" name="watchlist" value="{{$flag}}">
                            <button type="submit" id="add-to-watchlist"
                                    class="btn btn-{{$btnStyle}}"><?php echo (!$accountStates['watchlist']) ? 'Add to watchlist' : 'Remove from watchlist' ?>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-lg-8 col-md-7 col-xs-7">
                <div class="row">
                    <div class="col-lg-4 col-md-7 col-xs-7">
                        <h4>Seasons: <span class="label label-info">{{$tvShow['number_of_seasons']}}</span></h4>
                    </div>
                    <div class="col-lg-4 col-md-7 col-xs-7">
                        <h4>Episodes: <span class="label label-info"><?php echo ($tvShow['number_of_episodes'] > 0) ? $tvShow['number_of_episodes'] : '/'?></span></h4>
                    </div>
                    <div class="col-lg-4 col-md-7 col-xs-7">
                        <h4>Popularity: <span class="label label-danger">{{number_format($tvShow['popularity'], 1) }}</span></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-7 col-xs-7">
                        <h4>First Air Date: <span class="label label-success">{{$tvShow['first_air_date']}}</span></h4>
                    </div>
                    <div class="col-lg-4 col-md-7 col-xs-7">
                        <h4>Last Air Date: <span class="label label-success">{{$tvShow['last_air_date']}}</span></h4>
                    </div>
                     <div class="col-lg-4 col-md-7 col-xs-7">
                        <h4>Vote Average: <span class="label label-danger">{{$tvShow['vote_average']}}</span></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-10 col-xs-12 col-sm-12">
                <h4>Overview:</h4>

                <div class="well">
                    {{$tvShow['overview']}}
                    <hr />
                    <span>Official Website:<a style="color:blue;" href="{{$tvShow['homepage']}}">{{$tvShow['homepage']}}</a></span>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 col-xs-7">
                <h4>Genres:
                    @if(!empty($tvShow['genres']))
                        @foreach($tvShow['genres'] as $genre)
                            <span class="label label-warning" style="margin-right:5px;">{{$genre['name']}}</span>
                        @endforeach
                </h4>
                @else
                    <span>There are no genres for this movie</span>
                @endif
            </div>
        </div>
        <div class="row" style="margin-top:5px;margin-bottom:10px;padding-top:40px;">
            <div class="col-lg-12">
                <h2 class="page-header">Seasons:</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                @foreach($tvShow['seasons'] as $season)
                <div class="col-lg-3">
                    <?php $imgSrc = (isset($season['poster_path'])) ? 'http://image.tmdb.org/t/p/w500' . $season['poster_path'] : asset('images/no_image.jpg'); ?>
                    <img class="img-responsive imgTv" src="{{$imgSrc}}" title="Season {{$season['season_number']}}"/>
                </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection