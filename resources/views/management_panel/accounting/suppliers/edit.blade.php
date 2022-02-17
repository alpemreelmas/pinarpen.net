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
                <form method="POST" action="{{url("/admin/accounting/suppliers/$supplier->id")}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="name">Tedarikçi Adı</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{$supplier->name}}">
                    </div>
                    <div class="form-group">
                        <label for="material_type">Materyal Türü</label>
                        <select name="material_type" id="material_type" class="form-control" required>
                            @if($supplier->material_type == "Cam Balkon")
                                <option value="Cam Balkon" selected>Cam Balkon</option>
                                <option value="Sineklik">Sineklik</option>
                                <option value="PVC Pencere">PVC Pencere</option>
                                <option value="PVC Kapı">PVC Kapı</option>
                                <option value="Duşakabin">Duşakabin</option>
                                <option value="Panjur">Panjur</option>
                                <option value="Küpeşte">Küpeşte</option>
                            @elseif($supplier->material_type == "Sineklik")
                                <option value="Cam Balkon">Cam Balkon</option>
                                <option value="Sineklik" selected>Sineklik</option>
                                <option value="PVC Pencere">PVC Pencere</option>
                                <option value="PVC Kapı">PVC Kapı</option>
                                <option value="Duşakabin">Duşakabin</option>
                                <option value="Panjur">Panjur</option>
                                <option value="Küpeşte">Küpeşte</option>
                            @elseif($supplier->material_type == "PVC Pencere")
                                <option value="Cam Balkon">Cam Balkon</option>
                                <option value="Sineklik">Sineklik</option>
                                <option value="PVC Pencere" selected>PVC Pencere</option>
                                <option value="PVC Kapı">PVC Kapı</option>
                                <option value="Duşakabin">Duşakabin</option>
                                <option value="Panjur">Panjur</option>
                                <option value="Küpeşte">Küpeşte</option>
                            @elseif($supplier->material_type == "PVC Kapı")
                                <option value="Cam Balkon">Cam Balkon</option>
                                <option value="Sineklik">Sineklik</option>
                                <option value="PVC Pencere" >PVC Pencere</option>
                                <option value="PVC Kapı" selected>PVC Kapı</option>
                                <option value="Duşakabin">Duşakabin</option>
                                <option value="Panjur">Panjur</option>
                                <option value="Küpeşte">Küpeşte</option>
                            @elseif($supplier->material_type == "Duşakabin")
                                <option value="Cam Balkon">Cam Balkon</option>
                                <option value="Sineklik">Sineklik</option>
                                <option value="PVC Pencere" >PVC Pencere</option>
                                <option value="PVC Kapı" >PVC Kapı</option>
                                <option value="Duşakabin" selected>Duşakabin</option>
                                <option value="Panjur">Panjur</option>
                                <option value="Küpeşte">Küpeşte</option>
                            @elseif($supplier->material_type == "Küpeşte")
                                <option value="Cam Balkon">Cam Balkon</option>
                                <option value="Sineklik">Sineklik</option>
                                <option value="PVC Pencere" >PVC Pencere</option>
                                <option value="PVC Kapı" >PVC Kapı</option>
                                <option value="Duşakabin">Duşakabin</option>
                                <option value="Panjur">Panjur</option>
                                <option value="Küpeşte" selected>Küpeşte</option>
                                @elseif($supplier->material_type == "Panjur")
                                <option value="Cam Balkon">Cam Balkon</option>
                                <option value="Sineklik">Sineklik</option>
                                <option value="PVC Pencere" >PVC Pencere</option>
                                <option value="PVC Kapı" >PVC Kapı</option>
                                <option value="Duşakabin">Duşakabin</option>
                                <option value="Panjur" selected>Panjur</option>
                                <option value="Küpeşte">Küpeşte</option>
                            @endif
                

                        </select>
                    </div>
                    <label for="basic-addon1">Tedarikçi Iban</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1" style="border-radius: 0;">TR</span>
                        <input type="number" class="form-control" name="iban" placeholder="Iban" aria-label="basic-addon1" aria-describedby="basic-addon1" value="{{$supplier->iban}}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Tedarikçi Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



