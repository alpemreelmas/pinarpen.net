@extends('management_panel.layouts.master')
@section('title','Müşteri Borcu Ekle')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <x-flash-messages />
                <form method="POST" action="{{url("/admin/accounting/customer-payments/")}}">
                    @csrf
                    <div class="form-group">
                        <label for="payer_name">Ödeyen Adı</label><br/>
                        <input id="payer_name" name="payer_name" class="form-control" type="text" value="{{old("payer_name")}}" required>
                        <input name="project_id" class="form-control" type="hidden" value="{{$project->id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Ödeme Miktarı</label><br/>
                        <input id="amount" name="amount" class="form-control" type="number" value="{{old("amount")}}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Ödeme Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script>
        $(function() {
            var availableCustomers = {{ json_encode($customers->toArray()) }}
            $( "#payer_name" ).autocomplete({
                source: function (request,response) {
                    response($.map(availableCustomers,function (item) {
                        if(item.value.match("^"+request.term,"i")){
                            return {
                                value: item.value
                            }
                        }else{
                            return null
                        }

                    }))
                }
            });
        } );
    </script>
@endsection



