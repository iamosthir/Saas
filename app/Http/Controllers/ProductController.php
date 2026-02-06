<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function list(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;
        $products = Product::where('merchant_id', $merchantId)
            ->orderBy("id","desc");

        if($req->supplier_id != "") {
            $products = $products->where("supplier_id", $req->supplier_id);
        }
        $products = $products->get();
        return response()->json($products);
    }

    public function getProductVariation(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        // First check if product belongs to merchant
        $product = Product::where('id', $req->product_id)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return response()->json(['status' => 'fail', 'msg' => 'Product not found'], 404);
        }

        $vars = ProductVariation::where("product_id", $req->product_id)->get();
        return response()->json($vars);
    }

    public function process(Request $req)
    {
        $this->validate($req,[
            "product_id" => "required|numeric",
            "variant_id" => "required|numeric",
            "qnt" => "required|numeric",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $result = array();

        // Check if product belongs to merchant
        $product = Product::where('id', $req->product_id)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return [
                "status" => "fail",
                "msg" => "Product not found"
            ];
        }

        $variant = ProductVariation::find($req->variant_id);

        if($variant && $variant->quantity >= $req->qnt)
        {
            $result["product_name"] = $product->name;
            $result["product_id"] = $product->id;
            $result["variant"] = $variant->var_name;
            $result["variant_id"] = $variant->id;
            $result["qnt"] = $req->qnt;
            $result["net_price"] = $variant->price;
            $result["total_price"] = $variant->price*$req->qnt;

            return [
                "status" => "ok",
                "result" => $result,
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "Not enough stock for this product"
            ];
        }
    }

    public function processdelete(Request $req)
    {
        $this->validate($req, [
            "product_id" => "required|numeric",
            "variant_id" => "required|numeric",
            "qnt" => "required|numeric",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $result = array();

        // Check if product belongs to merchant
        $product = Product::where('id', $req->product_id)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return [
                "status" => "fail",
                "msg" => "Product not found"
            ];
        }

        $variant = ProductVariation::find($req->variant_id);

        if ($product && $variant) {
            $variant->increment('quantity', $req->qnt);

            return [
                "status" => "ok",
                "result" => $result,
            ];
        }

        return [
            "status" => "fail",
            "msg" => "Can't delete this product..!"
        ];
    }

    public function create(Request $req)
    {
        $this->validate($req, [
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "category_id" => "nullable|exists:categories,id",
            "purchase_price" => "required|numeric|min:0",
            "sell_price" => "required|numeric|min:0",
            "discount_type" => "nullable|in:fixed,percentage",
            "discount_amount" => "nullable|numeric|min:0",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $variants = json_decode($req->variant_data, true);

        // Validate variations
        if (empty($variants)) {
            return [
                "status" => "fail",
                "msg" => "At least one variation is required"
            ];
        }

        foreach ($variants as $var) {
            if (empty($var["var_name"]) || !isset($var["purchase_price"]) || !isset($var["sell_price"]) || !isset($var["quantity"])) {
                return [
                    "status" => "fail",
                    "msg" => "All variation fields are required"
                ];
            }
        }

        // Calculate total stock from variations
        $totalStock = array_sum(array_column($variants, 'quantity'));

        $product = new Product();
        $product->name = $req->name;
        $product->description = $req->description;
        $product->model_name = $req->model_name;
        $product->category_id = $req->category_id;
        $product->purchase_price = $req->purchase_price;
        $product->sell_price = $req->sell_price;
        $product->discount_type = $req->discount_type;
        $product->discount_amount = $req->discount_amount ?? 0;
        $product->total_stock = $totalStock;
        $product->merchant_id = $merchantId;
        $product->supplier_id = $req->supplier_id;

        // Handle main image upload
        if ($req->hasFile("image")) {
            $file = $req->file("image");
            $new_name = rand() . "_" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/products/"), $new_name);
            $product->image = $new_name;
        }

        // Handle thumbnail upload
        if ($req->hasFile("thumbnail")) {
            $file = $req->file("thumbnail");
            $thumb_name = "thumb_" . rand() . "_" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/products/"), $thumb_name);
            $product->thumbnail = $thumb_name;
        }

        $product->save();

        // Create variations
        foreach ($variants as $var) {
            ProductVariation::create([
                "merchant_id" => $merchantId,
                "product_id" => $product->id,
                "var_name" => $var["var_name"],
                "attribute_values" => isset($var["attribute_values"]) ? $var["attribute_values"] : null,
                "price" => $var["sell_price"],
                "purchase_price" => $var["purchase_price"],
                "installment_price" => $var["installment_price"] ?? 0,
                "quantity" => $var["quantity"],
                "average_price" => $var["purchase_price"] // Initial average price is purchase price
            ]);
        }

        return [
            "status" => "ok",
            "msg" => "Product added successfully",
            "product" => $product->load('variation')
        ];
    }

    public function update(Request $req)
    {
        $this->validate($req,[
            "productId" => "required|numeric|exists:products,id",
            "name" => "required|string|max:255",
        ]);

        $merchantId = auth()->user()->merchant_id;

        // Check if product belongs to merchant
        $product = Product::where('id', $req->productId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return [
                "status" => "fail",
                "msg" => "Product not found"
            ];
        }

        // Update basic product information
        $product->name = $req->name;
        $product->model_name = $req->model_name;
        $product->description = $req->description;
        $product->category_id = $req->category_id;
        $product->supplier_id = $req->supplier_id;
        $product->purchase_price = $req->purchase_price;
        $product->sell_price = $req->sell_price;
        $product->installment_price = $req->installment_price;
        $product->discount_type = $req->discount_type;
        $product->discount_amount = $req->discount_amount ?? 0;

        // Handle main image upload
        if($req->hasFile("image"))
        {
            if($product->image != "")
            {
                if(file_exists(public_path("uploads/products/$product->image")))
                {
                    unlink(public_path("uploads/products/$product->image"));
                }
            }

            $file = $req->file("image");
            $new_name = rand()."_".time().".".$file->getClientOriginalExtension();
            $file->move(public_path("uploads/products/"),$new_name);
            $product->image = $new_name;
        }

        // Handle thumbnail upload
        if($req->hasFile("thumbnail"))
        {
            if($product->thumbnail != "")
            {
                if(file_exists(public_path("uploads/products/$product->thumbnail")))
                {
                    unlink(public_path("uploads/products/$product->thumbnail"));
                }
            }

            $file = $req->file("thumbnail");
            $thumb_name = "thumb_" . rand() . "_" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/products/"), $thumb_name);
            $product->thumbnail = $thumb_name;
        }

        $product->save();

        // Handle new variations if any
        $variants = json_decode($req->variant_data, 1);
        $newVariants = array();

        if (!empty($variants)) {
            foreach($variants as $vars)
            {
                if(!empty($vars["var_name"]) && isset($vars["sell_price"]) && isset($vars["quantity"]))
                {
                    $newVar = ProductVariation::create([
                        "merchant_id" => $merchantId,
                        "product_id" => $product->id,
                        "var_name" => $vars["var_name"],
                        "attribute_values" => isset($vars["attribute_values"]) ? $vars["attribute_values"] : null,
                        "price" => $vars["sell_price"],
                        "purchase_price" => $vars["purchase_price"] ?? 0,
                        "installment_price" => $vars["installment_price"] ?? 0,
                        "quantity" => $vars["quantity"],
                        "average_price" => $vars["purchase_price"] ?? 0
                    ]);
                    $newVariants[] = $newVar;
                }
            }
        }

        return [
            "status" => "ok",
            "msg" => "Product updated successfully",
            "new_vars" => $newVariants,
        ];
    }

    public function updateVariation(Request $req)
    {
        $this->validate($req, [
            "variation_id" => "required|numeric|exists:product_variations,id",
            "purchase_price" => "nullable|numeric|min:0",
            "price" => "nullable|numeric|min:0",
            "installment_price" => "nullable|numeric|min:0",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $variation = ProductVariation::find($req->variation_id);

        // Check if the variation's product belongs to merchant
        $product = Product::where('id', $variation->product_id)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return [
                "status" => "fail",
                "msg" => "Access denied"
            ];
        }

        // Update variation prices
        if ($req->has('purchase_price')) {
            $variation->purchase_price = $req->purchase_price;
        }
        if ($req->has('price')) {
            $variation->price = $req->price;
        }
        if ($req->has('installment_price')) {
            $variation->installment_price = $req->installment_price;
        }

        $variation->save();

        return [
            "status" => "ok",
            "msg" => "Variation updated successfully",
            "variation" => $variation
        ];
    }

    public function getList(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;
        $products = Product::where('merchant_id', $merchantId)
            ->orderBy("id","desc")
            ->with(["variation", "category"]);

        if($req->search != "")
        {
            $products->where(function($query) use ($req) {
                $query->where("name","like","%$req->search%")
                      ->orWhere("id",$req->search);
            });
        }

        if ($req->measurementSearch != "") {
            $productIds = ProductVariation::where('var_name', 'like', "%{$req->measurementSearch}%")
                ->where('quantity', '>', 0)
                ->pluck('product_id');

            $products->whereIn('id', $productIds);
        }

        if ($req->category_id != "") {
            $products->where('category_id', $req->category_id);
        }

        $products = $products->paginate(12);

        return response()->json($products);
    }

    public function delete(Request $req)
    {
        $this->validate($req,[
            "productId" => "required|numeric|exists:products,id",
        ]);

        $merchantId = auth()->user()->merchant_id;

        // Check if product belongs to merchant
        $product = Product::where('id', $req->productId)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return [
                "status" => "fail",
                "msg" => "Product not found"
            ];
        }

        if($product->image != "")
        {
            if(file_exists(public_path("uploads/products/$product->image")))
            {
                unlink(public_path("uploads/products/$product->image"));
            }
        }

        $product->delete();
        return [
            "status" => "ok",
            "msg" => "Product deleted successfully"
        ];
    }

    public function getDetails(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        $product = Product::where('id', $req->productId)
            ->where('merchant_id', $merchantId)
            ->with("variation")
            ->first();

        if($product)
        {
            return [
                "status" => "ok",
                "product" => $product,
            ];
        }
        else
        {
            return [
                "status" => "fail"
            ];
        }
    }

    public function deleteVariation(Request $req)
    {
        $this->validate($req,[
            "variantId" => "required|numeric|exists:product_variations,id",
        ]);

        $merchantId = auth()->user()->merchant_id;
        $var = ProductVariation::find($req->variantId);

        // Check if the variation's product belongs to merchant
        $product = Product::where('id', $var->product_id)
            ->where('merchant_id', $merchantId)
            ->first();

        if (!$product) {
            return [
                "status" => "fail",
                "msg" => "Access denied"
            ];
        }

        $var->delete();

        return [
            "status" => "ok",
            "msg" => "Variation deleted"
        ];
    }

    public function updateVariantQuantity(Request $req)
    {
        if (auth()->user()->role == "staff") {
            return redirect('/dashboard/access-denied');
        }

        if (auth()->user()->role == "super") {

            $this->validate($req,[
                "id" => "required|numeric|exists:product_variations,id",
                "type" => "required"
            ]);

            $merchantId = auth()->user()->merchant_id;
            $var = ProductVariation::find($req->id);

            // Check if the variation's product belongs to merchant
            $product = Product::where('id', $var->product_id)
                ->where('merchant_id', $merchantId)
                ->first();

            if (!$product) {
                return [
                    "status" => "fail",
                    "msg" => "Access denied"
                ];
            }

            if($req->type == "plus") {
                $var->quantity +=1;
            }
            else {
                if($var->quantity > 0) {
                    $var->quantity -=1;
                }
            }
            $var->save();
            return [
                "status" => "ok",
            ];
        }
    }

    public function barcode(Request $req, $id)
    {
        $merchantId = auth()->user()->merchant_id;

        // Check if product belongs to merchant
        $product = Product::where('id', $id)
            ->where('merchant_id', $merchantId)
            ->with("variation", "category")
            ->first();

        if (!$product) {
            return abort(404, 'Product not found');
        }

        return view('pages.product-barcode', compact('product'));
    }
}
