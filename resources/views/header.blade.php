<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">Movie Recommender</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{url('/movies')}}">Movies</a>
                </li>
                <li>
                    <a href="{{url('/tv-shows')}}">TV Shows</a>
                </li>
                <li>
                    <a href="{{url('/search')}}">Search</a>
                </li>
                @if(empty($username))
                    <li>
                        <a href="#" data-target="#loginModal" data-toggle="modal" >Login</a>
                    </li>
                    <li>
                        <a href="https://www.themoviedb.org/account/signup" target="_blank">Register</a>
                    </li>
                @else
                    <li>
                        <a href="{{url('/account')}}">Account</a>
                    </li>
                @endif

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>