@extends('layouts.master')
@section('body-class', 'works')
@section('content')
<style>
html {
    height: auto;
}
</style>
<div class="container d-flex flex-column">
    <div class="content-title">
        <h2>yaptıklarımız</h2>
    </div>
    <div class="content works-content">
        @foreach($portfolios as $portfolio)
        <div class="works-item">
                <img src="{{ asset("img/portfolios/".$portfolio->title_image) }}" alt="">
                <div class="works-item-desc">
                    <a style="color: #000 !important;" href="{{url("portfolios/$portfolio->slug/$portfolio->id")}}">{{$portfolio->title}}</a>
                    <p>{{ $portfolio->content }}</p>
                </div>
        </div>
        @endforeach
    </div>
</div>
@endsection