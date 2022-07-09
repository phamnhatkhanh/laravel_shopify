<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Respones;
use App\Models\Store;
use App\Models\Product;
use Session;
use Illuminate\Support\Facades\Http;
use App\Jobs\GetProducts;
class WebHookController extends Controller
{
    public function accessPermission(){
        //  GetProducts::dispatch();
        $access_permission =array(
            "app/uninstalled",
            "products/create",
            "products/update",
            "products/delete" ,
        );
        //   dd(env("DOMAIN_NGROK"));
        $store_id  = Session::get('store_id');
        $store_token = Session::get('store_token');
        $store = Store::where('id',$store_id)->first();
        $url = "https://". $store->myshopify_domain ."/admin/api/2022-07/webhooks.json";
        foreach ($access_permission as $access) {
            $topic_webhook = array(
                "webhook"=> array(
                    "topic"=> $access,
                    "address"=>env("DOMAIN_NGROK")."/api/webhook/".$access,
                    "format"=>"json",
                )
            );
            $getDataProduct =  Http::withHeaders([
                'X-Shopify-Access-Token' =>  $store->app_token,
            ])->withBody(json_encode($topic_webhook), 'application/json')->post($url);
        }

        // After install app: Sync all product have store merchant.
        return redirect("/admin/list-product");


    }
    
    public function createProduct(Request $request){
        $store_domian = $request->header("X-Shopify-Shop-Domain");
        $store = Store::where("myshopify_domain",$store_domian)->first();
        $image="";
        if(isset($request["image"]["src"])){
            $image = $request["image"]["src"];
        }

        $product['id'] = $request['id'];
        $product['title'] = $request['title'];
        $product['description'] = $request['body_html'];
        $product['store_id'] = $store->id;
        $product['images'] = $image;

        Product::create($product);
    }

    public function updateProduct(Request $request){
        $image = "";
        $product['id'] = $request['id'];
        $product['title'] = $request['title'];
        $product['description'] = $request['body_html'];
        if(isset($request["image"]["src"])){
            $image = $request["image"]["src"];

        }
        $product['images'] = $image;

        Product::where('id',$product['id'])->update($product);

    }

    public function deleteProduct(Request $request){
        $product['id'] = $request['id'];
        Product::where('id', $product['id'])->delete();
    }
    public function deleteApp(Request $request){
        $store_id = $request->id;
        Store::where("id",$store_id)->update(['app_status'=>"uninstall"]);
        Product::where("store_id",$store_id)->delete();
    }
}
