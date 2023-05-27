@extends('management_panel.layouts.master')
@section('title',__("customer.you_are_editing_customer",["name"=>$customer->name]))
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <x-flash-messages />
                <form method="POST" action="{{url("/admin/accounting/customers/$customer->id")}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="name">{{__("customer.name")}}</label>
                        <input type="text" name="name" id="name" class="form-control" required
                               value="{{$customer->name}}">
                    </div>
                    <div class="form-group">
                        <label for="surname">{{__("customer.surname")}}</label>
                        <input type="text" name="surname" id="surname" class="form-control" required
                               value="{{$customer->surname}}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">{{__("customer.phone_number")}}</label><br/>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control"
                               value="{{$customer->phone_number}}">
                    </div>
                    <div class="form-group">
                        <label for="address">{{__("customer.address")}}</label>
                        <textarea name="address" class="form-control">@if($customer->address !== null)
                                {{$customer->address}}
                            @endif</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit"
                                class="btn btn-primary btn-block">{{__("customer.edit_customer")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
