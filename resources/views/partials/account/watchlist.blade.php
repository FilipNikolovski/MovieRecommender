@if(!$watchlist->isEmpty())
    @foreach($watchlist as $movie)
        <div class="col-lg-6">
            <div class="media animated fadeIn">
                <div class="media-left media-top">
                    <a href="{{url('/tv-shows/'.$movie['id'])}}">
                        <?php $imgSrc = (isset($movie['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500' . $movie['backdrop_path'] : asset('images/no_image.jpg'); ?>
                        <img class="media-object img-responsive" style="max-width:200px;" src="{{$imgSrc}}"
                             alt="{{$movie['original_title'] or $movie['original_name']}}">
                    </a>
                </div>
                <div class="media-body">
                    <h3 class="media-heading"><a
                                href="{{url('/tv-shows/'.$movie['id'])}}">{{$movie['original_title'] or $movie['original_name']}}</a>
                    </h3>

                    <?php $text = (isset($movie['overview'])) ? $movie['overview'] : $movie['first_air_date']; ?>
                    <p>{{str_limit($text, 50)}}</p>
                </div>
            </div>
        </div>
    @endforeach
    <div class="watchlist-pagination">
        {!! $watchlist->render() !!}
    </div>
@else
    <div class="media">
        <div class="media-left media-top text-center">
            <h2>Currently you have nothing on your watchlist.</h2>
        </div>
    </div>
@endif