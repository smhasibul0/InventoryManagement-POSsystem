<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{
    public function AllBrand(){
        $brand = Brand::latest()->get();
        return view('admin.backend.brand.all_brand', compact('brand'));
    }
    // End Method

    public function AddBrand(){
        return view('admin.backend.brand.add_brand');
    }
    // End Method

    public function StoreBrand(Request $request){
        if ($request->file('image')) {

            $image = $request->file('image');

            // Create ImageManager (v3)
            $manager = new ImageManager(new Driver());

            // Generate unique name
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Read image instead of make()
            $img = $manager->read($image);

            // Resize
            $img = $img->resize(100, 90);

            // Save image
            $img->save(public_path('upload/brand/' . $name_gen));

            // Store path in DB
            $save_url = 'upload/brand/' . $name_gen;

            Brand::create([
                'name'  => $request->name,
                'image' => $save_url,
            ]);
        }
        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.brand')->with($notification); 
    }
    // End Method
}
