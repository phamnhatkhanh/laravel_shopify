<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Redirect;
use Illuminate\Support\Facades\Http;
use Session;

class LoginController extends Controller
{
    public function login(Request $request){
        //Login: check shop in DB
            // yes: put in Session (id, token_app, use_name)
                // welcome
            // no: get token
                // First install:
                    // Login -> getAccess
                        // aceess permission
                        // get list -> put DB.
                // Reinstall:
                    // update status app.
        if($request->getMethod()=='GET'){ // show UI
            return view('install');
        }

        $domain_store= $request->store_merchant .".myshopify.com";
        $existStore = Store::where("myshopify_domain",$domain_store)->first();
        if(isset($existStore->id) && ($existStore->app_status == "install")){
            Session::put('store_id',$existStore->id);
            Session::put('store_token',$existStore->app_token);
            Session::put('store_domain',$existStore->myshopify_domain);
            Session::put('user_name',$existStore->name_merchant);
            return redirect("/admin/dashboard");
        }else{
            return redirect('https://'.$domain_store.'/admin/oauth/authorize?client_id='.env("KEY_APP_SHOPIFY").'&scope=read_content,write_content,read_customers,write_customers,read_products,write_products,read_product_listings,unauthenticated_read_product_listings,unauthenticated_read_product_tags,write_orders,read_customers&redirect_uri=http://localhost:8000/');
        }

    }

    public function getAcessStore(Request $request){
        if($request->all()){ // repsone when verify betwenn app and merchant.
                $data  =($request->all()); // get paramater of query in url.
                $url ="https://".$data['shop']."/admin/oauth/access_token";
                $body['client_id']=env("KEY_APP_SHOPIFY");
                $body['client_secret']=env("KEY_SECRET_APP_SHOPIFY");
                $body['code']=$data['code'];

                $getTokenStore = Http::withBody(json_encode($body), 'application/json')->post($url);
                $getInfoStore = Http::withHeaders(['X-Shopify-Access-Token' =>  $getTokenStore["access_token"]])->get("https://".$data['shop']."/admin/api/2021-07/shop.json");

                $store['id']=$getInfoStore['shop']['id'];
                $store['app_token']=$getTokenStore['access_token'];
                $store['app_status']= "install";
                $store['domain']= $getInfoStore['shop']['domain'];
                $store['email']= $getInfoStore['shop']['email'];
                $store['myshopify_domain']= $getInfoStore['shop']['myshopify_domain'];
                $store['name_merchant']= $getInfoStore['shop']['name'];
                $store['plan']= $getInfoStore['shop']['plan_display_name'];

                $existStore = Store::where('myshopify_domain',$data['shop'])->first();
                if($existStore){ //exist store in databases (unistall app -> reinstall).
                    $existStore->update($store);
                    Session::put('store_id',$existStore->id);
                    Session::put('store_token',$existStore->app_token);
                    Session::put('store_domain',$existStore->myshopify_domain);
                    Session::put('user_name',$existStore->name_merchant);
                }else{ // new store
                    Store::create($store);
                    Session::put('store_id',$store['id']);
                    Session::put('store_token',$store['app_token']);
                    Session::put('store_domain',$store['myshopify_domain']);
                    Session::put('user_name',$store['name_merchant']);
                }

                // Access Permission
                return redirect('/admin/webhook/products/access-permission');
            }else{ // when acess root "/" not request
                return redirect('/install');
            }



    }

    public function dashboard(){

        return view("backend.dashboard");
    }

}



