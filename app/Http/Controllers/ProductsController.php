<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Auth;
use Session;
use App\Banner;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use DB;
class ProductsController extends Controller
{
  public function deleteProductImage($id = null){

    Product::where(['id'=>$id])->update(['image'=>'']);

    return redirect()->back()->with('flash_message_success','Resim Basarıyla Silindi');

  }
  public function editProduct(Request $request, $id = null){
    if ($request->isMethod('post')) {
        $data = $request->all();
        if ($request->hasFile('image')) {

          $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $filename = rand(111,99999).'.'.$extension;
            $large_image_path = 'images/backend_images/products/large/'.$filename;
            $medium_image_path = 'images/backend_images/products/medium/'.$filename;
            $small_image_path = 'images/backend_images/products/small/'.$filename;
            // Resize Images
            Image::make($image_tmp)->save($large_image_path);
            Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
            Image::make($image_tmp)->resize(300,300)->save($small_image_path);
          }else {
            $filename = $data['current_image'];
          }
          // code...
        }
        if(empty($data['description'])){
          $data['description'] = '';

        }
       Product::where(['id'=>$id])->update(['Category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
      'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],
      'price'=>$data['price'],'image'=>$filename]);
      return redirect()->back()->with('flash_message_success','Urun basarıyla update edildi');
    }

