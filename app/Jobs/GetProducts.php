<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Session;
use App\Models\Store;
use Illuminate\Support\Facades\Http;
class GetProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $store_id  = Session::get('store_id');
        $store = Store::where('id',$store_id)->first();
        $url = "https://". $store->myshopify_domain ."/admin/api/2022-07/webhooks.json";
        $topic_webhook = array(
            "webhook"=> array(
                "topic"=>"products/update",
                "address"=>"https://61ad-113-161-32-170.ap.ngrok.io/api/webhook/get-product",
                "format"=>"json",
            )
        );
         $getDataProduct =  Http::withHeaders([
            'X-Shopify-Access-Token' =>  $store->app_token,

            ])->withBody(json_encode($topic_webhook), 'application/json')->post($url);
             $products = json_decode( $getDataProduct->body(),true);
    }
}
