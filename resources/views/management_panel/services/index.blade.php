@extends('management_panel.layouts.master')
@section('title','All Services')
@section('content')

        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; justify-content: space-between; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">{{$services->count()}} Services Found</h6>
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
                            <th>Service Name</th>
                            <th>Service Image</th>
                            <th>Service spec</th>
                            <th>created at</th>
                            <th>events</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Service Name</th>
                            <th>Service Image</th>
                            <th>Service spec</th>
                            <th>created at</th>
                            <th>events</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td><img style="object-fit:cover;" src="{{asset("img/services/".$service->image)}}" width="200" height="200"></td>
                                <td>{{$service->name}}</td>
                                <td>{{$service->spec}}</td>
                                <td>{{$service->created_at}}</td>
                                <td class="d-flex flex-row justify-content-around">
                                    <a href="{{url("/admin/services/$service->id/edit")}}" title="edit" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                    <form action="{{url("/admin/services/")}}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input type="hidden" name="id" value="{{$service->id}}">
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
