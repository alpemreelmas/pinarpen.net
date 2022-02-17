<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class servicesController extends Controller
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

   public function store(Request $request)
   {
        $request->validate([
            "name"=>"required",
            "image"=>"required|mimes:jpg,jpeg,png|max:500",
            "spec"=>"required",
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->spec = $request->spec;

        if($request->hasFile('image')){
            $newImageName = Str::uuid().".".$request->file("image")->extension();
            $request->file("image")->move(public_path("img/services"),$newImageName);
            $service->image = $newImageName;
        }

        $service->save();

        return redirect("/admin/services")->with("success","Hizmet başarılı bir şekilde kayıt edilmiştir.");

    }

    public function edit($id){
        $service = Service::where("id",$id)->firstOrFail();

        return view("management_panel.services.edit",compact("service"));
    }

    public function update($id, Request $request){
        $request->validate([
            "name"=>"required",
            "spec"=>"required",
            "image"=>"nullable|mimes:jpg,jpeg,png|max:500",
        ]);

        $service = Service::findOrFail($id);
        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->spec = $request->spec;


        $service->slug = Str::slug($request->name);

        if($request->hasFile('image')){
            if(!unlink(public_path("img/services/".$service->image))){
                return redirect()->back()->withErrors("Dosya silinemedi.");
            }
            $newImageName = Str::uuid().".".$request->file("image")->extension();
            $request->file("image")->move(public_path("img/services"),$newImageName);
            $service->image = $newImageName;
        }

        $service->save();

        return redirect("/admin/services")->with("success","Hizmet başarılı bir şekilde güncellenmiştir.");
    }

    public function delete(Request $request)
    {
        $request->validate(["id"=>"required"]);
        $service = Service::findOrFail($request->id);
        if(!unlink(public_path("img/services/".$service->image))){
            return redirect()->back()->withErrors("Dosya silinemedi.");
        }

        $service->delete();
        return redirect()->back()->with("success","Hizmet başarılı bir şekilde silinmiştir.");
    }

}
