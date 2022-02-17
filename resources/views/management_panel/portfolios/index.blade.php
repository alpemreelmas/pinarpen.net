@extends('management_panel.layouts.master')
@section('title','All portfolios')
@section('content')

        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">{{$portfolios->count()}} adet portfolyo bulunmuştur.</h6>
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Portfolyo Resmi</th>
                            <th>Portfolyo Başlığı</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Portfolyo Resmi</th>
                            <th>Portfolyo Başlığı</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($portfolios as $portfolio)
                            <tr>
                                <td><img style="object-fit:cover;" src="{{asset("img/portfolios/".$portfolio->title_image)}}" width="200" height="200"></td>
                                <td>{{$portfolio->title}}</td>
                                <td>{{$portfolio->created_at}}</td>
                                <td class="d-flex flex-row justify-content-around">
                                    <a target="_blank" href="{{url("/portfolios/$portfolio->slug/$portfolio->id")}}" title="view" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                    <a href="{{url("/admin/portfolios/$portfolio->id/edit")}}" title="edit" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                    <form action="{{url("/admin/portfolios/")}}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input type="hidden" name="id" value="{{$portfolio->id}}">
                                        <button title="delete" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
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
