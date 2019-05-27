@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6 inbox-widget">

        	@foreach($comments as $comment)
        		<a class="com-{{ $comment->id }}" href="{{ url('post') }}/{{ $comment->post_id }}">
        			<div class="inbox-item card mb-1 p-1">
                        <p class="inbox-item-author"><strong>{{ $comment->name.' '.$comment->name_second }} </strong></p>
                        <p class="inbox-item-text"> {{ $comment->comment_type }} postingan anda</p>
                        <p class="inbox-item-date">
                            <a href="{{ url('post') }}/{{ $comment->post_id }}" class="btn btn-sm btn-link text-info font-13"> <small>{{ $comment->created_at }}</small> </a>
                        </p>
                    </div>

		            <!-- <div class="card mb-1">
		                <div class="m-2">
		                	<div class="inbox-item-img"><img src="{{ $comment->image_profile }}" class="rounded-circle" alt=""></div>
		                    <small>{{ $comment->created_at }}</small>
		                </div>
		            </div> -->
	        	</a>
        	@endforeach

        </div>
    </div>
</div>
@endsection