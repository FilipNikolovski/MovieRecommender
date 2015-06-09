@if(!empty($movies['results']))
    @foreach($movies['results'] as $movie)
        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-10 search-item animated fadeInUp">
            <?php $imgSrc = (isset($movie['poster_path'])) ? 'http://image.tmdb.org/t/p/w500' . $movie['poster_path'] : asset('images/no_image.jpg'); ?>
            <a style="height:300px;" class="thumbnail" href="{{url('/movies/'.$movie['id'])}}"><img
                        style="max-height:100%;" src="{{$imgSrc}}" alt="{{$movie['original_title']}}"/></a>
        </div>
    @endforeach
@else
    <div class="row hide">
        <h2 class="col-md-6 col-centered">The search is empty</h2>
    </div>
@endif