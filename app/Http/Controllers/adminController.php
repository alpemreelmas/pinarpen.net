<?php

namespace App\Http\Controllers;

use App\Models\CustomerPayment;
use App\Models\Debt;
use App\Models\Expenditure;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{

    public function dashboard(){
        $all_expenditure = Expenditure::orderBy("created_at","DESC")->sum("amount");
        $all_debts = Debt::orderBy("created_at","DESC")->sum("cost");
        $all_expenditures = $all_expenditure + $all_debts;

        $last_year_expenditure = Expenditure::whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("amount");
        $last_year_debts = Debt::whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("cost");
        $last_year_expenditures = $last_year_expenditure+$last_year_debts;

        $last_month_expenditure = Expenditure::whereMonth("created_at","=",Carbon::now()->month)->whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("amount");
        $last_month_debts = Debt::whereMonth("created_at","=",Carbon::now()->month)->whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("cost");
        $last_month_expenditures = $last_month_expenditure + $last_month_debts;

        $all_projects = Project::where("is_cancelled","!=",true)->count();
        $last_year_projects = Project::where("is_cancelled","!=",true)->whereYear("created_at","=",Carbon::now()->year)->count();
        $last_month_projects = Project::where("is_cancelled","!=",true)->whereYear("created_at","=",Carbon::now()->year)->whereMonth("created_at","=",Carbon::now()->month)->count();

        $all_income = Project::where("paid_payment",">",0)->orderBy("created_at","DESC")->sum("paid_payment");
        $last_month_income = Project::where("paid_payment",">",0)->whereMonth("created_at","=",Carbon::now()->month)->whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("paid_payment");
        $last_year_income = Project::where("paid_payment",">",0)->whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("paid_payment");

        $all_net_income = Project::where("is_cancelled","!=",true)->orderBy("created_at","DESC")->sum("earning");
        $last_month_net_income = Project::where("is_cancelled","!=",true)->whereMonth("created_at","=",Carbon::now()->month)->whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("earning");
        $last_year_net_income = Project::where("is_cancelled","!=",true)->whereYear("created_at","=",Carbon::now()->year)->orderBy("created_at","DESC")->sum("earning");

        $who_doesnt_pay_yet = Collection::make();
        $projects = Project::whereColumn("paid_payment","!=","cost")->whereNotIn("is_cancelled",[true])->get();
        foreach($projects as $project){
            $this_month_payment_date = Carbon::createFromDate(Carbon::now()->year,Carbon::now()->month , $project->pay_date);
            $one_month_ago_payment_date = Carbon::createFromDate(Carbon::now()->year,Carbon::now()->month , $project->pay_date)->subMonth()->addDay();
            $customer_payments = CustomerPayment::whereBetween("created_at",[$one_month_ago_payment_date,$this_month_payment_date])->where("project_id",$project->id)->get();
            $all_customer_payments = CustomerPayment::where("project_id",$project->id)->get();
            if($customer_payments->count() <= 0 && $all_customer_payments->count() < Carbon::createFromDate($project->created_at)->diffInMonths(Carbon::now())){
                $who_doesnt_pay_yet->push($project);
            }
        }


        return view("management_panel.dashboard",compact("all_expenditures",
            "last_year_expenditures","last_month_expenditures","who_doesnt_pay_yet","all_income","last_year_income",
            "last_month_income","all_net_income","last_month_net_income","last_year_net_income",
            "all_projects","last_month_projects","last_year_projects"));
    }

    public function login(){
        return view("management_panel.login");
    }

    public function login_post(Request $request){
        $request->validate(["email"=>"required","password"=>"required"]);
        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email'=>$email,'password'=>$password])){
            return redirect('/admin/dashboard');
        }
        return redirect()->back()->withErrors('Please check your email/password');
    }

    public function logout(){
        Auth::logout();
        return redirect("/admin/login");
    }

    public function checkPath()
    {
        if(Auth::user()){
            return redirect('admin/dashboard');
        }else{
            return redirect('admin/login');
        }
    }

    // public function deneme()
    // {
    //     $notification_payment = Collection::make();
    //     $projects = Project::whereColumn("paid_payment","!=","cost")->whereNotIn("is_cancelled",[false])->get();
    //     foreach($projects as $project){
    //         $this_month_payment_date = Carbon::createFromDate(Carbon::now()->year,Carbon::now()->month , $project->pay_date);
    //         $one_month_ago_payment_date = Carbon::createFromDate(Carbon::now()->year,Carbon::now()->month , $project->pay_date)->subMonth()->addDay();

    //         $customer_payments = CustomerPayment::whereBetween("created_at",[$one_month_ago_payment_date,$this_month_payment_date])->where("project_id",$project->id)->get();
    //         $all_customer_payments = CustomerPayment::where("project_id",$project->id)->get();
    //         if($customer_payments->count() <= 0 && $all_customer_payments->count() < Carbon::createFromDate($project->created_at)->diffInMonths(Carbon::now())){
    //             $notification_payment->push($project);
    //         }
    //     }

    //     // send email with queue

    // }
}
