@extends('layouts.app') @section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6">

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="media">
                        @if($post['profile_image'] != NULL)
                        <img class="mr-2 avatar-sm rounded-circle" src="{{ $post['profile_image'] }}" alt="Generic placeholder image"> @else
                        <img class="mr-2 avatar-sm rounded-circle" src="https://3.bp.blogspot.com/-LPjYeDMJi5o/XOUSqoN6G9I/AAAAAAAADj8/8qM42tR95xsn-X556dFIUiJQKJc1de-5wCLcBGAs/s1600/blank-profile.jpg" alt="Generic placeholder image"> @endif
                        <div class="media-body">
                            <h5 class="m-0"><strong><a href="{{ url('profile') }}/{{ $post['user_id'] }}">{{ $post['user'] }}</a></strong></h5>
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
                    <a id="post-{{ $post['post_id'] }}" href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-reply"></i> Reply</a>
                    @if($post['liked'] == 1)
                        <a id="post-{{ $post['post_id'] }}" onclick="likePost()" href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i id="icon-{{ $post['post_id']}}" class="mdi mdi-heart icon-pink"></i> Like</a>
                    @else
                        <a id="post-{{ $post['post_id'] }}" onclick="likePost()" href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i id="icon-{{ $post['post_id']}}" class="mdi mdi-heart-outline"></i> Like</a>
                    @endif
                    
                    <a id="post-{{ $post['post_id'] }}" href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i class="mdi mdi-share-variant"></i> Share</a>
                </div>

                @if(count($post['comments']) > 0)
                    <div class="card-body mb-3 pt-0">
                        @foreach($post['comments'] as $comment => $value)
                            <div class="media mt-2">
                                <a class="pr-2" href="#">
                                    @if($value['comment_user_picture'] != NULL)
                                    <img class="mr-2 avatar-sm rounded-circle" src="{{ $value['comment_user_picture'] }}" alt="Generic placeholder image"> @else
                                    <img class="mr-2 avatar-sm rounded-circle" src="https://3.bp.blogspot.com/-LPjYeDMJi5o/XOUSqoN6G9I/AAAAAAAADj8/8qM42tR95xsn-X556dFIUiJQKJc1de-5wCLcBGAs/s1600/blank-profile.jpg" alt="Generic placeholder image"> @endif
                                </a>
                                <div class="media-body comment-block">
                                    <span class="mt-0"><strong><a href="{{ url('/profile') }}/{{ $value['comment_user_id'] }}">{{ $value['comment_user'] }}</a></strong></span>
                                    <span>{{ $value['comment_content'] }}</span>
                                    <div><small class="text-muted">5 hours ago</small></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="card-footer" style="padding-top: 6px;">
                    <div class="media mt-2">
                        <div class="media-body">
                            <form method="post" action="{{ url('/comment') }}">
                                <div id="comment-{{$post['post_id']}}" class="input-group">
                                    <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                                    <input name="post_id" type="hidden" value="{{ $post['post_id'] }}">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <input id="comment-{{$post['post_id']}}" name="comment_content" type="text" class="form-control" placeholder="Add Comment" aria-label="Add Comment">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" type="button" disabled>Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('footer')

<script type="text/javascript">
    function likePost() {

        var post_id = $(event.target).attr('id');
        console.log(post_id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('post/like') }}",
            type: 'POST',
            data: {
                post_id: post_id.replace('post-', ''),
            },

            success: function(data) {

                if(data.liked == 1){
                    $('i#icon-'+data.data['post_id']).removeClass( "mdi-heart icon-pink" ).addClass( "mdi-heart-outline" );
                } else {
                    $('i#icon-'+data.data['post_id']).removeClass( "mdi-heart-outline" ).addClass( "mdi-heart icon-pink" );
                }
                
                console.log(data);
                
                //console.log(coba);
            },

            error: function(data) {
                console.log("error " + data);
            }
        });
    }
</script>

<script type="text/javascript">
 
$("input[id*=comment-]").keyup(function () {
    if ($(this).val()) {
        $(this).siblings("div.input-group-append").children("button").removeAttr('disabled');
    }
    else {
        $(this).siblings("div.input-group-append").children("button").attr("disabled", true);
    }
});
 
</script>
@endsection