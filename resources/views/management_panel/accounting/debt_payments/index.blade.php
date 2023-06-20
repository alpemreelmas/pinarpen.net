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
                        <th>{{__("customer.payer_name")}}</th>
                        <th>{{__("customer.payment_amount")}}</th>
                        <th>{{__("suppliers.supplier")}}</th>
                        <th>{{__("customer.payment_date")}}</th>
                        <th>{{__("general.operations")}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{__("customer.payer_name")}}</th>
                        <th>{{__("customer.payment_amount")}}</th>
                        <th>{{__("suppliers.supplier")}}</th>
                        <th>{{__("customer.payment_date")}}</th>
                        <th>{{__("general.operations")}}</th>
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
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/English.json"
                },
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
        } );
        $(".deleteBtn").click(function (e) {
            delete_id = e.target.getAttribute("delete_id");
            new Swal({
                title: '{{__("customer.confirm_deletion")}}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{__("customer.yes_delete")}}',
                cancelButtonText: '{{__("customer.no_do_not_delete")}}',
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
                                '{{__("general.successful")}}',
                                '{{__("general.will_be_refresh")}}',
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
                        '{{__("customer.canceled")}}',
                        '{{__("customer.operation_canceled")}}',
                        '{{__("customer.error")}}'
                    )
                }
            })
        })

    </script>
@endsection
