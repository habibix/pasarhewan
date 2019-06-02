@section('header')

@endsection

@extends('layouts.app') @section('content')
<div class="container">
    <div class="ajax-load text-center" style="display:none">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>

    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6">

            <div class="card">
                <div class="card-header">
                    Create Post
                </div>

                <div class="card-body">

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

                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <textarea name="post_text" id="" cols="30" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <select name="post_category" class="form-control">
                                <option>-- Kategori --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ ucfirst($category->category) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file">Photo</label>
                            <input name="post_image[]" type="file" multiple id="gallery-photo-add" class="form-control-file">
                            <div class="gallery"></div>
                        </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-primary float-right">Post</button>
                </div>
                </form>
            </div>

            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item float-right">
                            <a class="nav-link card-link text-custom" href="/">Semua</a>
                        </li>

                        @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('c')}}/{{ $category->category }}">{{ ucfirst($category->category) }}</a>
                        </li>
                        @endforeach

                        <li class="nav-item float-right">
                            <a class="nav-link card-link text-custom" href="{{ url('/c') }}">Lihat Selengkapnya</a>
                        </li>
                    </ul>
                </div>

            </div>

            @if(!empty($posts))

            <!-- TIMELINE START -->

            <div id="timeline">

            @foreach ($posts as $post)
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
                        
                        <div class="dropdown">

                            <a class="dropdown-toggle dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal mdi-24px"></i>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                                @if(Auth::user()->id == $post['user_id'])
                                <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" >Edit</a>
                                <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" onclick="deletePost()">Delete</a>
                                @endif
                                <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" data-toggle="modal" data-target="#con-close-modal" onclick="report()" >Report</a>
                            </div>
                        </div>

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

            </div>

            <!-- TIMELINE END -->

            <!-- modal start -->
            <form action="{{ route('post-report') }}" method="POST">
                <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Laporkan postingan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body p-2">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Alasan</label>
                                            <input type="text" class="form-control" id="field-3" placeholder="Alasan Pelanggaran">
                                            <input id="report_id" type="hidden" name="post_id" value="">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light">Laporkan</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->
            </form>

            <div class="text-center load-more">
                <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
            </div>

            @else Belum ada postingan @endif

        </div>
    </div>
</div>
@endsection @section('footer')

<script type="text/javascript">
    function report(){
        var post_id = $(event.target).attr('id');
        $('#report_id').val(post_id);
    }
</script>

<script type="text/javascript">
    function likePost() {

        var post_id = $(event.target).attr('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log(post_id);

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

<script type="text/javascript">
    var page = 1;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            if (page > {{ $paginate['last_page'] }} ) {
                $('.load-more').html("Tidak ada postingan");
               return false;
            } else {
                loadMoreData(page);
            }
            page++;
        }
    });

    function loadMoreData(page){
      $.ajax(
            {
                url: '?page=' + page,
                type: "get",
                beforeSend: function()
                {
                    $('.load-more').show();
                }
            })
            .done(function(data)
            {
                console.log(data)
                
                $("#timeline").append(data.html);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                  console.log("server error response");
            });
    }
</script>

<script type="text/javascript">
    function deletePost(){

        var post_id = $(event.target).attr('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('post/delete') }}",
            type: 'POST',
            data: {
                post_id: post_id,
            },

            success: function(data) {
                if(data.data == true){
                    $('#post-'+post_id).remove();
                }
            },

            error: function(data) {
                console.log("error " + data);
            }
        });
    }
</script>
@endsection