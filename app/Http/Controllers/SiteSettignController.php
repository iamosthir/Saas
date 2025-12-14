<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettignController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function changephone(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;
        $this->validate($req,[
            "phone" => "required|numeric|not_in:0",
        ]);
 

            $siteData= SiteSetting::where('merchant_id', $merchantId)->find(1);
            $siteData->phone = $req->phone;
            $siteData->save();
            return [
                "status"  => "ok",
                "phone" => $siteData->phone,
            ];
        
    }

    public function getData()
    {
        $merchantId = auth()->user()->merchant_id;
        $data = SiteSetting::where('merchant_id', $merchantId)->find(1)??[];
        $data["product_stock"] = ProductVariation::where('merchant_id', $merchantId)->sum("quantity");
        $data["total_price"] = ProductVariation::where('merchant_id', $merchantId)->selectRaw('SUM(price * quantity) as total_price')->first()->total_price;
        return response()->json($data);
    }

    public function addStock(Request $req)
    {
        $this->validate($req,[
            "amount" => "required|numeric|not_in:0",
        ]);
         $merchantId = auth()->user()->merchant_id;

        if(auth()->user()->role == "super" && $siteData= SiteSetting::where('merchant_id', $merchantId)->find(1))
        {
            $siteData->product_stock += $req->amount;
            $siteData->save();
            return [
                "status"  => "ok",
                "amount" => $siteData->product_stock,
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "You are not allowed to do this operation. Access denied"
            ];
        }

    }
}
