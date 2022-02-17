@extends('management_panel.layouts.master')
@section('title','Create Portfolio')
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
                <form method="POST" action="{{url("/admin/portfolios/")}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image">Portfolyo Resmi</label>
                        <input type="file" name="title_image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Portfolyo İsmi</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Portfolyo İçeriği</label>
                        <input type="text" name="content" id="spec" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Portfolyo Açıklama (SEO için)</label>
                        <textarea type="file" name="descriptions" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Portfolyo Resimleri</label>
                        <input type="file" name="images[]" id="image" class="form-control" multiple>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Portfolyo Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section("js")
    <script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script>
        //CKEDITOR.replace( "spec");
    </script>
@endsection
