@extends('management_panel.layouts.master')
@section('title',__("customer.add_customer"))
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
                <form method="POST" action="{{url("/admin/accounting/customers/")}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{__("customer.name")}}</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{old("name")}}">
                    </div>
                    <div class="form-group">
                        <label for="surname">{{__("customer.surname")}}</label>
                        <input type="text" name="surname" id="surname" class="form-control" required
                               value="{{old("surname")}}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">{{__("customer.phone_number")}}</label><br/>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control"
                               value="{{old("phone_number")}}">
                    </div>
                    <div class="form-group">
                        <label for="address">{{__("customer.address")}}</label>
                        <textarea name="address" class="form-control">{{old("address")}}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{__("customer.add_customer")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
