@extends('layouts.master')
@section('body-class', 'services')
@section('content')
<div class="container d-flex flex-column">
    <div class="content-title">
        <h2>hizmetler</h2>
    </div>
    <div class="content services-content">
        <!-- Buraya hizmetler gelecek -->


        @foreach($services as $service)
            <div class="service-item">
                <img src="{{asset("img/services/".$service->image)}}">
                <div class="inner-shadow">
                    <h3>{{$service->name}}</h3>
                </div>
                <div class="service-hover-specs">
                    <ul>
                        <!-- Buraya hizmetin özellikleri gelecek -->
                        <li>
                            <h5>{{$service->spec}}</h5>
                        </li>
                    </ul>        
                </div>
            </div>
        @endforeach



        
        
    </div>
</div>
@endsection