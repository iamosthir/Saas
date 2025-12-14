<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function list()
    {
        $merchantId = auth()->user()->merchant_id;
        $pages = Page::where('merchant_id', $merchantId)
            ->orderBy("id","desc")
            ->get();
        return response()->json($pages);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            "name" => "required",
        ]);
        $page = new Page();
        $page->name = $req->name;
        $page->url = $req->url;
        $page->merchant_id = auth()->user()->merchant_id;
        $page->save();
        return [
            "status" => "ok",
            "msg" => "page addedd.",
            "data" => $page,
        ];
    }

    public function update(Request $req)
    {
        $this->validate($req,[
            "pageId" => "required|numeric|exists:pages,id",
            "name" => "required|unique:pages,name,$req->pageId,id",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $page = Page::where('id', $req->pageId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$page) {
            return [
                "status" => "fail",
                "msg" => "Page not found"
            ];
        }

        $page->name = $req->name;
        $page->url = $req->url;
        $page->save();
        return [
            "status" => "ok",
            "msg" => "page updated.",
            "data" => $page,
        ];
    }

    public function crudList()
    {
        $merchantId = auth()->user()->merchant_id;
        $pages = Page::where('merchant_id', $merchantId)
            ->orderBy("id","desc")
            ->paginate(200);
        return response()->json($pages);
    }

    public function delete(Request $req)
    {
        $this->validate($req,[
            "pageId" => "required|numeric|exists:pages,id"
        ]);

        $merchantId = auth()->user()->merchant_id;
        $page = Page::where('id', $req->pageId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$page) {
            return [
                "status" => "fail",
                "msg" => "Page not found"
            ];
        }

        $page->delete();
        return [
            "status" => "ok",
            "msg" => "Data deleted"
        ];
    }
}
