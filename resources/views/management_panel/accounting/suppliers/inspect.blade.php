@extends('management_panel.layouts.master')
@section('title','Tedarikçi Detayı')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$supplier->name }}
                adlı tedarikçi ile yaptığınız tüm alışverişlerin detayları.</h6>
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
            <div class="row">
                <div class="table-responsive col-md-12">
                    <div class="m-4">
                        <h4 class="small font-weight-bold">Sizin olan tüm borçların ödenme durumu <span class="float-right">@if($all_debt == 0)Complete!@else
                                    @if($all_debt == 0) 0 @else {{(int)(($paid_payment*100)/$all_debt)}} %@endif @endif</span></h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width:  @if($all_debt == 0) 100% @else {{(int)(($paid_payment*100)/$all_debt)}}% @endif" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <hr class="mt-2">
                    <ul class="nav nav-pills m-2" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Borçlar</a>
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
                                    <td>Borçlanma Tutarı</td>
                                    <td>Ödenmiş Tutar</td>
                                    <td>Ödenmesi Gereken Tutar</td>
                                    <td>Borçlanma Tarihi</td>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>

                                    <td>Borçlanma Tutarı</td>
                                    <td>Ödenmiş Tutar</td>
                                    <td>Ödenmesi Gereken Tutar</td>
                                    <td>Borçlanma Tarihi</td>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($supplier->getDebts as $debt)
                                    <tr @if($debt->pending_payment == 0)style="background: #1cc88a; color:white"@endif>
                                        <td>{{$debt->cost}}</td>
                                        <td>{{$debt->paid_payment}}</td>
                                        <td>{{$debt->pending_payment}}</td>
                                        <td>{{ \Carbon\Carbon::createFromDate($debt->created_at)->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <table class="table table-bordered" id="TransactionTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <td>Ödeyen Kişinin Adı</td>
                                    <td>Ödeme Tutarı</td>
                                    <td>Ödeme Tarihi</td>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <td>Ödeyen Kişinin Adı</td>
                                    <td>Ödeme Tutarı</td>
                                    <td>Ödeme Tarihi</td>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($debts as $debt)
                                    <tr>
                                        <td>{{$debt->payer_name}}</td>
                                        <td>{{$debt->amount}}</td>
                                        <td>{{ \Carbon\Carbon::createFromDate($debt->created_at)->format('d/m/Y')}}</td>
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
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
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
                        }
                    }
                ]
            });
            $('#TransactionTable').DataTable({
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
                },
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
        });
    </script>
@endsection
