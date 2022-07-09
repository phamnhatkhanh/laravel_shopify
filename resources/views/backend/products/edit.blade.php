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
            // dd($product)
            @endphp
            <form action ="{{ URL::to("admin/products/". $product->id )  }} "role="form" method="post"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title_product">Title </label>
                    <input name='product_name' type="text" class="form-control" id="title_product"
                        value="{{ $product->title }}"
                    >
                     @error('product_name') <span>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="desc_product">Description</label>
                    <textarea name='product_desc' rows="10" cols="20" class="form-control" id="desc_product" >{{ $product->description }}</textarea>
                    @error('product_desc') <span>{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="title_product">Image  </label>
                    <input name='product_image' type="file" class="form-control" id="title_product">
                     @php
                        if(isset($product['images']) && ($product['images']!="") ){
                            // dd($product['image']['src']);
                            echo '<img src='. $product['images'] .'alt="" width="100" height="100">';
                        }else{
                            echo '<img src="'. asset("backend/images/null-image.png").'" alt="" width="50" height="50">';
                            // dd($product['image']['src']);
                        }

                    @endphp
                    @error('product_image') <span>{{ $message }}</span> @enderror

                </div>




                <button name='add_product' type="submit" class="btn btn-info">Submit</button>
            </form>
        </div>

    </div>
</section>

@endsection


