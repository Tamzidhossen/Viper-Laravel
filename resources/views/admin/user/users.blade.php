@extends('layouts.admin')
@section('content')
<div class="row">
    @can('users')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white text-center">User List</h3>
            </div>
            <div class="card-body">
                @if (session('del'))
                    <div class="alert alert-success">{{ session('del') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Photo</th>
                            @can('user_delete')
                                <th>Action</th>
                            @endcan
                        </tr>
                        @foreach ( $users as $index=>$user )
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->photo == null)
                                    <img src="{{ asset('frontend_asset') }}/img/author/6.jpg" alt="profile">
                                @else
                                <img src="{{ asset('uploads/user') }}/{{ $user->photo }}" width="100" alt="">
                                @endif
                            </td>
                            @can('user_delete')
                            <td>
                                <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('user_add')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white text-center">Add New User</h3>
            </div>
            <div class="card-body">
                @if (session('add_user'))
                    <div class="alert alert-success">{{ session('add_user') }}</div>
                @endif
                <form action="{{ route('add.user') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection