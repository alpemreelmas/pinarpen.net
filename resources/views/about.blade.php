@extends('layouts.master')
@section('body-class', 'about')
@section('content')
<div class="container content-container">
        <div class="content-title">
            <h2>hakkımızda</h2>
        </div>
        <!-- Buraya hakkımızda yazısı gelecek -->
        <div class="content about-content">
            <div class="content-left">
                <p></p>
            </div>
            <div class="content-right">
                <img src="{{asset('img/about-background.jpg')}}" alt="">
            </div>
        </div>

</div>
@endsection
