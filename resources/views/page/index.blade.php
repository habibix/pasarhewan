@section('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
<link href="{{ asset('css/rating.css') }}" rel="stylesheet" type="text/css" />
@endsection

@extends('layouts.app') @section('content')
<div class="container">
    <div class="ajax-load text-center" style="display:none">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>

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
            <div class="card-box">
        <ul class="nav nav-pills navtab-bg nav-justified">
            <li class="nav-item">
                <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                    Update Status
                </a>
            </li>
            <li class="nav-item">
                <a href="#sell" data-toggle="tab" aria-expanded="true" class="nav-link">
                    Jual
                </a>
            </li>
            <li class="nav-item">
                <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                    Settings
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="aboutme">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input name="post_type" type="hidden" value="status">
                    <div class="form-group">
                        <textarea name="post_text" id="" cols="30" rows="2" class="form-control" placeholder="Tulis yang anda pikirkan"></textarea>
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
                        <div class="gallery mt-2"></div>
                    </div>
                    <div class="form-group align-right">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div> <!-- end tab-pane -->
            <!-- end about me section content -->

            <div class="tab-pane" id="sell">

                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input name="post_type" type="hidden" value="sell">
                    <div class="form-group">
                        <input type="text" name="post_title" class="form-control" placeholder="Jual apa?">
                    </div>
                    <div class="form-group">
                        <input type="text" name="post_price" class="form-control" placeholder="Berapa harganya?">
                    </div>
                    <div class="form-group">
                        <textarea name="post_text" id="" cols="30" rows="2" class="form-control" placeholder="Keterangan?"></textarea>
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
                        <input name="post_image[]" type="file" multiple id="gallery-photo-sell" class="form-control-file">
                        <div class="gallery mt-2"></div>
                    </div>
                    <div class="form-group align-right">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>

            </div>
            <!-- end timeline content-->

            <div class="tab-pane" id="settings">
                Setting
            </div>
            <!-- end settings content-->

        </div> <!-- end tab-content -->
    </div> <!-- end card-box-->

            @if(!empty($posts))

            <!-- TIMELINE START -->

            <div id="timeline">

            @foreach ($posts as $post)
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
                                        <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" onclick="editPost()">Edit</a>
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
                                        <a id="{{ $post['post_id'] }}" class="dropdown-item" href="javascript: void(0);" onclick="editPost()">Edit</a>
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

            </div>

            <!-- TIMELINE END -->

            <!-- modal start -->
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
                                            <input name="detail-report" type="text" class="form-control" id="field-3" placeholder="Alasan Pelanggaran">
                                            <input id="report_id" type="hidden" name="post_id" value="">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="reportPost()">Laporkan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="con-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                                            <input name="detail-report" type="text" class="form-control" id="field-3" placeholder="Alasan Pelanggaran">
                                            <input id="report_id" type="hidden" name="post_id" value="">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="reportPost()">Laporkan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

                <!-- modal edit -->
                <!-- <div id="con-edit-modal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block; padding-right: 15px;" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-box">
                            <form action="{{ url('post') }}" method="PUT" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                <input name="post_type" type="hidden" value="sell">
                                <div class="form-group">
                                    <input type="text" name="post_title" class="form-control" placeholder="Jual apa?">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="post_price" class="form-control" placeholder="Berapa harganya?">
                                </div>
                                <div class="form-group">
                                    <textarea name="post_text" id="" cols="30" rows="2" class="form-control" placeholder="Keterangan?"></textarea>
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
                                    <input name="post_image[]" type="file" multiple id="gallery-photo-sell" class="form-control-file">
                                    <div class="gallery mt-2"></div>
                                </div>
                                <div class="form-group align-right">
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div> -->
                <!-- modal edit end -->

            <div class="text-center load-more">
                <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
            </div>

            @else

                Belum ada postingan 

            @endif

        </div>
    </div>
</div>
@endsection @section('footer')

<link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('js/rating.js') }}"></script>

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
    var page = 2;
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

                console.log(data);
            },

            error: function(data) {
                console.log("error " + data);
            }
        });
    }
</script>

<script type="text/javascript">
    

    function reportPost(){

        var post_id = $("#report_id").val();
        var detail = $("input[name$='detail-report']").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('post/report') }}",
            type: 'POST',
            data: {
                post_id: post_id,
                detail: detail,
            },

            success: function(data) {
                console.log(post_id);
                console.log(data);
                $('#con-close-modal').modal('hide');
            },

            error: function(data) {
                console.log("error " + data);
            }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

<script>
$( document ).ready(function() {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
});
</script>
<script>
    $('#star1').starrr({
      change: function(e, value){
        if (value) {
          $('.your-choice-was').show();
          $('.choice').text(value);
        } else {
          $('.your-choice-was').hide();
        }
      }
    });

    var $s2input = $('#star2_input');
    $('[id=star2]').starrr({
      max: 5,
      rating: $s2input.val(),
      change: function(e, value){
        //$s2input.val(value).trigger('input');
        console.log("star "+ value);
      }
    });
  </script>

<script type="text/javascript">
    function editPost(){

        var post_id = $(event.target).attr('id');
        console.log(post_id);

        $.ajax({
            url: "{{ url('/') }}/post/"+post_id+"/edit",
            type: 'GET',

            success: function(data) {
                $('#con-close-modal').modal('show');
                console.log('show');
            },

            error: function(data) {
                console.log("error " + data);
            }
        });
    }
</script>

@endsection