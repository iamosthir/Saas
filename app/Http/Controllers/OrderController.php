<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductVariation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Backup\BackupDestination\Backup;
use GuzzleHttp\Client;



class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function tesssbackup()
     {
    //   DB::table('product_variations')
    //     ->where('quantity', '<', 0)
    //     ->update(['quantity' => 0]);

    //   return "Quantities updated!";
      try {
        $deletedRows = Order::where('customer_name', 'تجربة طلب')->delete();

        return [
            "status" => "ok",
            "msg" => "تم حذف $deletedRows طلب(طلبات) بنجاح."
        ];
    } catch (\Exception $e) {
        return [
            "status" => "error",
            "msg" => "حدث خطأ أثناء حذف الطلبات: " . $e->getMessage()
        ];
    }

    }


     public function create(Request $req)
    {
        $this->validate($req,[
            "phone1" => "required|min:11|max:11",
            "phone2" => "min:11|max:11",
            "qnt" => "required",
            "state" => "required",
            "price" => "required",
            "page_name" => "required",
            "shiping" => "required"
        ]);

        $products = $req->input('products');
        $qnts = collect($products)->pluck('qnt');
        $totalQnt = $qnts->sum();


        // foreach($products as $product)
        // {

        //     $nt =  $product['variant_id'];

        // }

        // $checkqnt = ProductVariation::where('id',$nt)->first();

        // if($checkqnt->quantity < $totalQnt)

        // {
        //   return [
        //     "status" => "error",
        //     "msg" => " ليس لديك العدد كافي في مخزون ..! "
        // ];

        // }


        foreach($products as $product)
        {
            $nt = $product['variant_id'];
            $checkqnt = ProductVariation::find($nt);

            if($checkqnt->quantity < $product["qnt"])
            {
                return [
                    "status" => "error",
                    "msg" => " ليس لديك العدد كافي في مخزون ..! "
                ];
            }
        }







        $order = new Order();
        $order->customer_name = $req->name;
        $order->order_number = $order->generateID();
        $order->customer_link = $req->customer_link;
        $order->phone1 = $req->phone1;
        $order->phone2 = $req->phone2;
        $order->state = $req->state;
        $order->city = $req->city;
        $order->qnt = $totalQnt;
        $order->city_id = $req->city_id;
        $order->address = $req->address;
        $order->page_name = $req->page_name;
        $order->page_id = $req->page_id;
        $order->shiping = $req->shiping;
        $order->shiping_id = $req->shipping_id;
        $order->admin_id = auth()->user()->id;
        $order->admin_name = auth()->user()->name;
        $order->merchant_id = auth()->user()->merchant_id;
        $order->note = $req->note;
        $order->save();

        // Store product for the orders
        $totalPrice = 0;
        foreach($req->products as $pr)
        {
            $variant = null;
            OrderProduct::create([
                "order_id" => $order->id,
                "product_id" => $pr["product_id"],
                "variation_id" => $pr["variant_id"],
                "quantity" => $pr["qnt"],
                "net_price" => $pr["net_price"],
                "sub_total_price" => $pr["total_price"]
            ]);

            $variant = ProductVariation::find($pr["variant_id"]);
            $variant->quantity -= $pr["qnt"];
            $variant->save();
            $totalPrice += $variant->price*$pr["qnt"];
        }
        // ENd

        $order->price = $req->order_price;
        $order->save();

        // $product = SiteSetting::find(1);
        // $product->product_stock = $product->product_stock - $req->qnt;
        // $product->save();


        return [
            "status" => "ok",
            "msg" => "تم أنشاء الطلب رقم طلب خاص بك.$order->id. "
        ];
    }

    public function getList(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        if (auth()->user()->role == "staff") {
            $orders = Order::where('merchant_id', $merchantId)
                ->where('admin_id', auth()->user()->id)
                ->orderBy("id", "desc");
        }

        if (auth()->user()->role == "super") {
            $orders = Order::where('merchant_id', $merchantId)
                ->orderBy("id", "desc");
        }


        if($req->invoiceId != "")
        {
            $orders->where("id",$req->invoiceId)->orWhere("id",$req->invoiceId);
        }

        if($req->from_date != "" && $req->to_date != "")
        {
            $orders->whereBetween("created_at",[$req->from_date,$req->to_date]);
        }

        if($req->status != "")
        {
            $orders->where("status",$req->status);
        }

        if($req->productId != "")
        {
            $orderIds = OrderProduct::where("product_id",$req->productId)->get()->pluck("order_id")->toArray();
            $orders->whereIn("id",$orderIds);
        }

        if($req->page_name != "")
        {
            $orders->where("page_name",$req->page_name);
        }

        if($req->state != "")
        {
            $orders->where("state",$req->state);
        }

        if($req->phone != "")
        {
            $orders->where("phone1", 'like', '%' . $req->phone . '%');
        }


        if($req->price != "")
        {
            $orders->where("price",$req->price);
        }

        $totalQnt = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("quantity");
        $totalPrice = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("sub_total_price");
        // $orders = $orders->get();
        $orders = $orders->with('items')->paginate(20)->through(function($row){
            $row->total_quantity = OrderProduct::where("order_id",$row->id)->sum("quantity");
            return $row;
        });


        return response()->json([
            "orders" => $orders,
            "total_qnt" => $totalQnt,
            "total_price" => $totalPrice,
        ]);
    }
    public function getListpadding(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        if (auth()->user()->role == "staff") {
            $orders = Order::where('merchant_id', $merchantId)
                ->where('admin_id', auth()->user()->id)
                ->where("status","pending")->orderBy("id", "desc");
        }

        if (auth()->user()->role == "super") {
            $orders = Order::where('merchant_id', $merchantId)
                ->orderBy("id", "desc")
                ->where("status","pending");
        }


        if($req->invoiceId != "")
        {
            $orders->where("id",$req->invoiceId)->orWhere("id",$req->invoiceId);
        }


        if($req->from_date != "" && $req->to_date != "")
        {
            $orders->whereBetween("created_at",[$req->from_date,$req->to_date]);
        }

        if($req->status != "")
        {
            $orders->where("status",$req->status);
        }
        if($req->productId != "")
        {
            $orderIds = OrderProduct::where("product_id",$req->productId)->get()->pluck("order_id")->toArray();
            $orders->whereIn("id",$orderIds);
        }
        if($req->page_name != "")
        {
            $orders->where("page_name",$req->page_name);
        }
        if($req->state != "")
        {
            $orders->where("state",$req->state);
        }

        if($req->phone != "")
        {
            $orders->where("phone1",$req->phone);
        }

        $totalQnt = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("quantity");
        $totalPrice = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("sub_total_price");
        // $orders = $orders->get();
        $orders = $orders->paginate(20)->through(function($row){
            $row->total_quantity = OrderProduct::where("order_id",$row->id)->sum("quantity");
            return $row;
        });


        return response()->json([
            "orders" => $orders,
            "total_qnt" => $totalQnt,
            "total_price" => $totalPrice,
        ]);
    }
    public function getListcanceled(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        if (auth()->user()->role == "staff") {
            $orders = Order::where('merchant_id', $merchantId)
                ->where('admin_id', auth()->user()->id)
                ->where("status","canceled")
                ->orderBy("id", "desc");
        }

        if (auth()->user()->role == "super") {
            $orders = Order::where('merchant_id', $merchantId)
                ->orderBy("id", "desc")
                ->where("status","canceled");
        }


        if($req->invoiceId != "")
        {
            $orders->where("id",$req->invoiceId)->orWhere("id",$req->invoiceId);
        }

        // if($req->from_date != "")
        // {
        //     $orders->whereDate("created_at",$req->from_date);
        // }
        if($req->from_date != "" && $req->to_date != "")
        {
            $orders->whereBetween("created_at",[$req->from_date,$req->to_date]);
        }

        if($req->status != "")
        {
            $orders->where("status",$req->status);
        }
        if($req->productId != "")
        {
            $orderIds = OrderProduct::where("product_id",$req->productId)->get()->pluck("order_id")->toArray();
            $orders->whereIn("id",$orderIds);
        }
        if($req->page_name != "")
        {
            $orders->where("page_name",$req->page_name);
        }
        if($req->state != "")
        {
            $orders->where("state",$req->state);
        }

        if($req->phone != "")
        {
            $orders->where("phone1",$req->phone);
        }

        $totalQnt = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("quantity");
        $totalPrice = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("sub_total_price");
        // $orders = $orders->get();
        $orders = $orders->paginate(20)->through(function($row){
            $row->total_quantity = OrderProduct::where("order_id",$row->id)->sum("quantity");
            return $row;
        });


        return response()->json([
            "orders" => $orders,
            "total_qnt" => $totalQnt,
            "total_price" => $totalPrice,
        ]);
    }
    public function getListcompleted(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        if (auth()->user()->role == "staff") {
            $orders = Order::where('merchant_id', $merchantId)
                ->where('admin_id', auth()->user()->id)
                ->where("status","completed")
                ->orderBy("id", "desc");
        }

        if (auth()->user()->role == "super") {
            $orders = Order::where('merchant_id', $merchantId)
                ->orderBy("id", "desc")
                ->where("status","completed");
        }


        if($req->invoiceId != "")
        {
            $orders->where("id",$req->invoiceId)->orWhere("id",$req->invoiceId);
        }

        // if($req->from_date != "")
        // {
        //     $orders->whereDate("created_at",$req->from_date);
        // }
        if($req->from_date != "" && $req->to_date != "")
        {
            $orders->whereBetween("created_at",[$req->from_date,$req->to_date]);
        }

        if($req->status != "")
        {
            $orders->where("status",$req->status);
        }
        if($req->productId != "")
        {
            $orderIds = OrderProduct::where("product_id",$req->productId)->get()->pluck("order_id")->toArray();
            $orders->whereIn("id",$orderIds);
        }
        if($req->page_name != "")
        {
            $orders->where("page_name",$req->page_name);
        }
        if($req->state != "")
        {
            $orders->where("state",$req->state);
        }

        if($req->phone != "")
        {
            $orders->where("phone1",$req->phone);
        }

        // $orders = $orders->get();
        $totalQnt = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("quantity");
        $totalPrice = OrderProduct::whereIn("order_id",$orders->pluck("id")->toArray())->sum("sub_total_price");
        // $orders = $orders->get();
        $orders = $orders->paginate(20)->through(function($row){
            $row->total_quantity = OrderProduct::where("order_id",$row->id)->sum("quantity");
            return $row;
        });


        return response()->json([
            "orders" => $orders,
            "total_qnt" => $totalQnt,
            "total_price" => $totalPrice,
        ]);
    }

    public function printimages($invoiceData,$copy)
    {
        $invData = json_decode($invoiceData);

        $merchantId = auth()->user()->merchant_id;
        $invoices = Order::where('merchant_id', $merchantId)
            ->whereIn("id",$invData);
        $update = $invoices->update(["is_printed"=>"yes"]);
        $invoices = $invoices->with("items")->get()->map(function($row){
            $row->total_quantity = OrderProduct::where("order_id",$row->id)->sum("quantity");
            return $row;
        });
        $merchant = auth()->user()->merchant;
        return view("pages.invoice-images")->with(compact(
            "invoices",
            "copy",
            "merchant"
        ));

    }

    public function print($invoiceData,$copy)
    {
        $invData = json_decode($invoiceData);

        $merchantId = auth()->user()->merchant_id;
        $invoices = Order::where('merchant_id', $merchantId)
            ->whereIn("id",$invData);
        $update = $invoices->update(["is_printed"=>"yes"]);
        $invoices = $invoices->with("items")->get()->map(function($row){
            $row->total_quantity = OrderProduct::where("order_id",$row->id)->sum("quantity");
            return $row;
        });

        $siteSetting = SiteSetting::find(1);
        $merchant = auth()->user()->merchant;
        return view("pages.invoice")->with(compact(
            "invoices",
            "siteSetting",
            "copy",
            "merchant"
        ));
    }
    public function delete()
    {
        if (auth()->user()->role == "super" ) {
            $merchantId = auth()->user()->merchant_id;
            $order = Order::where('merchant_id', $merchantId)
                ->where('status', 'canceled')
                ->get();
            $order->each->delete();
            echo ("تم حذف جميع طلبات الراجع");
            return redirect()->route('home');
        }

        return redirect('/dashboard/access-denied');
    }

    public function invoiceData(Request $req)
    {
        if(auth()->user()->role == "super" || auth()->user()->role == "staff")
        {
            $merchantId = auth()->user()->merchant_id;
            if($invoice = Order::where('merchant_id', $merchantId)
                ->where("id",$req->invoiceNumber)
                ->with(["city","shipping","page"])
                ->first())
            {
                $products = OrderProduct::where("order_id",$invoice->id)->with("product")->with("variant")->get();
                $prData = array();
                foreach($products as $pr)
                {
                    $result = array();
                    $result["id"] = $pr->id;
                    $result["product_name"] = $pr->product->name;
                    $result["product_id"] = $pr->product->id;
                    $result["variant"] = $pr->variant->var_name;
                    $result["variant_id"] = $pr->variant->id;
                    $result["qnt"] = $pr->quantity;
                    $result["net_price"] = $pr->variant->price;
                    $result["total_price"] = $pr->variant->price*$pr->quantity;

                    array_push($prData,$result);
                }
                return [
                    "status" => "ok",
                    "data" => $invoice,
                    "product_data" => $prData,
                ];
            }
            else
            {
                return [
                    "status" => "fail",
                    "msg" => "404 not found"
                ];
            }
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "Access denied"
            ];
        }
    }


    public function update(Request $req)
    {
        $this->validate($req,[
            "invoiceId" => "required|numeric|exists:orders,id",
            "name" => "required",
            "phone1" => "required",
            "order_price" => "required",
            "page_name" => "required"
        ]);

        $merchantId = auth()->user()->merchant_id;

        // Check if order belongs to merchant
        $order = Order::where('id', $req->invoiceId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$order) {
            return [
                "status" => "error",
                "msg" => "الطلب غير موجود"
            ];
        }

        // تحقق من صلاحيات المستخدم
        if (auth()->user()->role == "staff") {
            if ($order->admin_id != auth()->user()->id) {
                return [
                    "status" => "error",
                    "msg" => "ليس لديك صلاحية لتعديل هذا الطلب."
                ];
            }
        } elseif (auth()->user()->role != "super") {
            return [
                "status" => "error",
                "msg" => "ليس لديك صلاحية لتعديل الطلبات."
            ];
        }

        foreach($req->products as $product)
        {
            $nt = $product['variant_id'];
            $checkqnt = ProductVariation::find($nt);

            if($checkqnt->quantity < $product["qnt"])
            {
                return [
                    "status" => "error",
                    "msg" => " ليس لديك العدد كافي في مخزون ..! "
                ];
            }
        }

        $siteSetting= SiteSetting::find(1);
        $oldQnt = $order->qnt;

        $order->customer_name = $req->name;
        $order->customer_link = $req->customer_link;
        $order->phone1 = $req->phone1;
        $order->phone2 = $req->phone2;
        $order->state = $req->state;
        $order->city = $req->city;
        $order->city_id = $req->city_id;
        $order->address = $req->address;
        $order->page_name = $req->page_name;
        $order->page_id = $req->page_id;
        $order->shiping = $req->shiping;
        $order->shiping_id = $req->shipping_id;
        $order->price = $req->order_price;
        $order->page_name = $req->page_name;
        $order->note = $req->note;

        // Store product for the orders
        foreach($req->products as $pr)
        {
            $variant = null;
            OrderProduct::create([
                "order_id" => $order->id,
                "product_id" => $pr["product_id"],
                "variation_id" => $pr["variant_id"],
                "quantity" => $pr["qnt"],
                "net_price" => $pr["net_price"],
                "sub_total_price" => $pr["total_price"]
            ]);

            $variant = ProductVariation::find($pr["variant_id"]);
            $variant->quantity -= $pr["qnt"];
            $variant->save();
        }
        // ENd

        if($order->status != "canceled" && $req->status == "canceled")
        {
            $orderProducts = OrderProduct::where("order_id",$order->id)->get();
            foreach($orderProducts as $orderProd)
            {
                $productVar = ProductVariation::where("id",$orderProd->variation_id)->where("product_id",$orderProd->product_id)->first();
                if(!empty($productVar))
                {
                    $productVar->quantity += $orderProd->quantity;
                }

                $productVar->save();
                $productVar = null;
            }
        }

        if($order->status == "canceled" && $req->status == "pending")
        {
            $orderProducts = OrderProduct::where("order_id",$order->id)->get();
            foreach($orderProducts as $orderProd)
            {
                $productVar = ProductVariation::where("id",$orderProd->variation_id)->where("product_id",$orderProd->product_id)->first();
                if(!empty($productVar))
                {
                    $productVar->quantity -= $orderProd->quantity;
                }
                $productVar->save();
                $productVar = null;
            }
        }

        $order->status = $req->status;
        $order->save();


         return [

            "status" => "ok",
            "msg" => "Order status has been updated",
            "update" => $order->status,
            "stock" => ProductVariation::sum("quantity"),

        ];
    }

    public function updateStatus(Request $req)
    {
        $this->validate($req, [
            "orderId" => "required|numeric|exists:orders,id",
            "status" => "required"
        ]);

        $merchantId = auth()->user()->merchant_id;
        $order = Order::where('id', $req->orderId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$order) {
            return [
                "status" => "fail",
                "msg" => "الطلب غير موجود"
            ];
        }

        $siteSetting= SiteSetting::find(1);
        $oldQnt = $order->qnt;

        //pandding

        if($order->status != "canceled" && $req->status == "canceled")
        {
            $orderProducts = OrderProduct::where("order_id",$order->id)->get();
            foreach($orderProducts as $orderProd)
            {
                $productVar = ProductVariation::where("id",$orderProd->variation_id)->where("product_id",$orderProd->product_id)->first();
                if(!empty($productVar))
                {
                    $productVar->quantity += $orderProd->quantity;
                    $productVar->save();
                }
                $productVar = null;
            }
        }

        if($order->status == "canceled" && $req->status == "pending")
        {
            $orderProducts = OrderProduct::where("order_id",$order->id)->get();
            foreach($orderProducts as $orderProd)
            {
                $productVar = ProductVariation::where("id",$orderProd->variation_id)->where("product_id",$orderProd->product_id)->first();
                if(!empty($productVar))
                {
                    $productVar->quantity -= $orderProd->quantity;
                    $productVar->save();
                }
                $productVar = null;
            }
        }


        $order->status = $req->status;
        $order->save();
        return [
            "status" => "ok",
            "msg" => "Order status has been updated",
            "update" => $order->status,
        ];
    }

    public function changeStatus($invoiceData , $status)
    {
        $invData = json_decode($invoiceData);

        $merchantId = auth()->user()->merchant_id;
        $orders = Order::where('merchant_id', $merchantId)
            ->whereIn('id', $invData)
            ->get();

        foreach ($orders as $order) {


        if($order->status != "canceled" && $status == "canceled")
        {
            $orderProducts = OrderProduct::where("order_id",$order->id)->get();
            foreach($orderProducts as $orderProd)
            {
                $productVar = ProductVariation::where("id",$orderProd->variation_id)->where("product_id",$orderProd->product_id)->first();
                if(!empty($productVar))
                {
                    $productVar->quantity += $orderProd->quantity;
                    $productVar->save();
                }
                $productVar = null;
            }
        }
        if($order->status == "canceled" && $status == "pending")
        {
            $orderProducts = OrderProduct::where("order_id",$order->id)->get();
            foreach($orderProducts as $orderProd)
            {
                $productVar = ProductVariation::where("id",$orderProd->variation_id)->where("product_id",$orderProd->product_id)->first();
                if(!empty($productVar))
                {
                    $productVar->quantity -= $orderProd->quantity;
                    $productVar->save();
                }
                $productVar = null;
            }
        }
        $order->status = $status;
        $order->save();

    }
        return redirect()->back();
    }

    public function reset()
    {
        Order::truncate();
        return "done";

    }


    public function printStatementview(Request $req)
    {
        if (auth()->user()->role == "staff") {
            return redirect('/dashboard/access-denied');
        }

        $merchantId = auth()->user()->merchant_id;
        $orders = Order::where('merchant_id', $merchantId)
            ->orderBy("id","desc");
        if($req->status != "")
        {
            $orders->where("status",$req->status);
        }
        if($req->from_date != "")
        {
            $orders->whereDate("created_at",$req->from_date);
        }
        else if($req->from_date != "" && $req->to_date != "")
        {
            $orders->whereBetween("created_at",[$req->from_date,$req->to_date]);
        }
        $orders = $orders->get();


       // return $orders;

        return view("pages.Statementv")->with(compact(
            "orders"
        ));

    }
    public function barcode(Request $req)
    {
        if($req->invoiceId != "")
        {
         $merchantId = auth()->user()->merchant_id;

         if (auth()->user()->role == "staff") {
            $orders = Order::where('merchant_id', $merchantId)
                ->where('admin_id', auth()->user()->id)
                ->where("status","completed")
                ->orderBy("id", "desc");
          }

         if (auth()->user()->role == "super") {
            $orders = Order::where('merchant_id', $merchantId)
                ->orderBy("id", "desc")
                ->where("status","completed");
          }
            $orders->where("id",$req->invoiceId)->orWhere("id",$req->invoiceId);
            $orders = $orders->get();
            return response()->json($orders);
        }

         else
        {
            $orders = [];
            return response()->json($orders);
        }

    }

    public function printStatement(Request $req)
    {
        if (auth()->user()->role == "staff") {
            return redirect('/dashboard/access-denied');
        }

        $merchantId = auth()->user()->merchant_id;
        $orders = Order::where('merchant_id', $merchantId)
            ->orderBy("id","desc");
        if($req->status != "")
        {
            $orders->where("status",$req->status);
        }
        if($req->from_date != "")
        {
            $orders->whereDate("created_at",$req->from_date);
        }
        else if($req->from_date != "" && $req->to_date != "")
        {
            $orders->whereBetween("created_at",[$req->from_date,$req->to_date]);
        }
        $orders = $orders->get();
        $merchant = auth()->user()->merchant;

            return view("pages.statement",compact("orders", "merchant"));
    }


    public function checkCustomer(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;
        $customer = Customer::where('merchant_id', $merchantId)
            ->where("phone1",$req->phone)
            ->first();
        if($customer)
        {
            return [
                "status" => "ok",
                "data" => $customer
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "Customer not found"
            ];
        }
    }

    public function checkPhone(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;
        if($customer = Order::where('merchant_id', $merchantId)
            ->where("phone1",$req->phone)
            ->first())
        {
            return [
                "status" => "ok"
            ];
        }
        else
        {
            return [
                "status" => "fail"
            ];
        }
    }

    public function searchById(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;
        $order = Order::where('merchant_id', $merchantId)
            ->where('id', $req->orderId)
            ->first();
        if(!empty($order))
        {
            return [
                "status" => "ok",
                "data" => $order
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "Order not found"
            ];
        }
    }

    public function removeOrderProduct(Request $req)
    {
        $this->validate($req,[
            "id" => "required|numeric|exists:order_products,id"
        ]);

        $pr = OrderProduct::find($req->id);

        $merchantId = auth()->user()->merchant_id;
        $order = Order::where('id', $pr->order_id)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$order) {
            return [
                "status" => "fail",
                "msg" => "Order not found"
            ];
        }
        $order->price -= $pr->sub_total_price;
        $order->save();

        $productVar = ProductVariation::where("product_id",$pr->product_id)->where("id",$pr->variation_id)->first();
        $productVar->quantity += $pr->quantity;
        $productVar->save();

        $pr->delete();
        return [
            "status" => "ok",
            "msg" => "Item removed"
        ];
    }
    public function invoiceapi($invoiceData)
    {
        $siteSetting = SiteSetting::find(1);

        $invData = json_decode($invoiceData);
        $orders = Order::whereIn('id', $invData)->get();

        // إعداد بيانات الطلب لإرساله إلى API
        $items = $orders->map(function($order) {
            return [
                "serial" => 'SN'.$order->id,
                "receiverName" => $order->customer_name,
                "receiverAddress" => $order->address,
                "partialDelivery" => false,
                "totalAmount" => $order->price,
                "additionalCost" => 0,
                "govName" => $order->state,
                "district" => $order->city ?? 'لايوجد',
                "receiverPhone" => $order->phone1,
                "receiverPhone2" => $order->phone2,
                "receiverEmail" => "example4@mail.com",
                "note" => $order->note ?? 'لايوجد',
                "content" => $order->product_type ?? 'لايوجد'
            ];
        });

        // إعداد بيانات الطلب النهائي
        $payload = json_encode($items);

        // return $items;
        $client = new Client();

        try {
            $response = $client->post('https://uat-merchant-api.etar.online/api/Item/CreateListOfItems', [
                'headers' => [
                    'accept' => 'text/plain',
                    'Authorization' => 'Bearer ' . $siteSetting->token,
                    'Content-Type' => 'application/json'
                ],
                'query' => [
                    'deliveryId' => 1
                ],
                'body' => $payload
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            if ($responseBody['message'] === "Success") {
                return response()->json(['msg' => 'Operation successful.', 'data' => $responseBody]);
            } else {
                return response()->json(['msg' => 'Operation failed: ' . ($responseBody['message'] ?? 'Unknown error'), 'data' => $responseBody], 400);
            }
        } catch (\Exception $e) {
            // معالجة الأخطاء
            $errorMessage = $e->getMessage();
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                if (isset($errorResponse['message'])) {
                    $errorMessage = $errorResponse['message'];
                }
            }
            return response()->json(['msg' => 'Error: ' . $errorMessage], 500);
        }
    }



}
