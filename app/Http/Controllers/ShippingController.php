<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function list()
    {
        $merchantId = auth()->user()->merchant_id;
        $shippings = Shipping::where('merchant_id', $merchantId)
            ->orderBy("id","desc")
            ->get();
        return response()->json($shippings);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            "name" => "required",
        ]);
        $shipping = new Shipping();
        $shipping->name = $req->name;
        $shipping->address = $req->address;
        $shipping->merchant_id = auth()->user()->merchant_id;
        $shipping->save();
        return [
            "status" => "ok",
            "msg" => "Shipping addedd.",
            "data" => $shipping,
        ];
    }

    public function update(Request $req)
    {
        $this->validate($req,[
            "shipId" => "required|numeric|exists:shippings,id",
            "name" => "required|unique:shippings,name,$req->shipId,id",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $shipping = Shipping::where('id', $req->shipId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$shipping) {
            return [
                "status" => "fail",
                "msg" => "Shipping not found"
            ];
        }

        $shipping->name = $req->name;
        $shipping->address = $req->address;
        $shipping->save();
        return [
            "status" => "ok",
            "msg" => "Shipping updated.",
            "data" => $shipping,
        ];
    }

    public function crudList()
    {
        $merchantId = auth()->user()->merchant_id;
        $shippings = Shipping::where('merchant_id', $merchantId)
            ->orderBy("id","desc")
            ->paginate(15);
        return response()->json($shippings);
    }

    public function delete(Request $req)
    {
        $this->validate($req,[
            "shipId" => "required|numeric|exists:shippings,id"
        ]);

        $merchantId = auth()->user()->merchant_id;
        $shipping = Shipping::where('id', $req->shipId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$shipping) {
            return [
                "status" => "fail",
                "msg" => "Shipping not found"
            ];
        }

        $shipping->delete();
        return [
            "status" => "ok",
            "msg" => "Data deleted"
        ];
    }
}
