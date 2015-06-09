@if(!$favorites->isEmpty())
    @foreach($favorites as $favorite)
        <div class="col-lg-6">
            <div class=" animated fadeIn">
                <div class="media-left media-top">
                    <a href="{{url('/tv-shows/'.$favorite['id'])}}">
                        <?php $imgSrc = (isset($favorite['backdrop_path'])) ? 'http://image.tmdb.org/t/p/w500' . $favorite['backdrop_path'] : asset('images/no_image.jpg'); ?>
                        <img class="media-object img-responsive" style="max-width:200px;" src="{{$imgSrc}}"
                             alt="{{$favorite['original_title'] or $favorite['original_name']}}">
                    </a>
                </div>
                <div class="media-body">
                    <h3 class="media-heading"><a
                                href="{{url('/tv-shows/'.$favorite['id'])}}">{{$favorite['original_title'] or $favorite['original_name']}}</a>
                    </h3>
                    <?php $text = (isset($favorite['overview'])) ? $favorite['overview'] : $favorite['first_air_date']; ?>
                    <p>{{str_limit($text, 50)}}</p>
                </div>
            </div>
        </div>
    @endforeach
    <div class="favorites-pagination">
        {!! $favorites->render() !!}
    </div>
@else
    <div class="media">
        <div class="media-left media-top text-center">
            <h2>Currently you have no favorites.</h2>
        </div>
    </div>
@endif