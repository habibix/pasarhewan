@extends('layouts.app') @section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-8 col-lx-8">

            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <img class="mr-2 avatar-sm rounded-circle" src="http://127.0.0.1:8000/images/users/user-3.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                            <h5 class="m-0">{{ $post['user'] }}</h5>
                            <p class="text-muted"><small><a href="{{ url('post') }}/{{ $post['post_id'] }}">about 2 minuts ago</a></small></p>
                        </div>
                        <p class="text-muted"><small>burung</small></p>
                    </div>
                </div>

                @if(count($post['image']) > 0 )
                <div id="carouselExample mb-0" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($post['image'] as $key => $value)
                            @if($key == 0 )
                            <li data-target="#carouselExample" data-slide-to="{{ $key }}" class="active"></li>
                            @else
                            <li data-target="#carouselExample" data-slide-to="{{ $key }}"></li>
                            @endif
                        @endforeach
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach($post['image'] as $key => $value)
                        @if($key == 0 )
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="{{ asset('uploads') }}/{{ $value['image'] }}" alt="First slide">
                        </div>
                        @else
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="{{ asset('uploads') }}/{{ $value['image'] }}" alt="First slide">
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($post['post_content']))
                <div class="content-text mt-2">
                    <p class="card-text">{{ $post['post_content'] }}</p>
                </div>
                @endif

                <div class="mt-1 mb-1 align-right">
                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-reply"></i> Reply</a>
                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-heart-outline"></i> Like</a>
                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-share-variant"></i> Share</a>
                </div>

                @if(count($post['comments']) > 0)
                    <div class="card-body mb-3 pt-0">
                        @foreach($post['comments'] as $comment => $value)
                            <div class="media mt-2">
                                <a class="pr-2" href="#">
                                    <img src="{{ asset('images/users/user-4.jpg') }}" class="avatar-sm rounded-circle" alt="Generic placeholder image">
                                </a>
                                <div class="media-body comment-block">
                                    <span class="mt-0"><strong>{{ $value['comment_user'] }}</strong></span>
                                    <span>{{ $value['comment_content'] }}</span>
                                    <div><small class="text-muted">5 hours ago</small></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

                <div class="card-footer" style="padding-top: 6px;">
                    <div class="media mt-2">
                        <a class="pr-2" href="#">
                            <img src="http://127.0.0.1:8000/images/users/user-1.jpg" class="rounded-circle" alt="Generic placeholder image" height="31">
                        </a>
                        <div class="media-body">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Add Comment" aria-label="Add Comment">
                                <div class="input-group-append">
                                    <button class="btn btn-primary waves-effect waves-light" type="button">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection