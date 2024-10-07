@extends('frontend.master')
@section('content')
<section class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 m-auto">
                <div class="login-content">
                    <h4>Password Reset</h4>
                    <p></p>
                    @if (session('wrong'))
                        <div class="alert alert-danger">{{ session('wrong') }}</div>
                    @endif
                    <form  action="{{ route('pass.reset.sent') }}" class="sign-form widget-form " method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email*" name="email">
                            @if (session('exist'))
                                <strong class="text-danger">{{ session('exist') }}</strong>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-custom">Reset</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection