@extends('admin.admin_master')
@section('admin')

<style type="text/css">
    .bootstrap-tagsinput .tag{
        margin-right: 2px;
        color: #b70000;
        font-weight: 700px;
    } 
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title">Portfolio Page</h4>
                            <form action="{{route('store.blog')}}" method="post" enctype="multipart/form-data">
                                @csrf


                            
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blogs Category Name</label>
                                    <div class="col-sm-10">
                                        <select name="blog_category_id" class="form-select" aria-label="Default select example">
                                            <option selected="">Open this select menu</option>
                                            @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->blog_category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blogs Title</label>
                                    <div class="col-sm-10">
                                        <input name="blog_title" class="form-control" type="text"  id="example-text-input">
                                        @error('blog_title')
                                            <span class="text-danger"> {{$message}} </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blogs Tags</label>
                                    <div class="col-sm-10">
                                        <input name="blog_tags" value="home,tech,js" class="form-control" type="text" data-role="tagsinput" id="example-text-input">
                                        
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blogs Description</label>
                                    <div class="col-sm-10">
                                        <textarea id="elm1" name="blog_description"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blogs Image</label>
                                    <div class="col-sm-10">
                                        <input name="blog_image" class="form-control" type="file" id="image">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded avatar-lg" src="{{ url('upload/no_image.jpg')}}" alt="Card image cap">
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Insert Blog Data">
                            </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
</div>

{{-- Thay doi anh khi chon anh khac --}}
<script type="text/javascript">

    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });

    });

</script>

@endsection

