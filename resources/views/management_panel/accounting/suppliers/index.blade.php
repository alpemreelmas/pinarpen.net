@extends('management_panel.layouts.master')
@section('title','Tedarikçiler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">{{$suppliers->count()}} tane tedarikçi bulundu.</h6>
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
                        <th>Tedarikçi Adı</th>
                        <th>Tedarikçinin Sattığı Materyal Tipi</th>
                        <th>IBAN</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Tedarikçi Adı</th>
                        <th>Tedarikçinin Sattığı Materyal Tipi</th>
                        <th>IBAN</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{$supplier->name}}</td>
                            <td>{{$supplier->material_type}}</td>
                            <td>TR{{$supplier->iban}}<button class="btn btn-outline-info float-right copyToClipboard fas fa-copy" iban="TR{{$supplier->iban}}"></button></td>
                            <td class="d-flex flex-row justify-content-around">
                                <a href="{{url("/admin/accounting/suppliers/$supplier->id/edit")}}" title="Edit" class="btn btn-sm btn-primary" id="editBtn"><i class="fa fa-pen"></i></a>
                                <a href="{{url("/admin/accounting/suppliers/$supplier->id/inspect")}}" title="İncele" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a>
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

            $(".copyToClipboard").click(function (e) {
                var element = e.target
                var iban = element.getAttribute("iban")
                navigator.clipboard.writeText(iban)
                element.innerHTML = "";
                element.innerHTML =" Kopyalandı"
                setTimeout(function () {
                    element.innerHTML = ""
                },2000)
            })

            let delete_id;
            $('#table').DataTable( {
                dom: 'Bfrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2]
                        }
                    },
                    {
                        extend:"print",
                        exportOptions: {
                            columns: [ 0, 1, 2]
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
        $("#deleteBtn").click(function (e) {
            delete_id = e.target.getAttribute("delete_id");
            new Swal({
                title: 'Bu tedarikçiyi silmek istediğinizden emin misiniz ?',
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
                    $.ajax({
                        type:"POST",
                        url:"{{url("/admin/accounting/suppliers/")}}/"+delete_id,
                        data:{
                            "_token":"{{csrf_token()}}",
                            "id":delete_id,
                            "_method":"DELETE"
                        },
                        success:function () {
                            new swal(
                                'Başarılı!',
                                'Tedarikçi başarılı bir şekilde silindi. Sayfa 3 saniye içinde yenilenecektir.',
                                'success'
                            )
                            setTimeout(function () {
                                location.reload()
                            },3000)
                        }
                    })
                }

            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    new swal(
                        'İptal Edildi',
                        'İşleminiz iptal edildi',
                        'error'
                    )
                }
            })
        })

    </script>
@endsection
