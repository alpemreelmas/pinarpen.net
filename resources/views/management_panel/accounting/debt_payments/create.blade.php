@extends('management_panel.layouts.master')
@section('title','Tedarikçi Borcu Öde')
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
                <form method="POST" action="{{url("/admin/accounting/debt-payments/")}}">
                    @csrf
                    <div class="form-group">
                        <label for="payer_name">Ödeyen Adı</label><br/>
                        <input id="payer_name" name="payer_name" class="form-control" type="text" value="{{old("payer_name")}}" required>
                        <input name="debt_id" class="form-control" type="hidden" value="{{$debt->id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="payer_surname">Ödeyen Soyadı</label><br/>
                        <input id="payer_surname" name="payer_surname" class="form-control" type="text" value="{{old("payer_surname")}}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Ödeme Miktarı</label><br/>
                        <input id="amount" name="amount" class="form-control" type="number" step="0.01" min="0.01" value="{{old("amount")}}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Ödeme Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



