<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounting\Portfolio\StoreRequest;
use App\Http\Requests\Accounting\Portfolio\UpdateRequest;
use App\Models\Gallery;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class portfoliosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy("updated_at","DESC")->get();
        return view("management_panel.portfolios.index",compact("portfolios"));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('management_panel.portfolios.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        DB::transaction(function() use ($request) {
            $portfolio = new Portfolio();

            if ($request->hasFile('title_image')) {
                $newImageName = Str::uuid() . "." . $request->file("title_image")->extension();
                $request->file("title_image")->move(public_path("img/portfolios"), $newImageName);
                $portfolio->title_image = $newImageName;
            }
            $portfolio->save();

            if ($request->hasFile('images')) {
                foreach ($request->file("images") as $image) {
                    $gallery = new Gallery();
                    $newImageName = Str::uuid() . "." . $image->extension();
                    $image->move(public_path("img/portfolios"), $newImageName);
                    $gallery->url = $newImageName;
                    $gallery->portfolios_id = $portfolio->id;
                    $gallery->save();
                }
            }
        });
        return redirect("/admin/portfolios")->with("success","Portfolyo başarılı bir şekilde kayıt edilmiştir.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::where("id",$id)->firstOrFail();

        return view("management_panel.portfolios.edit",compact("portfolio"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Portfolio $portfolio, $id)
    {
        DB::transaction(function() use ($request) {
            $portfolio = new Portfolio($request->validated());
            if ($request->hasFile('title_image')) {
                unlink(public_path("img/portfolios/" . $portfolio->title_image));
                $newImageName = Str::uuid() . "." . $request->file("title_image")->extension();
                $request->file("title_image")->move(public_path("img/portfolios"), $newImageName);
                $portfolio->title_image = $newImageName;
            }
            $portfolio->save();

            if ($request->hasFile('images')) {

                foreach ($portfolio->getGallery as $image) {
                    unlink(public_path("img/portfolios/" . $image->url));
                    $image->delete();
                }

                foreach ($request->file("images") as $image) {
                    $gallery = new Gallery();
                    $newImageName = Str::uuid() . "." . $image->extension();
                    $image->move(public_path("img/portfolios"), $newImageName);
                    $gallery->url = $newImageName;
                    $gallery->portfolios_id = $portfolio->id;
                    $gallery->save();
                }
            }
        });
        return redirect("/admin/portfolios")->with("success",trans("general.Successful"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $request->validate(["id"=>"required"]);
        $portfolio = Portfolio::findOrFail($request->id);

        unlink(public_path("img/portfolios/".$portfolio->title_image));
        foreach($portfolio->getGallery as $image){
            unlink(public_path("img/portfolios/".$image->url));
            $image->delete();
        }

        $portfolio->delete();
        return redirect()->back()->with("success",trans("general.Successful"));
    }
}
