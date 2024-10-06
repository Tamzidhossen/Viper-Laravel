@extends('frontend.author.admin')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="text-white text-center">Edit Profile</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('author.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::guard('author')->user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::guard('author')->user()->email }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @if (Auth::guard('author')->user()->photo != null)
                        <div class="my-2">
                            <img src="{{ asset('uploads/author') }}/{{ Auth::guard('author')->user()->photo }}" id="blah" width="200">
                        </div>
                        @endif
                        
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="text-white text-center">Update Password</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('author.pass.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                        @if (session('wrong'))
                            <strong class="text-danger">{{ session('wrong') }}</strong>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection