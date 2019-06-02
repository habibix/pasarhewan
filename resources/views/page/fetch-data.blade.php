@foreach ($data as $post)
<div class="card" id="post-{{ $post['post_id'] }}">
                <div class="card-body">

                    <div class="media">

                        @if($post['profile_image'] != NULL)
                        <img class="mr-2 avatar-sm rounded-circle" src="{{ $post['profile_image'] }}" alt="Generic placeholder image"> @else
                        <img class="mr-2 avatar-sm rounded-circle" src="https://3.bp.blogspot.com/-LPjYeDMJi5o/XOUSqoN6G9I/AAAAAAAADj8/8qM42tR95xsn-X556dFIUiJQKJc1de-5wCLcBGAs/s1600/blank-profile.jpg" alt="Generic placeholder image"> @endif

                        <div class="media-body">
                            <h5 class="m-0"><a href="{{ url('profile') }}/{{ $post['user_id'] }}">{{ $post['user_full_name'] }}</a></h5>
                            <p class="text-muted"><small><a href="{{ url('post') }}/{{ $post['post_id'] }}">{{ $post['time'] }}</a></small></p>
                        </div>
                        
                        @if(Auth::user()->id == $post['user_id'])
                        <div class="dropdown">

                            <a class="dropdown-toggle dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal mdi-24px"></i>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                                <a class="dropdown-item" href="#" >Edit</a>
                                <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" onclick="deletePost()">Delete</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @if(count($post['image']) > 0 )

                <div id="carouselExample" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($post['image'] as $key => $value) @if($key == 0 )
                        <li data-target="#carouselExample" data-slide-to="{{ $key }}" class="active"></li>
                        @else
                        <li data-target="#carouselExample" data-slide-to="{{ $key }}"></li>
                        @endif @endforeach
                        <!-- <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExample" data-slide-to="1"></li> -->
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach($post['image'] as $key => $value) @if($key == 0 )
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="{{ asset('uploads') }}/{{ $value['image'] }}" alt="First slide">
                        </div>
                        @else
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="{{ asset('uploads') }}/{{ $value['image'] }}" alt="First slide">
                        </div>
                        @endif @endforeach

                    </div>
                </div>

                @endif @if(!empty($post['post_content']))
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
@endforeach