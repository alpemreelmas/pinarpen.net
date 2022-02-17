@extends('layouts.master')
@section('body-class', 'home')
@section('content')
<style>
    .logo h3, ul li a, .slogan h1, .sliding-services h1 {
        color: white !important;
    }
    @media (max-width: 992px) {
        .open-nav, .close-nav {
            color: white !important;
        }
    }
</style>
<div class="container content-container row-container">
    <div class="content-left">
        <div class="slogan h-100">
            <h1>
                eviniz
            </h1>
            <h1>
                için
            </h1>
            <h1>
                en doğru adım.
            </h1>
        </div>
    </div>
    <div class="content-right">
        <div class="sliding-services">
            <h1>
                cam balkon
            </h1>
            <h1>
                pvc pencere
            </h1>
            <h1>
                pvc kapı
            </h1>
            <h1>
                sineklik
            </h1>
            <h1>
                küpeşte
            </h1>
            <h1>
                cam balkon
            </h1>
        </div>
    </div>
</div>
@endsection