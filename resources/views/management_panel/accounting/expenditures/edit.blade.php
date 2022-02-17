@extends('management_panel.layouts.master')
@section('title','Gider Güncelle')
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
                <form method="POST" action="{{url("/admin/accounting/expenditures/$expenditure->id")}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="name">Gider Adı*</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{$expenditure->name}}">
                        <input type="hidden" name="id" id="id" class="form-control" required value="{{$expenditure->id}}">
                    </div>
                    <div class="form-group">
                        <label for="amount">Miktar*</label>
                        <input type="number" step="0.01" min="0" name="amount" id="amount" class="form-control" required value="{{$expenditure->amount}}">
                    </div>
                    <div class="form-group">
                        <label for="amount">Detay</label>
                        <textarea class="form-control" name="detail" cols="30" rows="10">@if($expenditure->detail !== null){{$expenditure->detail}}@endif</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Gider Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



