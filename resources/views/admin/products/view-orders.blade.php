@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Orders</a> <a href="#" class="current">Pending Orders</a> </div>
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
                  <th>Ad</th>
                  <th>Adres</th>
                  <th>Telefon</th>
                  <th>Ülke</th>
                  <th>Ürün Adı</th>
                  <th>Ürün Codu</th>
                  <th>Ürün Adedi</th>
                  <th>Ürün Size</th>
                  <th>Ürün Fiyatı</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($orders as $product)
                <tr class="gradeX">
                  <td>{{ $product->shipping_name }}</td>
                  <td>{{ $product->shipping_address}}</td>
                  <td>{{ $product->shipping_mobile }}</td>
                  <td>{{ $product->shipping_country }}</td>
                  <td>{{ $product->product_name }}</td>
                  <td>{{ $product->product_code }}</td>
                  <td>{{ $product->quantity }}</td>
                  <td>{{ $product->size }}</td>
                  <td>{{ $product->price }}</td>

                  <td class="center"><a href="#myModal{{ $product->id }}" data-toggle="modal" class="btn btn-success btn-mini">Tamamla</a>
                    <a href="{{ url('/admin/edit_product/'.$product->id) }}" class="btn btn-danger btn-mini">İptal</a>
                </tr>
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
