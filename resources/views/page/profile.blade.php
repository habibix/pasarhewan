@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6">

            <div class="card-box text-center">
                <img src="{{ asset('images/users/user-1.jpg') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                <h4 class="mb-0">{{ $user['user_name'] }}</h4>
                <p class="text-muted">{{ $user['user_about'] }}</p>

                <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button>

                <div class="text-left mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">{{ $user['user_full_name'] }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Phone :</strong><span class="ml-2">{{ $user['user_no'] }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>WhatsApp :</strong><span class="ml-2">{{ $user['user_wa'] }}</span></p>

                    <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span class="ml-2">{{ $user['user_kab_kota'] }}</span></p>
                </div>

                <ul class="social-list list-inline mt-3 mb-0">
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                    </li>
                </ul>
            </div>
            <!-- end card-box -->


            <!-- TIMELINE START -->
@foreach ($user_post as $post)
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <img class="mr-2 avatar-sm rounded-circle" src="{{asset('images/users/user-3.jpg')}}" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="m-0">{{ $post['user'] }}</h5>
                                    <p class="text-muted"><small><a href="{{ url('post') }}/{{ $post['post_id'] }}">about 2 minuts ago</a></small></p>
                                </div>
                                <p class="text-muted"><small>{{ $post['category'] }}</small></p>
                            </div>
                        </div>

                        @if(count($post['image']) > 0 )
                          
                        <div id="carouselExample" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($post['image'] as $key => $value)
                                    @if($key == 0 )
                                    <li data-target="#carouselExample" data-slide-to="{{ $key }}" class="active"></li>
                                    @else
                                    <li data-target="#carouselExample" data-slide-to="{{ $key }}"></li>
                                    @endif
                                @endforeach
                                <!-- <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExample" data-slide-to="1"></li> -->
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

                        <div class="card-footer" style="padding-top: 6px;">
                            <div class="media mt-2">
                                <a class="pr-2" href="#">
                                    <img src="{{asset('images/users/user-1.jpg')}}" class="rounded-circle" alt="Generic placeholder image" height="31">
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
@endforeach
<!-- TIMELINE END -->

        </div>
    </div>
</div>
@endsection