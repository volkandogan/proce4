@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banners</a> <a href="#" class="current">View Banners</a> </div>
    <h1>Banners</h1>
     @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Banners</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Banner ID</th>
                  <th>Link</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Title</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($banners as $product)
                <tr class="gradeX">
                  <td>{{ $product->id }}</td>
                  <td>{{ $product->link}}</td>
                  <td>{{ $product->image }}</td>
                  <td>{{ $product->status }}</td>
                  <td>{{ $product->title }}</td>
                  <td>
                    @if(!empty($product->image))
                      <img src="{{ asset('/images/frontend_images/banners/'.$product->image) }}" style="width:60px;">
                    @endif
                  </td>
                  <td class="center"><a href="#myModal{{ $product->id }}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                    <a href="{{ url('/admin/edit_product/'.$product->id) }}" class="btn btn-primary btn-mini">Edit</a>
                    <a href="{{ url('/admin/add_attributes/'.$product->id) }}" class="btn btn-primary btn-mini">Add Attributes</a>
                    <a id="delProduct" href="{{ url('/admin/delete-product/'.$product->id) }}" class="btn btn-danger btn-mini">Delete</a></td>
                </tr>
                    <div id="myModal{{ $product->id }}" class="modal hide">
                      <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h3>{{ $product->title }} Full Details</h3>
                      </div>
                      <div class="modal-body">
                        <p>Product ID: {{ $product->id }}</p>

                      </div>
                    </div>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
