@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:0px;"><!--form-->
  <div class="container">
    @if(Session::has('flash_message_error'))

    <div class="alert alert-danger alert-block">
       <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>  {!! session('flash_message_error') !!}</strong>
    </div>
    @endif
    <form  action="{{ url('/checkout') }}" method="post">{{ csrf_field() }}
        <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <div class="login-form"><!--login form-->
          <h2><strong>Ürünün Gönderileceği Adres Bilgileri</strong></h2>
            <div class="form-group">
            <input class="form-control" name="shipping_name" id="shipping_name" type="text" placeholder="Gönderilecek İsim" />
            </div>
            <div class="form-group">
            <input class="form-control" name="shipping_address" id="shipping_address" type="text" placeholder="Gönderilecek Adres" />
          </div>
          <div class="form-group">
            <input class="form-control" name="shipping_city" id="shipping_city" type="text" placeholder="Gönderilecek Şehir" />
          </div>
          <div class="form-group">
            <input class="form-control" name="shipping_state" id="shipping_state" type="text" placeholder="Gönderilecek İlçe" />
          </div>
          <div class="form-group">
            <input class="form-control" name="shipping_country" id="shipping_country" type="text" placeholder="Gönderilecek Ülke" />
          </div>
          <div class="form-group">
            <input class="form-control" name="shipping_pincode" id="shipping_pincode" type="text" placeholder="Gönderilecek Pincode" />
          </div>
          <div class="form-group">
            <input class="form-control" name="shipping_mobile" id="shipping_mobile" type="text" placeholder="Telefon Numaranız" />
           </div>
              <div class="form-group">
          </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary">Devam Et</button>
          </div>
          </form>
        </div><!--/login form-->
      </div>
      <div class="col-sm-1">

      </div>
    </div>
    </form>
  </div>
</section><!--/form-->



























@endsection
