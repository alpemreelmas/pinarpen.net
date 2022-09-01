@extends('management_panel.layouts.master')
@section('title','Tedarikçi Borçları')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$debts->count()}} tane borç bulundu.</h6>
            <h6 class="m-0 font-weight-bold @if($all_debt == 0) text-success @else text-warning @endif"> @if($all_debt == 0) Borcunuz yoktur. @else Tüm Borçlar {{$all_debt}}TL kadardır. @endif</h6>
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
            <a href="{{url("/admin/accounting/debts/collective-pay")}}" class="btn btn-info float-right mb-4">Toplu Öde</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Tedarikçi Adı</th>
                        <th>Materyal Türü</th>
                        <th>Birim Fiyat</th>
                        <th>Metrekare</th>
                        <th>Adet</th>
                        <th>Ödenen Borç</th>
                        <th>Ödenmesi Gereken Borç</th>
                        <th>Toplam</th>
                        <th>Kayıt Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Tedarikçi Adı</th>
                        <th>Materyal Türü</th>
                        <th>Birim Fiyat</th>
                        <th>Metrekare</th>
                        <th>Adet</th>
                        <th>Ödenen Borç</th>
                        <th>Ödenmesi Gereken Borç</th>
                        <th>Toplam</th>
                        <th>Kayıt Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>Toplam Borç</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{$all_debt}}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @foreach($debts as $debt)
                        <tr @if($debt->pending_payment == 0)style="background: #1cc88a; color:white"@endif>
                            <td>{{$debt->getSupplier->name}}</td>
                            <td>{{$debt->material_type}}</td>
                            <td>{{$debt->unit_price_of_material}}</td>
                            <td>{{$debt->square_meters}}</td>
                            <td>{{$debt->material_amount}}</td>
                            <td>{{$debt->paid_payment}}</td>
                            <td>{{$debt->pending_payment}}</td>
                            <td>{{$debt->cost}}</td>
                            <td>{{\Carbon\Carbon::createFromDate($debt->created_at)->format('d/m/Y')}}</td>
                            <td class="d-flex flex-row justify-content-around">
                                @if($debt->pending_payment !== 0) <a href="{{url("/admin/accounting/debt-payments/$debt->id/create")}}" title="Pay" class="btn btn-sm btn-warning"><i class="fas fa-money-bill-wave"></i></a>@endif
                                @if($debt->project_id == null and $debt->paid_payment == 0) <a href="{{url("/admin/accounting/debts/$debt->id/edit")}}" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>@endif
                                @if($debt->project_id == null and $debt->pending_payment == $debt->cost)
                                        <form action="{{url("/admin/accounting/debts/$debt->id/")}}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input type="hidden" value="{{$debt->id}}">
                                            <button class="btn btn-sm btn-danger deleteBtn" title="Delete" type="submit"><i class="fa fa-times"></i></button>
                                        </form>
                                    @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7 ]
                        }
                    },
                    {
                        extend:"print",
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6,7 ]
                        },
                        customize: function (win) {
                            $(win.document.body)
                                .prepend(
                                    '<img src="{{asset("img/pinarpen.png")}}" width="80%" style="opacity:0.1; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"/>'
                                );
                        }
                    }
                ]
            } );

            let form;
            $(".deleteBtn").click(function (e) {
                form = $(this).parents('form');
                e.preventDefault()
                new Swal({
                    title: 'Bu borcu silmek istediğinizden emin misiniz ?',
                    text: "Borcu silinirse projeye dair yapılan ödeme vb her şey silinecektir. Bu silinme geri alınamaz!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, eminim sil.',
                    cancelButtonText: 'Hayır, emin değilim silme!',
                    confirmButtonClass: 'btn btn-warning',
                    cancelButtonClass: 'btn btn-danger',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
            })
        } );
    </script>
@endsection
