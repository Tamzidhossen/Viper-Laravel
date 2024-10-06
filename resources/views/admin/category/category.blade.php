@extends('layouts.admin')
@section('content')
    <div class="row">
        @can('category_access')
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white text-center">Category List</h3>
                </div>
                <div class="card-body">
                    @if (session('cat_update'))
                        <div class="alert alert-success">{{ session('cat_update') }}</div>
                    @endif
                    @if (session('cat_del'))
                        <div class="alert alert-success">{{ session('cat_del') }}</div>
                    @endif
                    <form action="{{ route('category.check.delete') }}" method="POST">
                        @csrf
                        <table class="table table-striped">
                            <tr>
                                <th width='50'>
                                    <div class="form-check">
                                        <label for="" class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id='chkSelectAll'>
                                            Check All
                                            <i class="input-frame"></i>
                                        </label>
                                    </div>
                                </th>
                                <th>SL</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($categories as $index=>$category )
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <label for="" class="form-check-label">
                                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input chkDel">
                                            <i class="input-frame"></i>
                                        </label>
                                    </div>                            
                                </td>
                                <td>{{ $index+1}}</td>
                                <td>{{ $category->category_name}}</td>
                                <td><img src="{{ asset('uploads/category/') }}/{{ $category->category_image }}" alt=""></td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-info">Edit</a>
                                    <a href="{{ route('category.delete', $category->id) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="5"><h3>No Data Available</></td>
                            </tr>
                            @endforelse
                        </table>
                        <div class="my-2">
                            <button type="submit" class="btn btn-danger del-ck d-none">Delete Checked</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
        @can('category_add')
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white text-center">Add New Category</h3>
                </div>
                <div class="card-body">
                    @if (session('category_added'))
                        <div class="alert alert-success">{{ session('category_added') }}</div>
                    @endif
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Category Name</label>
                            <input type="text" name="category_name" class="form-control">
                            @error('category_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="category_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            @error('category_image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <div class="my-2"><img src="" id="blah" width="200" alt=""></div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>
@endsection

@section('script')
<script>
    $("#chkSelectAll").on('click', function(){
        this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);
        $('.del-ck').toggleClass('d-none')
    })
    $(".chkDel").on('click', function(){
        $('.del-ck').removeClass('d-none')
    })
</script>
@endsection