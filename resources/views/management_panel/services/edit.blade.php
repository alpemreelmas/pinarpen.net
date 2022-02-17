@extends('management_panel.layouts.master')
@section('title',$service->name." Service")
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </div>
                @endif
                @if(Session::get("success"))
                    <div class="alert alert-success">
                        {{Session::get("success")}}
                    </div>
                @endif
                <form method="POST" action="{{url("/admin/services/$service->id")}}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="image">Service Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Service Name</label>
                        <input type="text" name="name" id="title" class="form-control" required value="{{$service->name}}">
                    </div>
                    <div class="form-group">
                        <label for="title">Service Spec</label>
                        <input type="text" name="spec" id="spec" class="form-control" required value="{{$service->spec}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Edit Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
