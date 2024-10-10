@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white text-center">Edit FAQ</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" value="{{ $faq->question }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <input type="text" name="answer" class="form-control" value="{{ $faq->answer }}">
                        {{-- <textarea name="answer" id="" cols="30" rows="3" class="form-control"></textarea> --}}
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Faq</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection