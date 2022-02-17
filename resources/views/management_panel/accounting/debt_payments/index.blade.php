@extends('management_panel.layouts.master')
@section('title','Tüm Tedarikçi Ödemeleri')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$debt_payments->count()}} tane müşteri ödemesi bulundu.</h6>
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
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Ödeyen Kişi</th>
                        <th>Ödenen Tutar</th>
                        <th>Tedarikçi</th>
                        <th>Ödeme Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Ödeyen Kişi</th>
                        <th>Ödenen Tutar</th>
                        <th>Tedarikçi</th>
                        <th>Ödeme Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($debt_payments as $debt_payment)
                        <tr>

                            <td>{{$debt_payment->payer_name}} {{$debt_payment->payer_surname}}</td>
                            <td>{{$debt_payment->amount}}</td>
                            <td>{{$debt_payment->getSupplier->getSupplier->name}}</td>
                            <td>{{ \Carbon\Carbon::createFromDate($debt_payment->created_at)->format('d/m/Y')}}</td>
                            <td class="d-flex flex-row justify-content-around">
                                <a title="Delete" class="btn btn-sm btn-danger deleteBtn" delete_id="{{$debt_payment->id}}"><i delete_id="{{$debt_payment->id}}" class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let delete_id;
            $('#table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3]
                        }
                    },
                    {
                        extend:"print",
                        exportOptions: {
                            columns: [ 0, 1, 2,3]
                        }
                    }
                ]
            } );
        } );
        $(".deleteBtn").click(function (e) {
            delete_id = e.target.getAttribute("delete_id");
            new Swal({
                title: 'Bu ödemeyi silmek istediğinizden emin misiniz ?',
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
                    $.ajax({
                        type:"POST",
                        url:"{{url("/admin/accounting/debt-payments/")}}/"+delete_id,
                        data:{
                            "_token":"{{csrf_token()}}",
                            "id":delete_id,
                            "_method":"DELETE"
                        },
                        success:function () {
                            new swal(
                                'Başarılı!',
                                'Ödeme başarılı bir şekilde silindi. Sayfa 3 saniye içinde yenilenecektir.',
                                'success'
                            )
                            setTimeout(function () {
                                location.reload()
                            },3000)
                        }
                    })
                }

            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    new swal(
                        'İptal Edildi',
                        'İşleminiz iptal edildi',
                        'error'
                    )
                }
            })
        })

    </script>
@endsection
