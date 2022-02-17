@extends('layouts.master')
@section('body-class', 'works')
@section('content')
<div class="container d-flex flex-column">
    <div class="content-title">
        <h2>{{$portfolio->title}}</h2>
    </div>
    <div class="content works-content">
        <div class="single-works-item">
            <div class="works-photos">
                <div id="carouselExampleIndicators" class="carousel slide w-100" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @if($portfolio->getGallery->count() > 0)<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button> @endif
                            @for($i = 1; $i <= $portfolio->getGallery->count(); $i++)
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i + 1}}"></button>
                            @endfor
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{asset("img/portfolios/".$portfolio->title_image)}}" alt="fotoğraf">
                        </div>
                        @foreach($portfolio->getGallery as $image)
                            <div class="carousel-item">
                                <img src="{{asset("img/portfolios/".$image->url)}}" class="d-block w-100" alt="fotoğraf">
                            </div>
                        @endforeach
                    </div>
                    @if($portfolio->getGallery->count() > 0)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Önceki</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sonraki</span>
                        </button>
                    @endif
                </div>
            </div>
            <div class="works-desc">
                <p>{{$portfolio->content}}</p>
            </div>
        </div>

    </div>
</div>
@endsection