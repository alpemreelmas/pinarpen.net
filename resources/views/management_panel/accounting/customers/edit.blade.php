@extends('management_panel.layouts.master')
@section('title',$customer->name.' adlı müşteri bilgilerini düzenle')
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
                <form method="POST" action="{{url("/admin/accounting/customers/$customer->id")}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="name">Müşteri Adı</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{$customer->name}}">
                    </div>
                    <div class="form-group">
                        <label for="surname">Müşteri Soyadı</label>
                        <input type="text" name="surname" id="surname" class="form-control" required value="{{$customer->surname}}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Müşteri İletişim Numarası</label><br/>
                        <span style="font-size: 14px">Lütfen numarayı 0543 999 99 99 şeklinde boşluklu ve sıfırlı yazınız.</span>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control" pattern="[0-9]{4} [0-9]{3} [0-9]{2} [0-9]{2}"  value="{{$customer->phone_number}}">
                    </div>
                    <div class="form-group">
                        <label for="address">Müşteri Adresi</label>
                        <textarea name="address" class="form-control">@if($customer->address !== null){{$customer->address}}@endif</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Müşteriyi Düzenle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



