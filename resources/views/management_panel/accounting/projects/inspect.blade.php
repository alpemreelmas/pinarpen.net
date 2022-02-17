@extends('management_panel.layouts.master')
@section('title','Proje Detayı')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$project->getCustomer->name." ".$project->getCustomer->surname }}
                adlı kullanıcı ile yaptığınız projenin detayları.</h6>
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
                <div class="col-md-12">
                    <div class="m-4">
                        <h4 class="small font-weight-bold">Ödeme Durumu <span class="float-right">@if($project->paid_payment == $project->cost) Tamamlandı! @elseif($project->is_cancelled) <span class="text-danger">İptal Edildi.</span> @else
                                    {{(int)(($project->paid_payment*100)/$project->cost)}}%  @endif</span></h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{($project->paid_payment*100)/$project->cost}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Tedarikçi</th>
                            <th scope="col">Materyal Türü</th>
                            <th scope="col">Ürün Adeti</th>
                            <th scope="col">Ödeme Türü</th>
                            <th scope="col">Kalan Borç</th>
                            <th scope="col">Ödenmiş Borç</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$project->getSupplier->name}}</td>
                            <td>{{$project->material_type}}</td>
                            <td>{{$project->material_amount}}</td>
                            <td>{{$project->payment_type}}</td>
                            <td>{{$project->pending_payment}}</td>
                            <td>{{$project->paid_payment}}</td>
                        </tr>
                        </tbody>
                    </table>


                    <div class="card mb-4 py-3 border-left-primary">
                        <div class="card-body">
                            <p class="m-0">Bu proje için <strong>{{$project->getSupplier->name}}</strong> adlı tedarikçiye <strong>{{($project->unit_price_of_material*$project->square_meters)*$project->material_amount}} TL</strong>  borçlanılmıştır.
                            @if($project->getDebt) <br/> Bu borcun <strong class="text-success">{{$project->getDebt->paid_payment}} TL</strong> kadarı ödenmiş, <strong class="text-warning">{{$project->getDebt->pending_payment}} TL</strong> kadarı ödenmemiştir.</p> @endif
                        </div>
                    </div>
                </div>
                <div class="table-responsive col-md-12">

                    <table class="table table-bordered" id="payment_table" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <td>Ödeyen Kişi</td>
                            <td>Ödeme Miktarı (Bir Taksit)</td>
                            <td>Ödeme Tarihi</td>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td>Ödeyen Kişi</td>
                            <td>Ödeme Miktarı (Bir Taksit)</td>
                            <td>Ödeme Tarihi</td>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($project->getPaymentHistory as $history)
                            <tr>
                                <td>{{$history->payer}}</td>
                                <td>{{$history->amount}}</td>
                                <td>{{ \Carbon\Carbon::createFromDate($history->created_at)->format('d/m/Y')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#payment_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: "print",
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    }
                ]
            });
        });
    </script>
@endsection
