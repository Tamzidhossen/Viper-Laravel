@extends('layouts.admin')
@section('content')
<div class="col-lg-12 m-auto">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="text-white text-center">FAQ List</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>SL</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
                @foreach ($faqs as $index=>$faq)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $faq->question }}</td>
                    <td>{{ Str::substr($faq->answer, 0, 50) }} <a href="{{ route('faq.show', $faq->id) }}">see more...</a></td>
                    <td class="d-flex">
                        <a href="{{ route('faq.show', $faq->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('faq.edit', $faq->id) }}" class="btn btn-primary mx-1">Edit</a>
                        <form action="{{ route('faq.destroy', $faq->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection