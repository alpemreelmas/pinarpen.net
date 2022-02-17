@extends('management_panel.layouts.master')
@section('title','Genel Giderler')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$expenditures->count()}} tane genel gider bulundu.</h6>
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
                        <th>Gider</th>
                        <th>Miktar</th>
                        <th>Detail</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Gider</th>
                        <th>Miktar</th>
                        <th>Detail</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($expenditures as $expenditure)
                        <tr>
                            <td>{{$expenditure->name}}</td>
                            <td>{{$expenditure->amount}} TL</td>
                            <td>@if($expenditure->detail !== null){{substr($expenditure->detail,0,15)}} @if(strlen($expenditure->detail) > 15) ... @endif @else Detay Yok. @endif</td>
                            <td>{{ \Carbon\Carbon::createFromDate($expenditure->created_at)->format('d/m/Y')}}</td>
                            <td class="d-flex flex-row justify-content-around">
                                <a href="{{url("/admin/accounting/expenditures/$expenditure->id/edit")}}" title="edit" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                <form action="{{url("/admin/accounting/expenditures/$expenditure->id")}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <input type="hidden" value="{{$expenditure->id}}" name="id">
                                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                                </form>
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
                        extend:"print",
                        exportOptions: {
                            columns: [ 0, 1, 2,3 ]
                        }
                    }
                ]
            } );
        } );
    </script>
@endsection
