@foreach ($data as $post)

@if($post['post_type'] == 'sell')
<!-- sell -->
    <div class="card-box product-box" id="post-{{ $post['post_id'] }}">
        <div class="media">

                @if($post['profile_image'] != NULL)
                    <img class="mr-2 avatar-sm rounded-circle" src="{{ $post['profile_image'] }}" alt="Image profile"> 
                @else
                    <img class="mr-2 avatar-sm rounded-circle" src="https://3.bp.blogspot.com/-LPjYeDMJi5o/XOUSqoN6G9I/AAAAAAAADj8/8qM42tR95xsn-X556dFIUiJQKJc1de-5wCLcBGAs/s1600/blank-profile.jpg" alt="Generic placeholder image">
                @endif

                <div class="media-body">
                    <h5 class="m-0">
                        <a href="{{ url('profile') }}/{{ $post['user_id'] }}">{{ $post['user_full_name'] }}</a>
                    </h5>
                    <p class="text-muted">
                        <small><a href="{{ url('post') }}/{{ $post['post_id'] }}">{{ $post['time'] }}</a></small>
                    </p>
                </div>
                
                <div class="dropdown">

                    <a class="dropdown-toggle dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal mdi-24px"></i>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                        @if(Auth::user()->id == $post['user_id'])
                            <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" >Edit</a>
                            <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" onclick="deletePost()">Delete</a>
                        @else
                            <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" data-toggle="modal" data-target="#con-close-modal" onclick="report()" >Report</a>
                        @endif
                        
                    </div>
                </div>

            </div>
        <div class="product-action">
            
        </div>

        <div>

            @foreach($post['image'] as $key => $value)
                @if($key > 0)
                    
                    <a id="show-{{ $post['post_id'] }}" href="{{ url('images/post') }}/{{ $value['image'] }}" data-toggle="lightbox" data-gallery="post-{{ $post['post_id'] }}" style="display: none;">
                        <img src="{{ url('images/post') }}/{{ $value['image'] }}" class="img-fluid">
                    </a>

                @else

                <a id="show-{{ $post['post_id'] }}" href="{{ url('images/post') }}/{{ $value['image'] }}" data-toggle="lightbox" data-gallery="post-{{ $post['post_id'] }}">
                        <img src="{{ url('images/post') }}/{{ $value['image'] }}" class="img-fluid">
                    </a>
                                            
                @endif
                
            @endforeach

            

        </div>

        <div class="product-info">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="font-16 mt-0 sp-line-1"><a href="{{ url('post') }}/{{ $post['post_id'] }}" class="text-dark">{{ $post['post_sell_title'] }}</a> </h5>
                    <div class="text-warning mb-2 font-13">
                        <div class='starrr' id='star2'></div>
                        <br />
                    </div>
                    <h5 class="m-0"> 
                        <span class="text-muted"> <a href="{{ url('profile') }}/{{ $post['user_id'] }}" class="text-dark">{{ $post['user_full_name'] }}</a></span>
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="product-price-tag">
                        Rp. {{ $post['post_price'] }}
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end product info-->
    </div>
<!-- end sell -->
@else
    <div class="card" id="post-{{ $post['post_id'] }}">
        <div class="card-body">

            <div class="media">

                @if($post['profile_image'] != NULL)
                    <img class="mr-2 avatar-sm rounded-circle" src="{{ $post['profile_image'] }}" alt="Image profile"> 
                @else
                    <img class="mr-2 avatar-sm rounded-circle" src="https://3.bp.blogspot.com/-LPjYeDMJi5o/XOUSqoN6G9I/AAAAAAAADj8/8qM42tR95xsn-X556dFIUiJQKJc1de-5wCLcBGAs/s1600/blank-profile.jpg" alt="Generic placeholder image">
                @endif

                <div class="media-body">
                    <h5 class="m-0">
                        <a href="{{ url('profile') }}/{{ $post['user_id'] }}">{{ $post['user_full_name'] }}</a>
                    </h5>
                    <p class="text-muted">
                        <small><a href="{{ url('post') }}/{{ $post['post_id'] }}">{{ $post['time'] }}</a></small>
                    </p>
                </div>
                
                <div class="dropdown">

                    <a class="dropdown-toggle dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal mdi-24px"></i>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                        @if(Auth::user()->id == $post['user_id'])
                            <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" >Edit</a>
                            <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" onclick="deletePost()">Delete</a>
                        @else
                            <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" data-toggle="modal" data-target="#con-close-modal" onclick="report()" >Report</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        @if(count($post['image']) > 0 )

        <div class="row image-galery">
            
            @foreach($post['image'] as $key => $value)
                @if($key > 0)
                    
                        <a id="show-{{ $post['post_id'] }}" href="{{ url('images/post') }}/{{ $value['image'] }}" data-toggle="lightbox" data-gallery="post-{{ $post['post_id'] }}" class="col-sm-12" style="display: none;">
                            <img src="{{ url('images/post') }}/{{ $value['image'] }}" class="img-fluid">
                        </a>

                @else

                <a id="show-{{ $post['post_id'] }}" href="{{ url('images/post') }}/{{ $value['image'] }}" data-toggle="lightbox" data-gallery="post-{{ $post['post_id'] }}" class="col-sm-12">
                        <img src="{{ url('images/post') }}/{{ $value['image'] }}" class="img-fluid">
                    </a>
                                            
                @endif
                
            @endforeach

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
@endif
    
@endforeach