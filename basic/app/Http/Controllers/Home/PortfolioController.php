<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfilio;
use Image;
use Illuminate\Support\Carbon;

class PortfolioController extends Controller
{
    public function AllPortfolio(){
        // nó sắp xếp dữ liệu được tìm nạp, sử dụng cột 'created_at' để sắp xếp dữ liệu theo trình tự thời gian.
        $portfolio = Portfilio::latest()->get();
        return view('admin.portfolio.portfolio_all',compact('portfolio'));
    }

    public function AddPortfolio(){
        return view('admin.portfolio.portfolio_add');
    }

    public function StorePortfolio(Request $request){

        $request->validate([
            'portfilio_name' => 'required',
            'portfilio_title' => 'required',

        ],[
            // tu dien loi khi khong thoa ma yeu cau
            'portfilio_name.required' => 'Portfilio Name is Required',
            'portfilio_title.required' => 'Portfilio Title is Required',
            
        ]);

         //chuyen doi ten anh va dua vao file chua
         $image = $request->file('portfilio_image');
         $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //2212.jpg

         Image::make($image)->resize(1020,519)->save('upload/portfilio/'.$name_gen);
         $save_url ='upload/portfilio/'.$name_gen;

         //Update database
         Portfilio::insert([
             'portfilio_name' => $request->portfilio_name,
             'portfilio_title' => $request->portfilio_title,
             'portfilio_description' => $request->portfilio_description,
             'portfilio_image' =>  $save_url,
             'created_at' => Carbon::now()

         ]);

         $notification = array(
             'message' => 'Portfilio Insert Successfully!',
             'alert-type' => 'success'
         );
 
         return redirect()->route('all.portfolio')->with($notification);

    }

    public function EditPortfolio($id){
        // nó sắp xếp dữ liệu được tìm nạp, sử dụng cột 'created_at' để sắp xếp dữ liệu theo trình tự thời gian.
        $portfolio = Portfilio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit',compact('portfolio'));
    }

    public function UpdatePortfolio(request $request){
        $portfolio_id = $request->id;

        if ($request->file('portfilio_image')){
            //chuyen doi ten anh va dua vao file chua
            $image = $request->file('portfilio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //2212.jpg

            Image::make($image)->resize(1020,519)->save('upload/portfilio/'.$name_gen);
            $save_url ='upload/portfilio/'.$name_gen;

            //Update database
            Portfilio::findOrFail($portfolio_id)->update([
                'portfilio_name' => $request->portfilio_name,
                'portfilio_title' => $request->portfilio_title,
                'portfilio_description' => $request->portfilio_description,
                'portfilio_image' =>  $save_url,
                'created_at' => Carbon::now()

            ]);

            $notification = array(
                'message' => 'Portfilio Update with image Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.portfolio')->with($notification);
        }

        else{
            Portfilio::findOrFail($portfolio_id)->update([
                'portfilio_name' => $request->portfilio_name,
                'portfilio_title' => $request->portfilio_title,
                'portfilio_description' => $request->portfilio_description
            

            ]);

            $notification = array(
                'message' => 'Portfilio Update with image Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.portfolio')->with($notification);

        }
    }

    public function DeletePortfolio($id){
        $portfolio_all = Portfilio::findOrFail($id);
        $img = $portfolio_all->portfilio_image;
        unlink($img);

        Portfilio::findOrFail($id)->delete();

        $notification = array(
           'message' => 'Portfilio Image Deleted Successfully!',
           'alert-type' => 'success'
       );

       return redirect()->back()->with($notification);
    }

    public function PortfolioDetails($id){
        // nó sắp xếp dữ liệu được tìm nạp, sử dụng cột 'created_at' để sắp xếp dữ liệu theo trình tự thời gian.
        $portfolio = Portfilio::findOrFail($id);
        return view('frontend.portfolio_details',compact('portfolio'));
    }
}
