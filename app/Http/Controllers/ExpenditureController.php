<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        $expenditures = Expenditure::all();
        return view("management_panel.accounting.expenditures.index",compact("expenditures"));
    }

    public function create()
    {
        return view("management_panel.accounting.expenditures.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "amount"=>"required|numeric"
        ],[
            "name.required"=>"Gider adı kısmı zorunludur.",
            "amount.required"=>"Gider miktarı kısmı zorunludur.",
            "amount.numeric"=>"Gider miktarı kısmı sayı olmak zorundadır.",
        ]);

        if((float)$request->amount <= 0){
            return redirect()->back()->withErrors("Lütfen 0'dan yüksek bir tutar giriniz.");
        }

        $expenditure = new Expenditure();
        $expenditure->name = $request->name;

        $expenditure->amount = (float)$request->amount;
        $expenditure->detail = $request->amount ? $request->detail : null;
        $expenditure->save();



        return redirect("admin/accounting/expenditures")->with("success","Başarılı bir şekilde genel gider eklenmiştir.");
    }

    public function edit($id)
    {
        $expenditure = Expenditure::whereId($id)->firstOrFail();
        return view("management_panel.accounting.expenditures.edit",compact("expenditure"));
    }

    public function update(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "amount"=>"required|numeric"
        ],[
            "name.required"=>"Gider adı kısmı zorunludur.",
            "amount.required"=>"Gider miktarı kısmı zorunludur.",
            "amount.numeric"=>"Gider miktarı kısmı sayı olmak zorundadır.",
        ]);

        $expenditure = Expenditure::where("id",$request->id)->firstOrFail();
        $expenditure->name = $request->name;
        $expenditure->amount = (float)$request->amount;
        $expenditure->detail = $request->amount ? $request->detail : null;
        $expenditure->save();

        return redirect("admin/accounting/expenditures")->with("success","Başarılı bir şekilde genel gider güncellenmiştir.");
    }

    public function destroy(Request $request){
        $request->validate(["id"=>"required"]);

        $expenditure = Expenditure::whereId($request->id)->firstOrFail();
        $expenditure->delete();

        return redirect()->back()->with("success","Gider başarılı bir şekilde silinmiştir.");
    }



}
