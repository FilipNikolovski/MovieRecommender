@extends('layout')
@section('content')
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome To Our Movie Recommender!</div>
                <form action="{{action('MoviesController@getSearch')}}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Movies..." required>
                </form>
            </div>
        </div>
    </header>

    <section id="portfolio" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Movies</h2>
                    <h3 class="section-subheading text-muted">Upcoming Movies</h3>
                </div>
            </div>
            <div class="row">
                @foreach($randomMovies as $movie)
                    <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="{{url('/movies/'.$movie['id'])}}" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?php $posterPath = (isset($movie['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500'.$movie['backdrop_path'] : asset('images/no_image.jpg'); ?>
                        <img src="{{$posterPath}}" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>{{$movie['original_title']}}</h4>
                        <p class="text-muted">{{str_limit($movie['overview'], 100)}} <a href="{{url('/movies/'.$movie['id'])}}">More</a></p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="portfolio" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">TV Shows</h2>
                    <h3 class="section-subheading text-muted">On The Air TV-shows</h3>
                </div>
            </div>
            <div class="row">
                @foreach($randomTv as $tvShow)
                    <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?php $posterPath = (isset($tvShow['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500'.$tvShow['backdrop_path'] : asset('images/no_image.jpg'); ?>
                        <img src="{{$posterPath}}" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>{{$tvShow['original_name']}}</h4>
                        <p class="text-muted">{{$tvShow['first_air_date']}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection