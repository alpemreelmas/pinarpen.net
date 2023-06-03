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

        if((float)$request->amount <= 0){
            return redirect()->back()->withErrors(trans('expenditure.higher_than_0'));
        }

        DB::transaction(function() use ($request) {
            Expenditure::create($request->validate());
        });



        return redirect("admin/accounting/expenditures")->with("success",trans('expenditure.expenditure_added'));
    }

    public function edit($id)
    {
        $expenditure = Expenditure::whereId($id)->firstOrFail();
        return view("management_panel.accounting.expenditures.edit",compact("expenditure"));
    }

    public function update($id, Request $request)
    {

        DB::transaction(function() use ($request, $id) {
            Expenditure::update($request->validate());
        });

        return redirect("admin/accounting/expenditures")->with("success",trans('expenditure.expenditure_updated'));
    }

    public function destroy(Request $request){
        $request->validate(["id"=>"required"]);

        $expenditure = Expenditure::whereId($request->id)->firstOrFail();
        $expenditure->delete();

        return redirect()->back()->with("success",trans('expenditure.expenditure_deleted'));
    }



}
