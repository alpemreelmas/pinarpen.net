@extends('management_panel.layouts.master')
@section('title','Tedarikçi Borcu Ekle')
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
                <form method="POST" action="{{url("/admin/accounting/debts/collective-pay")}}">
                    @csrf
                    <div class="form-group">
                        <label for="supplier_id" >Tedarikçi Seçiniz</label>
                        <select name="supplier_id" class="form-control">
                            @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" @if(old("supplier_id") == $supplier->id) selected @endif>{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Ödeme Miktarı Giriniz.( Ödeyebileceğiniz maksimum tutar {{ $max_debt }} TL kadardır. ) </label>
                        <input type="number" name="amount" min="1" id="amount" class="form-control" required value="{{old("amount")}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Toplu Tedarikçi Borcu Öde</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



