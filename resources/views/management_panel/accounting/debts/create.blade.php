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
                <form method="POST" action="{{url("/admin/accounting/debts/")}}">
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
                        <label for="material_type">Materyal Türü</label>
                        <select name="material_type" id="material_type" class="form-control" required>
                            <option value="Cam Balkon" {{ old("materail_type") == "Cam Balkon" ? "selected":"" }}>Cam Balkon</option>
                            <option value="Sineklik" {{ old("materail_type") == "Sineklik" ? "selected":"" }}>Sineklik</option>
                            <option value="PVC Pencere" {{ old("materail_type") == "PVC Pencere" ? "selected":"" }}>PVC Pencere</option>
                            <option value="PVC Kapı" {{ old("materail_type") == "PVC Kapı" ? "selected":"" }}>PVC Kapı</option>
                            <option value="Duşakabin" {{ old("materail_type") == "Duşakabin" ? "selected":"" }}>Duşakabin</option>
                            <option value="Panjur" {{ old("materail_type") == "Panjur" ? "selected":"" }}>Panjur</option>
                            <option value="Küpeşte" {{ old("materail_type") == "Küpeşte" ? "selected":"" }}>Küpeşte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="unit_price_of_material">Ürünün birim fiyatı</label>
                        <input type="number" name="unit_price_of_material" step="0.01" min="0.01" id="unit_price_of_material" class="form-control" required value="{{old("unit_price_of_material")}}">
                    </div>
                    <div class="form-group">
                        <label for="square_meters">Metrekare</label><br/>
                        <input type="number" name="square_meters" id="square_meters" min="0.01" step="0.01" class="form-control" value="{{old("square_meters")}}">
                    </div>
                    <div class="form-group">
                        <label for="material_amount">Ürün Adeti</label><br/>
                        <input type="number" name="material_amount" id="material_amount" min="1" step="1" class="form-control" value="{{old("material_amount")}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Tedarikçi Borcu Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



