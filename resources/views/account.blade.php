@extends('layout')
@section('content')
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
            <div class="col-lg-12">
                <a href="{{url('auth/logout')}}">Logout</a>
            </div>
            <input type="hidden" value="{{json_encode($movieIds)}}" id="movie-ids">
        </div>

        <div class="jumbotron" style="margin-top:20px">
            <h3><span class="label label-default">Favorite Movies</span></h3>

            @if(!empty($favorites['results']))
                @foreach($favorites['results'] as $favorite)
                    <div class="media">
                        <div class="media-left media-top">
                            <a href="{{url('/movies/'.$favorite['id'])}}">
                                <?php $imgSrc = (isset($favorite['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500' . $favorite['backdrop_path'] : asset('images/no_image.jpg'); ?>
                                <img class="media-object img-responsive" style="max-width:200px;" src="{{$imgSrc}}"
                                     alt="{{$favorite['original_title']}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading"><a
                                        href="{{url('/movies/'.$favorite['id'])}}">{{$favorite['original_title']}}</a>
                            </h3>

                            <p>{{str_limit($favorite['overview'], 100)}}</p>
                        </div>
                    </div>
                @endforeach
                <nav>
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @else
                <div class="media">
                    <div class="media-left media-top text-center">
                        <h2>Currently you have no favorite movies.</h2>
                    </div>
                </div>
            @endif
        </div>

        <div class="jumbotron">

            <h3><span class="label label-default">Movies on your watchlist</span></h3>

            @if(!empty($watchlist['results']))
                @foreach($watchlist['results'] as $movie)
                    <div class="media">
                        <div class="media-left media-top">
                            <a href="{{url('/movies/'.$movie['id'])}}">
                                <?php $imgSrc = (isset($movie['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500' . $movie['backdrop_path'] : asset('images/no_image.jpg'); ?>
                                <img class="media-object img-responsive" style="max-width:200px;" src="{{$imgSrc}}"
                                     alt="{{$movie['original_title']}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading"><a
                                        href="{{url('/movies/'.$movie['id'])}}">{{$movie['original_title']}}</a>
                            </h3>

                            <p>{{str_limit($movie['overview'], 100)}}</p>
                        </div>
                    </div>
                @endforeach
                <nav>
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @else
                <div class="media">
                    <div class="media-left media-top text-center">
                        <h2>Currently you have no favorite movies.</h2>
                    </div>
                </div>
            @endif
        </div>

        <div class="jumbotron">

            <h3><span class="label label-default">Recommended Movies</span></h3>

            <div id="recommended-list" class="grid">
            </div>

            <div class=" row text-center">
                <div class="col-lg-12">
                    <h3><a href="javascript:void(0)" id="load-more">Load more</a> </h3>
                </div>
            </div>
        </div>
    </div>
@endsection