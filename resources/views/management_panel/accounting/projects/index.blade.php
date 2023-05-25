@extends('management_panel.layouts.master')
@section('title','Tüm Projeler')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$projects->count()}} tane proje bulundu.</h6>
        </div>
        <div class="card-body">
            <x-flash-messages />
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Müşteri İsmi</th>
                        <th>Malzeme Türü</th>
                        <th>Ödeme Yöntemi</th>
                        <th>Toplam Tutar</th>
                        <th>Ödenmiş Tutar</th>
                        <th>Ödenmesi Gereken Tutar</th>
                        <th>Fatura Kesim Tarihi</th>
                        <th>Proje Eklenme Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Müşteri İsmi</th>
                        <th>Malzeme Türü</th>
                        <th>Ödeme Yöntemi</th>
                        <th>Toplam Tutar</th>
                        <th>Ödenmiş Tutar</th>
                        <th>Ödenmesi Gereken Tutar</th>
                        <th>Fatura Kesim Tarihi</th>
                        <th>Proje Eklenme Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($projects as $project)
                        <tr @if($project->pending_payment == 0)style="background: #1cc88a; color:white" @elseif($project->is_cancelled) style="background: #e74a3b; color:white" @endif>
                            <td>{{$project->getCustomer->name}}</td>
                            <td>{{$project->material_type}}</td>
                            <td>{{$project->payment_type}}</td>
                            <td>{{$project->cost}} TL   </td>
                            <td>{{$project->paid_payment}} TL </td>
                            <td>{{$project->pending_payment}} TL </td>
                            <td>{{$project->pay_date}} </td>
                            <td>{{$project->created_at->diffForHumans()}}</td>
                            <td class="d-flex flex-row justify-content-around">
                                    @if(!$project->is_cancelled)
                                        @if($project->pending_payment !== 0 and $project->paid_payment !== $project->cost)
                                            <a href="{{url("/admin/accounting/customer-payments/$project->id/create")}}" title="pay" class="btn btn-sm btn-warning"><i class="fas fa-money-bill-wave"></i></a>
                                        @endif
                                    @endif
                                    <a href="{{url("/admin/accounting/projects/$project->id/inspect")}}" title="inspect" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a>
                                    @if(!$project->is_cancelled)
                                        @if($project->pending_payment == $project->cost and $project->paid_payment == 0)
                                            <a href="{{url("/admin/accounting/projects/$project->id/edit")}}" title="edit" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                            <form action="{{url("/admin/accounting/projects/$project->id/")}}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <input type="hidden" value="{{$project->id}}">
                                                <button class="btn btn-sm btn-danger deleteBtn" title="Delete" type="submit" ><i class="fa fa-times"></i></button>
                                            </form>
                                        @endif
                                    @endif
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
            $('#table').DataTable( {
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4, 5,6,7 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4, 5,6,7 ]
                        }
                    },
                    {
                        extend:"print",
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4, 5,6,7 ]
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

        let form;
        $(".deleteBtn").click(function (e) {
            form = $(this).parents('form');
            e.preventDefault()
            new Swal({
                title: 'Bu projeyi silmek istediğinizden emin misiniz ?',
                text: "Proje silinirse projeye dair yapılan ödeme vb her şey silinecektir. Bu silinme geri alınamaz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, eminim sil.',
                cancelButtonText: 'Hayır, emin değilim silme!',
                confirmButtonClass: 'btn btn-warning',
                cancelButtonClass: 'btn btn-danger',
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit()
                }
            })
        })

    </script>
@endsection