    $productDetails = Product::where(['id'=>$id])->first();
    $categories = Category::where(['parent_id'=>0])->get();
    $categories_dropdown = "<option value = '' selected disabled>Select</option>";
    foreach ($categories as $cat) {
      if ($cat->id==$productDetails->category_id) {
        $selected = "selected";
      }else{
        $selected = '';
      }
    $categories_dropdown .= "<option value ='".$cat->id."'".$selected.">".$cat->name."</option>";
    $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
      foreach ($sub_categories as $sub_cat) {
        if ($sub_cat->id==$productDetails->category_id) {
          $selected = "selected";
        }else{
          $selected = '';
        }
        $categories_dropdown .= "<option value ='".$sub_cat->id."'".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
      //  $categories_dropdown .="<option value ='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
      }
    }
    return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
  }
  public function addProduct(Request $request){
      if($request->isMethod('post')){
        $data = $request->all();
        //echo "<pre>"; print_r($data);die;
        $product = new Product;
        if (empty($data['category_id'])) {
            return redirect()->back()->with('flash_message_error','Lütfen Kategori Seçin');
        }
    		$product->category_id = $data['category_id'];
    		$product->product_name = $data['product_name'];
    		$product->product_code = $data['product_code'];
    		$product->product_color = $data['product_color'];
        if (!empty($data['description'])) {
          $product->description = $data['description'];
        }
        $product->description = '';
        $product->price = $data['price'];

        //upload imagear
        if ($request->hasFile('image')) {

          $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
    				$filename = rand(111,99999).'.'.$extension;
    				$large_image_path = 'images/backend_images/products/large/'.$filename;
    				$medium_image_path = 'images/backend_images/products/medium/'.$filename;
    				$small_image_path = 'images/backend_images/products/small/'.$filename;
    				// Resize Images
    				Image::make($image_tmp)->save($large_image_path);
    				Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
    				Image::make($image_tmp)->resize(300,300)->save($small_image_path);
    				// Store image name in products table
    				$product->image = $filename;
            }
          // code...
        }
        $product->save();
        return redirect()->back()->with('flash_message_success','Başarıyla Eklendi');
      }

      $categories = Category::where(['parent_id'=>0])->get();
      $categories_dropdown = "<option value = '' selected disabled>Select</option>";
      foreach ($categories as $cat) {
      $categories_dropdown .= "<option value ='".$cat->id."'>".$cat->name."</option>";
      $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
        foreach ($sub_categories as $sub_cat) {
          $categories_dropdown .= "<option value ='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
        //  $categories_dropdown .="<option value ='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
        }
      }
      return view('admin.products.add-product')->with(compact('categories_dropdown'));
    }

  public function viewProducts(){

    $products = Product::get();
      $products = json_decode(json_encode($products));
      foreach($products as $key => $val){
          $category_name = Category::where(['id'=>$val->category_id])->first();
          $products[$key]->category_name = $category_name->name;
      }
      //echo "<pre>"; print_r($products); die;
      return view('admin.products.view_products')->with(compact('products'));

  }

  public function deleteProduct($id = null){
      Product::where(['id'=>$id])->delete();
      return redirect()->back()->with('flash_message_success','Ürün Başarıyla Silindi');
  }


  public function addAttributes(Request $request , $id = null){

      $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
      //$productDetails = json_decode(json_encode($productDetails));
      //echo "<pre>"; print_r($productDetails);die;
      if ($request->isMethod('post')) {
          $data = $request->all();
        //  echo "<pre>"; print_r($data);die;

          foreach ($data['sku'] as $key => $val) {
            if (!empty($val)) {
              $attribute = new ProductsAttribute();
              $attribute->product_id = $id;
              $attribute->sku = $val;
              $attribute->size = $data['size'][$key];
              $attribute->price = $data['price'][$key];
              $attribute->stock = $data['stock'][$key];
              $attribute->save();
            }
          }
          return redirect('admin/add_attributes/'.$id)->with('flash_message_success',' Attriute Başarıyla eklendi');
      }

      return view('admin.products.add_attributes')->with(compact('productDetails'));
  }

  public function products($url =null){

   $categories = Category::with('categories')->where(['parent_id'=> 0])->get();

   $categoryDetails = Category::where(['url' => $url])->first();

   if ($categoryDetails->parent_id == 0) {
     // if main categoru
     $subCategories = Category::where(['parent_id'=> $categoryDetails->id])->get();

     foreach ($subCategories  as $subcat) {
          $cat_ids[] = $subcat->id;

     }
     //echo $cat_ids; die;
     $productsAll = Product::whereIN('category_id',$cat_ids)->get();
   }else {

     //if sun categoru
        $productsAll = Product::where(['category_id'=>$categoryDetails->id])->get();
   }



   $banners = Banner::where('status','1')->get();
   return view('products.listing')->with(compact('categoryDetails','productsAll','categories','banners'));

  }

  public function product($id = null){

    $productDetails = Product::with('attributes')->where('id',$id)->first();
    //$productDetails = json_decode(json_encode(($productDetails)));
    //echo "<pre>"; print_r($productDetails);die;
    $categories = Category::with('categories')->where(['parent_id'=>0])->get();

    return view('products.detail')->with(compact('productDetails','categories'));
  }

  public function addtocart(Request $request){
    $data = $request->all();

    if (empty($data['user_email'])) {
      $data['user_email'] = '';
    }
      $session_id = Session::get('session_id');
      if (empty($session_id)) {
        $session_id = str_random(40);
        Session::put('session_id', $session_id);
      }



    //echo "<pre>"; print_r($data);die;
    DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],
    'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$data['price'],
   'size'=>$data['size'],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);

    return redirect('cart')->with('flash_message_success','Urun Eklendi!');

  }

  public function cart(){

    $session_id = Session::get('session_id');
    $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
    foreach ($userCart as $key => $product) {
      //echo $product->product_id;
      $productDetails = Product::where('id',$product->product_id)->first();
      $userCart[$key]->image =$productDetails->image;
    }
    //


    //echo "<pre>"; print_r($userCart);die;
    return view('products.cart')->with(compact('userCart'));

  }

  public function checkout(Request $request){

    if ($request->isMethod('post')) {
      $data = $request->all();
      $user_id = Auth::user()->id;
      $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
      if ($shippingCount>0) {
        $shippingDetail =  DeliveryAddress::where('user_id',$user_id)->first();
      }

      if (empty($data['shipping_name'])|| empty($data['shipping_address'])|| empty($data['shipping_city'])||
          empty($data['shipping_state'])|| empty($data['shipping_country'])|| empty($data['shipping_pincode'])||
          empty($data['shipping_mobile']) ) {
         return redirect()->back()->with('flash_message_error','Lütfen Tüm Alanları Doldurunuz!!');
      }

      if ($shippingCount>0) {
      /*  DeliveryAddress::where('id',$user_id)->update(['name'=>$data['shipping_name'],['address'=>$data['shipping_address'],
      ['city'=>$data['shipping_city'],['name'=>$data['shipping_name'],['name'=>$data['shipping_name'],
      ['name'=>$data['shipping_name']]);*/
      }else {

      }

      //$ahippingCount = Delivery_Address::where('user_id',)
      /*User::where('id',$user_id)->update(['name'=>$data['shipping_name'],['address'=>$data['shipping_address'],
    ['city'=>$data['shipping_city'],['name'=>$data['shipping_name'],['name'=>$data['shipping_name'],
    ['name'=>$data['shipping_name']])*/
    }
    return view('products.checkout')->with(compact('shippingDetails'));
  }
  public function deleteCartProduct($id = null){
    DB::table('cart')->where('id',$id)->delete();
    return redirect('cart');

  }

  public function updateCarQuantity($id = null, $quantity = null){
    DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
    return redirect('cart');
  }
}
