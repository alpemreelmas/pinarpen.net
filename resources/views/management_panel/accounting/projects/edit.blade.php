@extends('management_panel.layouts.master')
@section('title','Proje Düzenle')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                <h6 class="m-0 font-weight-bold text-primary">
                    <form action="{{url("/admin/accounting/projects/cancel")}}" method="post" class="p-0 m-0">
                        @csrf
                        <input type="hidden" name="id" value="{{$project->id}}">
                        <button type="subtmit" class="cancelBtn btn btn-outline-danger">İptal Et</button>
                    </form>
                </h6>
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
                <form method="POST" action="{{url("/admin/accounting/projects/$project->id")}}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="costumer_id">Müşteri</label><br/>
                        <span style="font-size: 14px">Lütfen altta çıkan önermeye tıklayarak müşteriyi seçiniz.</span>
                        <input name="customer_id" id="customer_id" class="form-control" type="hidden" value="{{$project->customer_id}}" required>
                        <input id="customer_name" name="customer_name" class="form-control" type="text" value="{{$project->getCustomer->name." ".$project->getCustomer->surname}}" required>
                    </div>

                    <div class="form-group">
                        <label for="costumer_id">Tedarikçi</label><br/>
                        <span style="font-size: 14px">Lütfen altta çıkan önermeye tıklayarak tedarikçiyi seçiniz.</span>
                        <input name="supplier_id" id="supplier_id" class="form-control" type="hidden" value="{{$project->supplier_id}}" required>
                        <input id="supplier_name" name="supplier_name" class="form-control" type="text" value="{{$project->getSupplier->name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="material_type">Materyal Türü</label>
                        <select name="material_type" id="material_type" class="form-control" required>
                            <option value="Cam Balkon" {{ $project->material_type == "Cam Balkon" ? "selected":"" }}>Cam Balkon</option>
                            <option value="Sineklik" {{ $project->material_type == "Sineklik" ? "selected":"" }}>Sineklik</option>
                            <option value="PVC Pencere" {{ $project->material_type == "PVC Pencere" ? "selected":"" }}>PVC Pencere</option>
                            <option value="PVC Kapı" {{ $project->material_type == "PVC Kapı" ? "selected":"" }}>PVC Kapı</option>
                            <option value="Duşakabin" {{ $project->material_type == "Duşakabin" ? "selected":"" }}>Duşakabin</option>
                            <option value="Panjur" {{ $project->materail_type == "Panjur" ? "selected":"" }}>Panjur</option>
                            <option value="Küpeşte" {{ $project->material_type == "Küpeşte" ? "selected":"" }}>Küpeşte</option>
                            <option value="Cam Deliği" {{ old("materail_type") == "Cam Deliği" ? "selected":"" }}>Cam Deliği</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="unit_price_of_material">Ürünün birim fiyatı</label>
                        <input type="number" name="unit_price_of_material" step="0.01" min="0.01" id="unit_price_of_material" class="form-control" required value="{{$project->unit_price_of_material}}">
                    </div>
                    <div class="form-group">
                        <label for="square_meters">Metrekare</label><br/>
                        <input type="number" name="square_meters" id="square_meters" min="0.01" step="0.01" class="form-control" value="{{$project->square_meters}}">
                    </div>
                    <div class="form-group">
                        <label for="expenditure">Masraf</label><br/>
                        <input type="number" id="expenditure" min="0.01" step="0.01" class="form-control" readonly value="{{$project->expenditure}}">
                    </div>
                    <div class="form-group">
                        <label for="earning">Kâr marjı</label><br/>
                        <input type="number" name="earning" id="earning" min="0.01" step="0.01" class="form-control" value="{{$project->earning}}">
                    </div>
                    <div class="form-group">
                        <label for="material_amount">Ürün Adeti</label>
                        <input name="material_amount" type="number" id="material_amount" class="form-control" required value="{{$project->material_amount}}">
                    </div>
                    <div class="form-group">
                        <label for="payment_type">Ödeme Yöntemi</label>
                        <select name="payment_type" id="payment_type" class="form-control" required>
                            <option value="Kredi Kartı" {{ $project->payment_type == "Kredi Kartı" ? "selected":"" }}>Kredi Kartı</option>
                            <option value="Nakit" {{ $project->payment_type == "Nakit" ? "selected":"" }}>Nakit</option>
                            <option value="EFT/HAVALE" {{ $project->payment_type == "EFT/HAVALE" ? "selected":"" }}>EFT/HAVALE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cost">Toplam Ücret</label>
                        <input type="number" id="cost" class="form-control" readonly value="{{$project->cost}}">
                    </div>
                    <div class="form-group">
                        <label for="pay_date">Ödeme Tarihi</label>
                        <select name="pay_date" id="pay_date" class="form-control">
                            @for($i = 1; $i < 30; $i++)
                                <option value="{{$i}}" @if($project->pay_date == $i) selected @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="note">Notlar</label>
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control">{{$project->note}}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Projeyi Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        let form;
        $(".cancelBtn").click(function (e) {
            form = $(this).parents('form');
            e.preventDefault()
            new Swal({
                title: 'Bu projeyi iptal etmek istediğinizden emin misiniz ?',
                text: "Proje iptal edilirse gelir tablosunda gözükmez ve tedarikçi borcu silinmez!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, eminim iptal et.',
                cancelButtonText: 'Hayır, emin değilim iptal etme!',
                confirmButtonClass: 'btn btn-warning',
                cancelButtonClass: 'btn btn-danger',
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit()
                }
            })
        })
    </script>
@endsection



