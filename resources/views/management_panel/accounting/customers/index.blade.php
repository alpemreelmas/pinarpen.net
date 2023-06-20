@extends('management_panel.layouts.master')
@section('title',__("customer.all_customers"))
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{__("customer.found_customers",["count"=>$customers->count()])}}</h6>
        </div>
        <div class="card-body">
            <x-flash-messages />
            @if(Session::get("success"))
                <div class="alert alert-success">
                    {{Session::get("success")}}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{__("customer.name")}}</th>
                        <th>{{__("customer.surname")}}</th>
                        <th>{{__("customer.phone_number")}}</th>
                        <th>{{__("customer.address")}}</th>
                        <th>{{__("general.operations")}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{__("customer.name")}}</th>
                        <th>{{__("customer.surname")}}</th>
                        <th>{{__("customer.phone_number")}}</th>
                        <th>{{__("customer.address")}}</th>
                        <th>{{__("general.operations")}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->surname}}</td>
                            <td>{{$customer->phone_number}}</td>
                            <td>@if($customer->address !== null){{$customer->address}}@else {{__("general.there_is_no_record")}} @endif</td>
                            <td class="d-flex flex-row justify-content-around">
                                <a href="{{url("/admin/accounting/customers/$customer->id/edit")}}" title="edit" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                <a href="{{url("/admin/accounting/customers/$customer->id/inspect")}}" title="İncele" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a>
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
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/English.json"
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3 ]
                        }
                    },
                    {
                        extend: "print",
                        exportOptions: {
                            columns: [0, 1, 2, 3]
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
    </script>
@endsection
