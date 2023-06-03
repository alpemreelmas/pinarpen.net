@extends('management_panel.layouts.master')
@section('title',__("customer.inspect_customer"))
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{__("customer.inspect_customer_activity",["name"=>$customer->full_name])}}</h6>
        </div>
        <div class="card-body">
            <x-flash-messages />
            <div class="row">
                <div class="table-responsive col-md-12">
                    <div class="m-4">
                        <h4 class="small font-weight-bold">{{__("customer.all_debt_to_us")}}<span class="float-right">@if($all_debt == 0){{__("general.complete")}}@else
                                    @if($all_debt == 0) 0 @else {{(int)(($paid_payment*100)/$all_debt)}} %@endif @endif</span></h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width:  @if($all_debt == 0) 100% @else {{(int)(($paid_payment*100)/$all_debt)}}% @endif" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <hr class="mt-2">
                    <ul class="nav nav-pills m-2" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Projeleri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Ödeme Geçmişi</a>
                        </li>
                    </ul>
                    <hr class="mb-3">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <table class="table table-bordered" id="ProjectTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <td>{{__("customer.type_of_material")}}</td>
                                    <td>{{__("customer.paid_amount")}}</td>
                                    <td>{{__("customer.must_to_be_paid")}}</td>
                                    <td>{{__("customer.billing_date")}}</td>
                                    <td>{{__("customer.type_of_payment")}}</td>
                                    <td>{{__("customer.start_date_of_project")}}</td>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <td>{{__("customer.type_of_material")}}</td>
                                    <td>{{__("customer.paid_amount")}}</td>
                                    <td>{{__("customer.must_to_be_paid")}}</td>
                                    <td>{{__("customer.billing_date")}}</td>
                                    <td>{{__("customer.type_of_payment")}}</td>
                                    <td>{{__("customer.start_date_of_project")}}</td>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($customer->getProjects as $project)
                                    <tr>
                                        <td>{{$project->material_type}}</td>
                                        <td>{{$project->paid_payment}}</td>
                                        <td>{{$project->pending_payment}}</td>
                                        <td>{{$project->pay_date}}</td>
                                        <td>{{$project->payment_type}}</td>
                                        <td>{{ \Carbon\Carbon::createFromDate($project->created_at)->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <table class="table table-bordered" id="TransactionTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <td>{{__("customer.payer_name")}}</td>
                                    <td>{{__("customer.payment_amount")}}</td>
                                    <td>{{__("customer.paid_project")}}</td>
                                    <td>{{__("customer.payment_date")}}</td>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <td>{{__("customer.payer_name")}}</td>
                                    <td>{{__("customer.payment_amount")}}</td>
                                    <td>{{__("customer.paid_project")}}</td>
                                    <td>{{__("customer.payment_date")}}</td>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($customer->getPaymentHistory as $payment)
                                    <tr>
                                        <td>{{$payment->payer}}</td>
                                        <td>{{$payment->amount}}</td>
                                        <td>{{$payment->getProject->material_type}}</td>
                                        <td>{{ \Carbon\Carbon::createFromDate($project->created_at)->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#ProjectTable').DataTable({
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/English.json"
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2,3,4,5]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2,3,4,5]
                        }
                    },
                    {
                        extend: "print",
                        exportOptions: {
                            columns: [0, 1, 2,3,4,5]
                        },
                        customize: function (win) {
                            $(win.document.body)
                                .prepend(
                                    '<img src="{{asset("img/pinarpen.png")}}" width="80%" style="opacity:0.1; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"/>'
                                );
                        }
                    }
                ]
            });
            $('#TransactionTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2,3]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2,3]
                        }
                    },
                    {
                        extend: "print",
                        exportOptions: {
                            columns: [0, 1, 2,3]
                        }
                    }
                ]
            });
        });
    </script>
@endsection
