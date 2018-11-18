<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Facades\Input;
use Image;

class BannersController extends Controller
{
    public function addBanner(Request $request){

      if ($request->isMethod('post')) {
        $data = $request->all();
        $Banner = new Banner;
        $Banner->title = $data['title'];
        $Banner->link = $data['link'];
        if(empty($data['status'])){
          $status = 0;
        }else {
          $status = 1;
        }

        if ($request->hasFile('image')) {

          $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $filename = rand(111,99999).'.'.$extension;
            $banner_path = 'images/frontend_images/banners/'.$filename;

            Image::make($image_tmp)->resize(1140,340)->save($banner_path);
            $Banner->image = $filename;
          }
          // code...
        }
        $Banner->status = $status;
        $Banner->save();

      return redirect()->back()->with('flash_message_success','Banner basarıyla update edildi');
      }

      return view('admin.banners.add_banner');

    }

    public function viewBanner(){
      $banners = Banner::get();
      return view('admin.banners.view_banners')->with(compact('banners'));
    }
}
