@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white text-center">Faq View</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Question</td>
                        <td>{{ $faq->question }}</td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td class="text-wrap" style="line-height: 24px">{{ $faq->answer }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection