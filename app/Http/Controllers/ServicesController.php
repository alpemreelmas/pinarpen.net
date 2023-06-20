<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounting\Services\StoreRequest;
use App\Http\Requests\Accounting\Services\UpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServicesController extends Controller
{

    public function index()
    {
        $services = Service::orderBy("updated_at","DESC")->get();
        return view("management_panel.services.index",compact("services"));
    }


   public function create()
   {
       return view('management_panel.services.create')->render();
   }

   public function store(StoreRequest $request)
   {
       DB::transaction(function() use ($request) {
           $service = new Service($request->validated());
           $service->slug = Str::slug($request->name);

           if ($request->hasFile('image')) {
               $newImageName = Str::uuid() . "." . $request->file("image")->extension();
               $request->file("image")->move(public_path("img/services"), $newImageName);
               $service->image = $newImageName;
           }

           $service->save();
       });

        return redirect("/admin/services")->with("success",trans("general.Successful"));

    }

    public function edit($id){
        $service = Service::where("id",$id)->firstOrFail();

        return view("management_panel.services.edit",compact("service"));
    }

    public function update($id, UpdateRequest $request){

        DB::transaction(function() use ($request) {
            $service = Service::findOrFail($id);
            $service->slug = Str::slug($request->name);


            $service->slug = Str::slug($request->name);

            if ($request->hasFile('image')) {
                if (!unlink(public_path("img/services/" . $service->image))) {
                    return redirect()->back()->withErrors("Dosya silinemedi.");
                }
                $newImageName = Str::uuid() . "." . $request->file("image")->extension();
                $request->file("image")->move(public_path("img/services"), $newImageName);
                $service->image = $newImageName;
            }

            $service->save();
        });

        return redirect("/admin/services")->with("success",trans("general.Successful"));
    }

    public function delete(Request $request)
    {
        $request->validate(["id"=>"required"]);
        $service = Service::findOrFail($request->id);
        if(!unlink(public_path("img/services/".$service->image))){
            return redirect()->back()->withErrors("Dosya silinemedi.");
        }

        $service->delete();
        return redirect()->back()->with("success",trans("general.Successful"));
    }

}
