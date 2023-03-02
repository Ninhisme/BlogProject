<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory(){
        // nó sắp xếp dữ liệu được tìm nạp, sử dụng cột 'created_at' để sắp xếp dữ liệu theo trình tự thời gian.
        $blogcategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all',compact('blogcategory'));
    }// End Method

    public function AddBlogCategory(){
        return view('admin.blog_category.blog_category_add');

    }

    public function StoreBlogCategory(Request $request){
        $request->validate([
            'blog_category' => 'required'
        ],[
            // tu dien loi khi khong thoa ma yeu cau
            'blog_category.required' => 'Blog Category Name is Required',
  
        ]);
         //Update database
         BlogCategory::insert([
             'blog_category' => $request->blog_category	,


         ]);

         $notification = array(
             'message' => 'Blog Category Insert Successfully!',
             'alert-type' => 'success'
         );
 
         return redirect()->route('all.blog.category')->with($notification);
    }

    public function EditBlogCategory($id){
        $blogcategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit',compact("blogcategory"));
    }

    public function UpdateBlogCategory(Request $request){
        $blogcategory_id = $request->id;
        BlogCategory::findOrFail($blogcategory_id)->update([
            'blog_category' => $request->blog_category	,
            ]);

            $notification = array(
                'message' => 'Blog Category Update Successfully!',
                'alert-type' => 'success'
            );
    
        return redirect()->route('all.blog.category')->with($notification);
        
    }
    

    public function DeleteBlogCategory($id){

        BlogCategory::findOrFail($id)->delete();

        $notification = array(
           'message' => 'Blog Category Deleted Successfully!',
           'alert-type' => 'success'
       );

       return redirect()->back()->with($notification);
    }

}