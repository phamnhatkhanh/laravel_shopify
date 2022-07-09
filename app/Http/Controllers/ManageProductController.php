<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Session;
use DB;
use Carbon\Carbon;

class ManageProductController extends Controller
{
    public function index(){
        $store_id = Session::get("store_id");
        $products=Product::where("store_id",$store_id)->get();
        return view('backend.products.show')->with('products',$products);
    }
    public function create(){
        return view('backend.products.create');
    }

    public function show($id){
    }
    public function store(Request $request){
        $request->validate([
            "product_name"=>"required",
            "product_desc"=>"required",
            'product_image'=> 'bail|mimes:jpeg,png,gif|max:1024',
        ]);

        $store_id  = Session::get('store_id');
        $store = Store::where('id',$store_id)->first();
        $url = "https://". $store->myshopify_domain ."/admin/api/2022-07/products.json";

        if (request()->hasFile('product_image')){
            $newImageName = uniqid() . '-' . $request->product_image->getClientOriginalName();
            $path = public_path('backend/images/products/');

            $request->product_image->move($path,$newImageName);

            $image = base64_encode(
                file_get_contents($path.$newImageName)
            );
            unlink($path.$newImageName);
        }else{
            $image="";
        }

        $product = array(
            "product"=> array(
                "title"=>$request->product_name,
                "body_html"=>$request->product_desc,
                "images"=>[array(
                    "attachment"=>$image
                )]
            )
        );

        $getDataProduct =  Http::withHeaders([
            'X-Shopify-Access-Token' =>  $store->app_token,
        ])->withBody(json_encode($product), 'application/json')->post($url);
        $products = json_decode( $getDataProduct->body(),true);
        return \redirect("/admin/products");
    }


    public function edit($id){
        $product = Product::where("id",$id)->first();
        return view('backend.products.edit')->with("product",$product);
    }
    public function update(Request $request, $id){
        $request->validate([
            "product_name"=>"required",
            "product_desc"=>"required",
            'product_image'=> 'bail|mimes:jpeg,png,gif|max:1024',
        ]);

        $store_id  = Session::get('store_id');
        $store = Store::where('id',$store_id)->first();
        $url = "https://". $store->myshopify_domain ."/admin/api/2022-04/products/".$id.".json";
        if (request()->hasFile('product_image')){
            $newImageName = uniqid() . '-' . $request->product_image->getClientOriginalName();
            $path = public_path('backend/images/products/');

            $request->product_image->move($path,$newImageName);

            $image = base64_encode(
                file_get_contents($path.$newImageName)
            );
            unlink($path.$newImageName);
            $product = array(
                "product"=> array(
                    "id"=>$id,
                    "title"=>$request->product_name,
                    "body_html"=>$request->product_desc,
                    "images"=>[array(
                        "attachment"=>$image
                    )]
                )
            );
        }else{
            $product = array(
                "product"=> array(
                    "id"=>$id,
                    "title"=>$request->product_name,
                    "body_html"=>$request->product_desc,
                )
            );
        }

         $getDataProduct =  Http::withHeaders([
            'X-Shopify-Access-Token' =>  $store->app_token,
        ])->withBody(json_encode($product), 'application/json')->put($url);


        return \redirect("/admin/products");
    }

    public function destroy( $id){
        $store_id  = Session::get('store_id');
        $store = Store::where('id',$store_id)->first();
        $url = "https://". $store->myshopify_domain ."/admin/api/2022-04/products/".$id.".json";
        Http::withHeaders([
            'X-Shopify-Access-Token' =>  $store->app_token,

        ])->delete($url);
    }
    public function getListProduct(){
        $store_id  = Session::get('store_id');
        $store_token  = Session::get('store_token');
        $store_domain  = Session::get('store_domain');

        $getDataProduct = Http::withHeaders(['X-Shopify-Access-Token' =>  $store_token])
            ->get("https://".$store_domain."/admin/api/2022-04/products.json");
        $data = json_decode( $getDataProduct->body(),true);
        $products = $data["products"];

        foreach ($products as $item) {
            if(isset($item["image"]["src"])){
                Product::create([
                    "id"=>$item["id"],
                    "store_id"=>$store_id,
                    "title"=>$item["title"],
                    "description"=>$item["body_html"],
                    "images"=>$item["image"]["src"],
                ]);
            }else{
                Product::create([
                    "id"=>$item["id"],
                    "store_id"=>$store_id,
                    "title"=>$item["title"],
                    "description"=>$item["body_html"],
                    "images"=>"",
                ]);
            }

       }
       return \redirect("/admin/products");
    }
}
