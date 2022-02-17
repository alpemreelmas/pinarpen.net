@extends('management_panel.layouts.master')
@section('title','Tedarikçi Ekle')
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
                <form method="POST" action="{{url("/admin/accounting/suppliers/")}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tedarikçi Adı</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{old("name")}}">
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
                    <label for="basic-addon1">Tedarikçi Iban</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1" style="border-radius: 0;">TR</span>
                        <input type="number" class="form-control" name="iban" placeholder="Iban" aria-label="basic-addon1" aria-describedby="basic-addon1" value="{{old("iban")}}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Tedarikçi Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



