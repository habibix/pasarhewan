@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
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
                        <textarea name="post_text" class="form-control" placeholder="Apa yang sedang anda pikirkan?"></textarea>
                      </div>
                      <div class="form-group">
                        <input name="post_image[]" type="file" id="exampleInputFile" multiple>
                      </div>
                      <div class="form-group">
                        <!-- <input type="text" placeholder="Pilih Kategori" readonly="readonly" class="form-control"> -->
                        <select name="post_category" class="form-control">
                          <option>-- Kategori --</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                          @endforeach
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary pull-right">Post</button>
                    </form>
                </div>
            </div>

            @foreach ($posts as $post)
                <div class="panel panel-default">
                <div class="panel-body">
                  <div class="form-group">
                    <label>{{ $post['category'] }}</label>
                  </div>
                  <div class="form-group">
                        <img src="https://pengicau.net/wp-content/uploads/2018/11/Harga-Lovebird-Perso.jpg" alt="image" class="img-circle ipl">
                        <label class="name-p">{{ $post['user'] }}</label>
                        <i class="dots fa fa-ellipsis-h pull-right"></i>
                  </div>

                  <div class="form-group">
                        @if(count($post['image']) > 0 )
                          @foreach($post['image'] as $image)
                          <img src="{{ url('/uploads') }}/{{ $image['image'] }}" alt="image" class="w-100">
                          @endforeach
                        @endif
                          <p class="post">{{ $post['post_content'] }}</p>
                  </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default">
                            <span class="fa fa-thumbs-up"> Like </span></button>
                      </div>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default">
                            <span class="fa fa-comment"> Comment </span></button>
                      </div>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default">
                            <span class="fab fa-whatsapp"> Contact </span></button>
                      </div>
                    </div>
                    <div class="form-group comment">
                      <input type="text" name="comment-id" placeholder="Write Comment.." class="form-control" />
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection