<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Support\Carbon;
use Image;


class AboutController extends Controller
{
    public function AboutPage(){
        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));
    }

    public function UpdateAbout(Request $request){
        $about_id = $request->id;

        if ($request->file('about_image')){
            //chuyen doi ten anh va dua vao file chua
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //2212.jpg

            Image::make($image)->resize(523,730)->save('upload/home_about/'.$name_gen);
            $save_url ='upload/home_about/'.$name_gen;

            //Update database
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url
            ]);

            $notification = array(
                'message' => 'About Page Update with Image Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }

        else{
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

            ]);

            $notification = array(
                'message' => 'About Page Update without Image Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
    }

    public function HomeAbout(){
        $aboutpage = About::find(1);

        return view ('frontend.about_page',compact('aboutpage'));
    }

    public function AboutMultiImage(){
        return view ('admin.about_page.multimage');
    }

    public function StoreMultiImage(Request $request){
        $image = $request->file('multi_image');

        foreach ($image as $multi_image){
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension(); //2212.jpg

            Image::make($multi_image)->resize(220,220)->save('upload/multi/'.$name_gen);
            $save_url ='upload/multi/'.$name_gen;

            //Update database
            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now()// xem time 
            ]);
                }//End Foreach

            $notification = array(
                'message' => 'Multi Image Inserted Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        

    }


    public function AllMultiImage(){
        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));
    }

    public function EditMultiImage($id){

        $multiImage = MultiImage::findOrFail($id);
        return view('admin.about_page.edit_multi_image',compact('multiImage'));
    }

    public function UpdateMultiImage(Request $request){
        // request->id la cai name='id' o the input
        $multi_image_id = $request->id;

        if ($request->file('multi_image')){
            //chuyen doi ten anh va dua vao file chua
            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //2212.jpg

            Image::make($image)->resize(220,220)->save('upload/multi/'.$name_gen);
            $save_url ='upload/multi/'.$name_gen;

            //Update database
            MultiImage::findOrFail($multi_image_id)->update([
                
                'multi_image' => $save_url,
               
            ]);

            $notification = array(
                'message' => 'Multi Image Update Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.multi.image')->with($notification);
        }

    }

    public function DeleteMultiImage($id){
         $multi = MultiImage::findOrFail($id);
         $img = $multi->multi_image;
         unlink($img);

         MultiImage::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Multi Image Delete Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    


    }
}
