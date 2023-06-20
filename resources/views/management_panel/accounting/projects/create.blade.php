@extends('management_panel.layouts.master')
@section('title','Proje Ekle')
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
                <form method="POST" action="{{url("/admin/accounting/projects")}}">
                    @csrf
                    <div class="form-group">
                        <label for="costumer_id">Müşteri</label><br/>
                        <span style="font-size: 14px">Lütfen altta çıkan önermeye tıklayarak müşteriyi seçiniz.</span>
                        <input name="customer_id" id="customer_id" class="form-control" type="hidden" value="{{old("customer_id")}}" required>
                        <input id="customer_name" name="customer_name" class="form-control" type="text" value="{{old("customer_name")}}" required>
                    </div>

                    <div class="form-group">
                        <label for="costumer_id">Tedarikçi</label><br/>
                        <span style="font-size: 14px">Lütfen altta çıkan önermeye tıklayarak tedarikçiyi seçiniz.</span>
                        <input name="supplier_id" id="supplier_id" class="form-control" type="hidden" value="{{old("supplier_id")}}" required>
                        <input id="supplier_name" name="supplier_name" class="form-control" type="text" value="{{old("supplier_name")}}" required>
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
                            <option value="Cam Deliği" {{ old("materail_type") == "Cam Deliği" ? "selected":"" }}>Cam Deliği</option>
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
                        <label for="expenditure">Masraf</label><br/>
                        <input type="number" id="expenditure" min="0.01" step="0.01" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="earning">Kâr marjı</label><br/>
                        <input type="number" name="earning" id="earning" min="0.01" step="0.01" class="form-control" value="{{old("earning")}}">
                    </div>
                    <div class="form-group">
                        <label for="material_amount">Ürün Adeti</label>
                        <input name="material_amount" type="number" id="material_amount" class="form-control" required value="{{old("material_amount")}}">
                    </div>
                    <div class="form-group">
                        <label for="payment_type">Ödeme Yöntemi</label>
                        <select name="payment_type" id="payment_type" class="form-control" required>
                            <option value="Kredi Kartı" {{ old("payment_type") == "Kredi Kartı" ? "selected":"" }}>Kredi Kartı</option>
                            <option value="Nakit" {{ old("payment_type") == "Nakit" ? "selected":"" }}>Nakit</option>
                            <option value="EFT/HAVALE" {{ old("payment_type") == "EFT/HAVALE" ? "selected":"" }}>EFT/HAVALE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cost">Toplam Ücret</label>
                        <input type="number" id="cost" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pay_date">Ödeme Tarihi</label>
                        <select name="pay_date" id="pay_date" class="form-control">
                            @for($i = 1; $i < 30; $i++)
                                <option value="{{$i}}" @if(old("pay_date") == $i) selected @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_stock">Malzemeler Stoktan Mı Karşılanıcak ?</label>
                        <select name="is_stock" id="is_stock" class="form-control">
                                <option value="false" @if(old("is_stock") == "false") selected @endif>Hayır</option>
                                <option value="true" @if(old("is_stock") == "true") selected @endif>Evet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="note">Notlar</label>
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Proje Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script>
        $(function() {
            var availableCustomers =  {!! json_encode($customers->toArray()) !!}
            $( "#customer_name" ).autocomplete({
                source: function (request,response) {
                    response($.map(availableCustomers,function (item) {
                        if(item.value.match("^"+request.term,"i")){
                            return {
                                id:item.id,
                                value: item.value
                            }
                        }else{
                            return null
                        }

                    }))
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value)
                    $("#customer_id").val(ui.item.id)
                }
            });

            var availableSuppliers =  {!! json_encode($suppliers->toArray()) !!}
            $( "#supplier_name" ).autocomplete({
                source: function (request,response) {
                    response($.map(availableSuppliers,function (item) {
                        if(item.value.match("^"+request.term,"i")){
                            return {
                                id:item.id,
                                value: item.value
                            }
                        }else{
                            return null
                        }

                    }))
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value)
                    $("#supplier_id").val(ui.item.id)
                }
            });

            $("#unit_price_of_material").keyup(function(){
                checkAllNumber()
            })

            $("#square_meters").keyup(function(){
                checkAllNumber()
            })

            $("#earning").keyup(function () {
                checkAllNumber()
            });

            $("#material_amount").keyup(function(){
                checkAllNumber()
            })

            function checkAllNumber(){
                var expenditure;
                var earning = Number($("#earning").val())
                var unit_price_of_material = Number($("#unit_price_of_material").val());
                var square_meters = Number($("#square_meters").val())
                var material_amount = Number($("#material_amount").val())

                if(material_amount <= 0 || isNaN(material_amount)){
                    material_amount = 1
                }

                $("#expenditure").val(((unit_price_of_material*square_meters)*material_amount).toFixed(2));
                expenditure = Number($("#expenditure").val())

                var cost = (expenditure+earning).toFixed(2)

                $("#cost").val(cost)
            }

        } );
    </script>
@endsection



