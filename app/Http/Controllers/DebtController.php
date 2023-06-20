<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounting\Debt\Collective_pay_postRequest;
use App\Http\Requests\Accounting\Debt\StoreRequest;
use App\Models\Debt;
use App\Models\DebtPayment;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class DebtController extends Controller
{
    public function index(){
        $debts = Debt::orderBy("updated_at","DESC")->get();
        $all_debt = Debt::sum("pending_payment");
        return view("management_panel.accounting.debts.index",compact("debts","all_debt"));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view("management_panel.accounting.debts.create",compact("suppliers"));
    }

    public function store(StoreRequest $request){

        DB::transaction(function() use ($request) {
            $debts = new Debt($request->validated());
            $cost = ((float)$request->unit_price_of_material)*((float)$request->square_meters)*(int)$request->material_amount;
            $debts->cost = $cost;
            $debts->pending_payment = $cost;
            $debts->paid_payment = 0;
            $debts->save();
        });

        return redirect("/admin/accounting/debts")->with("success",trans("general.successful"));
    }

    public function edit($id){
        $suppliers = Supplier::all();
        $debt = Debt::whereId($id)->where("project_id",null)->firstOrFail();
        return view("management_panel.accounting.debts.edit",compact("suppliers","debt"));
    }

    public function update($id,StoreRequest $request){

        $debt = Debt::whereId($id)->firstOrFail();

        if($debt->pending_payment == $debt->cost && $debt->paid_payment == 0){
            DB::transaction(function() use ($request,$debt) {
                Debt::update($request->validated());
            });

            return redirect("/admin/accounting/debts")->with("success",trans("general.successful"));
        }else{
            return redirect()->back()->withErrors(trans("debt.payment_has_been_made_supplier"));
        }

    }

    public function delete(Request $request)
    {
        $debt = Debt::whereId($request->id)->where("project_id",null)->firstOrFail();
        if($debt->paid_payment == 0 && $debt->pending_payment == $debt->cost && DebtPayment::where("debt_id",$request->id)->get()->count() == 0){
            DB::transaction(function () use ($debt){
                $debt->delete();
            });
            return redirect()->back()->with("success",trans("general.successful"));
        }else{
            return redirect()->back()->withErrors(trans("debt.payment_has_been_made_debt"));
        }
    }

    public function collective_pay()
    {
        $suppliers = Supplier::whereRelation("getDebts","pending_payment",">","0")->get();
        if(Debt::sum("pending_payment") <= 0){
            return redirect()->back()->withErrors(trans("debt.bulk_payment_error"));
        }
        return view("management_panel.accounting.debts.collective_pay",compact("suppliers"));
    }

    public function collective_pay_post(Collective_pay_postRequest $request)
    {

        if($request->amount <= 0){
            return redirect()->back()->withErrors(trans("debt.less_than_0"));
        }

        if(Debt::where("supplier_id",$request->supplier_id)->sum("pending_payment") < $request->amount){
            return redirect()->back()->withErrors(trans("debt.bulk_overpayment"));
        }

        $remainder = $request->amount;

        $debts = Debt::where("supplier_id",$request->supplier_id)->where("pending_payment",">",0.00)->get();

        $id = explode("-",Uuid::uuid1())[0];

        for($i = 0; $i < $debts->count(); $i++){
            if($debts[$i]->pending_payment <= $remainder && $remainder !== 0 && $debts[$i]->pending_payment !== 0){
                    $remainder -= $debts[$i]->pending_payment;
                    $debts[$i]->paid_payment += $debts[$i]->pending_payment;

                    $debt_payment = new DebtPayment();
                    $debt_payment->payer_name = "TOPLU ÖDEME";
                    $debt_payment->payer_surname = $id;
                    $debt_payment->amount = $debts[$i]->pending_payment;
                    $debt_payment->debt_id = $debts[$i]->id;

                    $debts[$i]->pending_payment = 0;

                    $debts[$i]->save();
                    $debt_payment->save();
            }
        }

        $debts = Debt::where("supplier_id",$request->supplier_id)->where("pending_payment",">",0.00)->get();
        for($i = 0; $i < $debts->count(); $i++){
            if($debts[$i]->pending_payment > $remainder && $remainder !== 0){
                $debts[$i]->pending_payment -= $remainder;
                $debts[$i]->paid_payment += $remainder;

                $debt_payment = new DebtPayment();
                $debt_payment->payer_name = "TOPLU ÖDEME";
                $debt_payment->payer_surname = $id;
                $debt_payment->amount = $remainder;
                $debt_payment->debt_id = $debts[$i]->id;

                $remainder = 0;

                $debt_payment->save();
                $debts[$i]->save();
            }
        }

        return redirect("/admin/accounting/debts")->with("success","Toplu borç ödemesi 'TOPLU BORÇ $id' etiketi ile ödenmiştir.");
    }
}
