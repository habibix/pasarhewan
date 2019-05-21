@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6">

        	@foreach($comments as $comment)
        		<a class="com-{{ $comment->id }}" href="{{ url('post') }}/{{ $comment->post_id }}">
		            <div class="card mb-1">
		                <div class="m-2">
		                    <strong>{{ $comment->name.' '.$comment->name_second }} </strong>{{ $comment->comment_content }}
		                    <small>{{ $comment->created_at }}</small>
		                </div>
		            </div>
	        	</a>
        	@endforeach

        </div>
    </div>
</div>
@endsection