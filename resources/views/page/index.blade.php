@extends('layouts.app')

@section('content')
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="col-lg-8 col-lx-8">
                    <div class="card">
                        <div class="card-header">
                            Create Post
                        </div>

                        <div class="card-body">

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
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
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
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

<!-- TIMELINE START -->
@foreach ($posts as $post)
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <img class="mr-2 avatar-sm rounded-circle" src="{{asset('images/users/user-3.jpg')}}" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="m-0">{{ $post['user'] }}</h5>
                                    <p class="text-muted"><small>about 2 minuts ago</small></p>
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
                                    <img class="d-block img-fluid" src="{{asset('images/small/img-4.jpg')}}" alt="First slide">
                                </div>
                                @else
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{asset('images/small/img-4.jpg')}}" alt="First slide">
                                </div>
                                @endif
                                @endforeach
                                
                            </div>
                        </div>

                        @endif

                        <div class="content-text">
                            <p class="card-text">{{ $post['post_content'] }}</p>
                        </div>

                        <div class="mt-2">
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