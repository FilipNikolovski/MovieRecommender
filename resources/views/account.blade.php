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
            <div class="col-lg-12">
                <a href="{{url('auth/logout')}}">Logout</a>
            </div>
        </div>

        <div class="jumbotron" style="margin-top:20px">

            <h3><span class="label label-default">Favorite Movies</span></h3>

            <div class="media">
                <div class="media-left media-top">
                    <a href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Example</h4>

                    <p>Lalala</p>
                </div>
            </div>

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

        </div>

        <div class="jumbotron">

            <h3><span class="label label-default">Movies on your watchlist</span></h3>

            <div class="media">
                <div class="media-left media-top">
                    <a href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Example</h4>

                    <p>Lalala</p>
                </div>
            </div>

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
        </div>

        <div class="jumbotron">

            <h3><span class="label label-default">Recommended Movies</span></h3>

            <div class="media">
                <div class="media-left media-top">
                    <a href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Example</h4>

                    <p>Lalala</p>
                </div>
            </div>

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
        </div>
    </div>
</div>
@endsection