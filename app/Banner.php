<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public function addBanner(Request $request){

      return view('admin.banners.add_banner');
    }
}
