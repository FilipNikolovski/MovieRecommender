@extends('layout')
@section('content')
    <div class="container">
        <div style="margin-top:60px;">
            <div class="row text-center">
                <div class="col-lg-12">
                    <?php $imgSrc = (isset($account['avatar']['gravatar'])) ? 'http://www.gravatar.com/avatar/' . $account['avatar']['gravatar']['hash'] : asset('/images/default_profile_picture.png'); ?>
                    <img src="{{$imgSrc}}" class="img-responsive" style="margin: 0 auto;">
                </div>
                <div class="col-lg-12" style="font-size:20px;">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    <label>{{$account['username']}}</label>
                </div>
                <input type="hidden" value="{{json_encode($movieIds)}}" id="movie-ids">
            </div>

            <div class="row" style="margin-top: 30px;">
                <div class="col-lg-12 text-center">
                    <ul class="nav nav-pills" style="display: inline-block">
                        <li role="presentation" class="<?php echo ($activeTab == 'movies') ? 'active' : NULL; ?>"><a
                                    href="{{url('/account')}}">Movies</a></li>
                        <li role="presentation" class="<?php echo ($activeTab == 'tv-shows') ? 'active' : NULL; ?>"><a
                                    href="{{url('/account/tv-shows')}}">Tv Shows</a></li>
                    </ul>
                </div>
            </div>

            <?php $tab = ($activeTab == 'movies') ? 'Movies' : 'Tv Shows'; ?>
            <div class="jumbotron row" style="margin-top:20px">
                <h3><span class="label label-default">Favorite {{$tab}}</span></h3>

                <div id="favorites-list">
                    @include('partials.account.favorites')
                </div>
            </div>

            <div class="jumbotron row">

                <h3><span class="label label-default">{{$tab}} on your watchlist</span></h3>

                <div id="watchlist-list">
                    @include('partials.account.watchlist')
                </div>
            </div>

            @if($activeTab == 'movies')
                <div class="jumbotron">

                    <h3><span class="label label-default">Recommended Movies</span></h3>

                    <div id="recommended-list" class="grid">
                        <div class="grid-sizer"></div>
                    </div>

                    <div class=" row text-center">
                        <div class="col-lg-12">
                            <h3><a href="javascript:void(0)" id="load-more">Load more</a></h3>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection