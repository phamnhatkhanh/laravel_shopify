@extends('layouts.app_backend')
@section('content')
<section class="panel">
    <header class="panel-heading">
        Create Brand
    </header>
    <div class="panel-body">
        <div class="position-center">
            @php
            $message =Session::get('message');
            if($message){
                echo $message;
                Session::put('message',null);
            }
        @endphp
            <form action ="{{ URL::to("admin/products")  }} "role="form" method="post"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="form-group">
                    <label for="title_product">Title </label>
                    <input name='product_name' type="text" class="form-control" id="title_product"
                        value=""
                    >
                </div>
                <div class="form-group">
                    <label for="desc_product">Description</label>
                    <textarea name='product_desc' rows="4" cols="20" class="form-control" id="desc_product" ></textarea>
                </div>

                <div class="form-group">
                    <label for="title_product">Image  </label>
                    <input name='product_image' type="file" class="form-control" id="title_product">
                     {{-- <img src="{{ asset('images/product/') }}" alt="" width="100" height="100"> --}}
                     {{-- <input type="hidden" name="product_current" value=""> --}}
                </div>




                <button name='add_product' type="submit" class="btn btn-info">Submit</button>
            </form>
        </div>

    </div>
</section>

@endsection


