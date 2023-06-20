@extends('management_panel.layouts.master')
@section('title',__("customer.customer_loan_title"))
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <x-flash-messages />
                <form method="POST" action="{{url("/admin/accounting/projects/$project->id/customer-payments/")}}">
                    @csrf
                    <div class="form-group">
                        <label for="payer">{{__("customer.payer_name")}}</label><br/>
                        <input id="payer" name="payer" class="form-control" type="text" value="{{old("payer")}}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">{{__("customer.payment_amount")}}</label><br/>
                        <input id="amount" name="amount" class="form-control" type="number" value="{{old("amount")}}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{__("customer.payment_add")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



