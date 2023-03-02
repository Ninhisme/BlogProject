<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Image;
use Illuminate\Support\Carbon;


class BlogController extends Controller
{
    public function AllBlog(){
        // nó sắp xếp dữ liệu được tìm nạp, sử dụng cột 'created_at' để sắp xếp dữ liệu theo trình tự thời gian.
        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all',compact('blogs'));
    }

    public function AddBlog(){
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_add',compact('categories'));

    }

    public function StoreBlog(Request $request){
         //chuyen doi ten anh va dua vao file chua
         $image = $request->file('blog_image');
         $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //2212.jpg

         Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);
         $save_url ='upload/blog/'.$name_gen;

         //Update database
         Blog::insert([
             'blog_category_id' => $request->blog_category_id,
             'blog_title' => $request->blog_title,
             'blog_tags' => $request->blog_tags,
             'blog_description' => $request->blog_description,
             'blog_image' =>  $save_url,
             'created_at' => Carbon::now()

         ]);

         $notification = array(
             'message' => 'Blog Insert Successfully!',
             'alert-type' => 'success'
         );
 
         return redirect()->route('all.blog')->with($notification);
    }

    public function EditBlog($id){
        $blogs = Blog::findOrFail($id);
        return view('admin.blogs.blogs_edit',compact('blogs'));
    }

}
