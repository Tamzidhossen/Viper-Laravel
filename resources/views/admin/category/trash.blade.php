@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white text-center">Trash Category List</h3>
            </div>
            <div class="card-body">
                @if (session('restore'))
                    <div class="alert alert-success">{{ session('restore') }}</div>
                @endif
                @if (session('del'))
                    <div class="alert alert-success">{{ session('del') }}</div>
                @endif
                <form action="{{ route('category.check.restore') }}" method="POST">
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
                        @forelse ($trash_cat as $index=>$category )
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
                                <a href="{{ route('category.restore', $category->id) }}" class="btn btn-info">Restore</a>
                                <a data-link="{{ route('category.hard.delete', $category->id) }}" class="btn btn-danger del">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="5"><h3>Trash is Empty</h3></td>
                        </tr>
                        @endforelse
                    </table>
                    <div class="my-2">
                        <button name="action_btn" value="1" type="submit" class="btn btn-info del-ck d-none">Restore</button>
                        <button name="action_btn" value="2" type="submit" class="btn btn-danger del-ck d-none">Delete Checked</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.del').click(function(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            var link = $(this).attr('data-link');
            window.location.href = link;
        }
        });
    })
</script>

@if (session('pdel'))
    <script>
        Swal.fire({
        title: "Deleted!",
        text: "{{ session('pdel') }}",
        icon: "success"
        });
    </script>
@endif
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