@extends('master')
@section('title') Products CRUD @endsection
@section('content')

<style>
    svg.w-5.h-5{
        width: 25px !important;
    }
    span.relative.z-0.inline-flex.shadow-sm.rounded-md{
        float: right !important;
    }
</style>

<div class="row">
	<div class="col-xl-6 text-left">
        <a href="javascript:void(0);" data-target="#addProductModal" data-toggle="modal" class="btn btn-success"> Add New </a>
    </div>


    <div class="col-xl-6">
        <div id="result"></div>
    </div>

    
</div>

<table class="table table-striped mt-4">
    <thead>
        <th> Id </th>
        <th> Name </th>
        <th> Count </th>
        <th> Category </th>
        <th> Price </th>
        <th> Action </th>
    </thead>

    <tbody>
        @foreach ($products as $product)
            <tr>
                <td> {{$product->id}} </td>
                <td> {{$product->name}} </td>
                <td> {{$product->count}} </td>
                <td> {{$product->category->name}} </td>
                <td> {{$product->price}} </td>
                <td>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#addProductModal" data-id="{{$product->id}}" data-name="{{$product->name}}" data-count="{{$product->count}}" data-category_id="{{$product->category_id}}" data-price="{{$product->price}}" data-action="view" > <i class="fas fa-eye"></i> </a>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#addProductModal" data-id="{{$product->id}}" data-name="{{$product->name}}" data-count="{{$product->count}}" data-category_id="{{$product->category_id}}" data-price="{{$product->price}}" data-action="edit" > <i class="fas fa-edit"></i> </a>
                    <a href="javascript:void(0);" onclick="deleteProduct({{$product->id}})" > <i class="fas fa-trash-alt"></i> </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<!-- Create product modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel"> Create Product </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"> × </span>
          </button>
        </div>

        <div class="modal-body">
            <form method="POST" id="postForm">
                {{-- @csrf --}}
                <input type="hidden" id="id_hidden" name="id" />
                <div class="form-group">
                    <label for="title"> Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="title"> Count <span class="text-danger">*</span></label>
                    <input type="number" name="count" id="count" class="form-control">
                </div>
				
				
                <div class="form-group">
                    <label for="title"> Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-control" style="width:350px;margin-left:50px;">
                            @foreach($categories as $category)
					<option value="{{ $category->id }}"  >
				
					{{ $category->name }}
					</option>
				@endforeach          
						                               
                        </select>
                </div>
				
				
                <div class="form-group">
                    <label for="title"> Price <span class="text-danger">*</span></label>
                    <input type="text" name="price" id="price" class="form-control">
                </div>
            </form>
        </div>

        <div class="modal-footer">
          <button type="submit" id="createBtn" class="btn btn-primary"> Save </button>
        </div>

        <div class="result"></div>

      </div>
    </div>
</div>

{!! $products->links() !!}

@endsection