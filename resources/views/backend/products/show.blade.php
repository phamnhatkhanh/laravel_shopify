@extends('backend.dashboard')
@section('manage')
<div class="table-agile-info">
    <div class="panel panel-default">
        @php
            $message =Session::get('message');
            if($message){
                echo $message;
                Session::put('message',null);
            }
        @endphp
        <div class="panel-heading">
            Posts Table
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">

                <a href="/admin/products/create" class="btn btn-sm btn-default">Create Product</a>
            </div>
        </div>
        <div class="table-responsive">


            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>

                        <th></th>
                        <th>Title</th>
                        <th>Description</th>

                        <th>Status</th>
                        <th>Date Create</th>
                        <th>Action</th>
                        {{-- <th style="width:30px;"></th> --}}
                    </tr>
                </thead>
                <tbody>
@php
    // dd($products);
@endphp
                    @foreach ($products as  $item)

                        <tr>
                            {{-- <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td> --}}

                            <td>

                                @php
                                if(isset($item['images']) && ($item['images']!="") ){
                                    // dd($item['image']['src']);
                                    echo '<img src='. $item['images'] .'alt="" width="50" height="50">';
                                }else{
                                    echo '<img src="'. asset("backend/images/null-image.png").'" alt="" width="50" height="50">';
                                    // dd($item['image']['src']);
                                }

                                @endphp

                            </td>
                             <td>{{ Str::limit($item['title'],50,$end="...") }}</td>
                            <td><span class="text-ellipsis"> {{strip_tags( $item['description'])}}</span></td>

                            <td><span class="text-ellipsis">
                                {{ $item["status"] }}

                            </span></td>
                            <td><span class="text-ellipsis">{{ $item['created_at']}}</span></td>
                            <td>
                                <a href="{{ URL::to("admin/products/". $item['id']."/edit") }}" class="active" ui-toggle-class="">
                                   <i style="font-size:18px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>

                                </a>
                                <span>
                                <form style="display: inline;"action="{{ URL::to("/admin/products/". $item['id'] ) }}" method="POST"
                                    onsubmit="return confirm('Are you sure delete this product?')"
                                >
                                    @csrf
                                    @method("DELETE")
                                    <button style="border: none;background-color: transparent;" type="submit">
                                        <i style="font-size:18px;" class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

