@extends('layout')
@section('content')
    <div class="row form-group" style="margin-top:70px;">
        <form id="searchForm" action="{{action('MoviesController@getSearch')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="col-lg-4 col-md-3 col-sm-5 col-xs-11 col-lg-offset-3" style="margin-bottom:10px;">
                <input type="text" class="form-control" name="search" placeholder="Search for movies.." required
                       minlength="2"></div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-11">
                <button type="submit" class="btn btn-success btn-block">Search</button>
            </div>
        </form>
    </div>
    <div class="row hide" id="search-list"></div>
    <div id="loadImages" class="hide"></div>
@endsection