<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Portfolio;

class homeController extends Controller
{
    public function index(Request $request){
        SEOTools::setTitle("Anasayfa");
        SEOTools::opengraph()->setUrl($request->url());
        return view('homepage');
    }

    public function about(Request $request){

        SEOTools::setTitle("Hakkımızda");
        SEOTools::opengraph()->setUrl($request->url());

        return view('about');
    }

    public function contact(Request $request){
        SEOTools::setTitle("İletişim");
        SEOTools::opengraph()->setUrl($request->url());
        return view('contact');
    }

    public function portfolios(Request $request)
    {
        SEOTools::setTitle("Portfolyolar");
        SEOTools::opengraph()->setUrl($request->url());
        $portfolios = Portfolio::orderBy("updated_at","DESC")->get();
        return view('portfolios',compact("portfolios"));
    }

    public function portfolios_detail($slug, $id,Request $request){
        $portfolio = Portfolio::where("slug",$slug)->where("id",$id)->firstOrFail();
        SEOTools::setTitle($portfolio->title);
        SEOTools::setDescription($portfolio->descriptions);
        SEOTools::opengraph()->setUrl($request->url());
        return view('portfolio_single',compact("portfolio"));
    }

    public function services(Request $request){
        SEOTools::setTitle("Hizmetler");
        SEOTools::opengraph()->setUrl($request->url());
        $services = Service::orderBy("updated_at","DESC")->get();
        return view('services',compact("services"));
    }

    public function accounting(){
        return redirect("/admin/dashboard");
    }
}
