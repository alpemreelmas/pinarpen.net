@extends('management_panel.layouts.master')
@section('title','Anasayfa')
@section('content')
    <ul class="nav nav-pills m-2" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-month" role="tab"
               aria-controls="pills-home" aria-selected="true">Aylık</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-year" role="tab"
               aria-controls="pills-profile" aria-selected="false">Yıllık</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-total" role="tab"
               aria-controls="pills-profile" aria-selected="false">Tüm Zamanlar</a>
        </li>
    </ul>
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="tab-content w-100" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Gider (Aylık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_month_expenditures}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Gelir (Aylık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_month_income}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Proje Sayısı (Aylık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_month_projects}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Net Kar (Aylık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_month_net_income}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-year" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Gider (Yıllık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_year_expenditures}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Gelir (Yıllık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_year_income}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Proje Sayısı (Yıllık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_year_projects}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Net Gelir (Yıllık)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$last_year_net_income}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-total" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Gider (Tüm Zamanlar)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$all_expenditures}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Gelir (Tüm Zamanlar)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$all_income}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Proje Sayısı (Tüm Zamanlar)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$all_projects}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Net Gelir (Tüm Zamanlar)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$all_net_income}} TL</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Müşteri</th>
            <th scope="col">Materyal Türü</th>
            <th scope="col">Ürün Adeti</th>
            <th scope="col">Ödeme Türü</th>
            <th scope="col">Fatura Kesim Tarihi</th>
            <th scope="col">En Son Ödeme Tarihi</th>
        </tr>
        </thead>
        <tbody>
        @if($who_doesnt_pay_yet->count() <= 0)
            <tr>
                <td>Şuanda hiç ödenmemiş borç yoktur.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
        @else
            @foreach($who_doesnt_pay_yet as $project)
                <tr>
                    <td>{{$project->getCustomer->name}}</td>
                    <td>{{$project->material_type}}</td>
                    <td>{{$project->material_amount}}</td>
                    <td>{{$project->payment_type}}</td>
                    <td>{{$project->pay_date}}</td>
                    <td>@if($project->getPaymentHistory->count() > 0 ){{\Carbon\Carbon::createFromDate($project->getPaymentHistory->last()->created_at)->format('d/m/Y')}} @else Ödeme yok. @endif</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
@endsection
