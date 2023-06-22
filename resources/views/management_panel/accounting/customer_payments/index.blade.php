@extends('management_panel.layouts.master')
@section('title',__("customer.all_customer_pay_title"))
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$customer_payments->count()}} {{__("customer.customer_payments_found")}}</h6>
        </div>
        <div class="card-body">
            <x-flash-messages />
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{__("customer.name")}}</th>
                        <th>{{__("customer.type_of_material")}}</th>
                        <th>{{__("customer.paid_amount")}}</th>
                        <th>{{__("customer.payer_name")}}</th>
                        <th>{{__("customer.payment_date")}}</th>
                        <th>{{__("customer.transactions")}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{__("customer.name")}}</th>
                        <th>{{__("customer.type_of_material")}}</th>
                        <th>{{__("customer.paid_amount")}}</th>
                        <th>{{__("customer.payer_name")}}</th>
                        <th>{{__("customer.payment_date")}}</th>
                        <th>{{__("customer.transactions")}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($customer_payments as $customer_payment)
                        <tr>
                            <td>{{$customer_payment->getProject->getCustomer->name}} {{$customer_payment->getProject->getCustomer->surname}}</td>
                            <td>{{$customer_payment->getProject->material_type}}</td>
                            <td>{{$customer_payment->amount}}</td>
                            <td>{{$customer_payment->payer}}</td>
                            <td>{{\Carbon\Carbon::createFromDate($customer_payment->created_at)->format('d/m/Y')}}</td>
                            <td class="d-flex flex-row justify-content-around">
                                <a title="Delete" class="btn btn-sm btn-danger deleteBtn" delete_id="{{$customer_payment->id}}"><i delete_id="{{$customer_payment->id}}" class="fa fa-times"></i></a>
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
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/{{$app->getLocale() == "en" ? 'English' : 'Turkish'}}.json"
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4]
                        }
                    },
                    {
                        extend:"print",
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4]
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
                        url:"{{url("/admin/accounting/projects/$customer_payment->project_id/customer-payments/")}}/"+delete_id,
                        data:{
                            "_token":"{{csrf_token()}}",
                            "id":delete_id,
                            "_method":"DELETE"
                        },
                        success:function () {
                            location.reload()
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
