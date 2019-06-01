@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6 inbox-widget">

            @foreach($notifications as $notification)
                <a class="com-{{ $notification['id'] }}" href="{{ url('post') }}/{{ $notification['post_id'] }}">
                    <div class="inbox-item card mb-1 p-1">
                        <p class="inbox-item-author"><strong>{{ $notification['name'].' '.$notification['name_second'] }} </strong></p>
                        <p class="inbox-item-text"> {{ $notification['comment_type'] }} postingan anda</p>
                        <p class="inbox-item-date">
                            <a href="{{ url('post') }}/{{ $notification['post_id'] }}" class="btn btn-sm btn-link text-info font-13"> <small>{{ $notification['created_at'] }}</small> </a>
                        </p>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
    $( document ).ready(function() {
        clearNotif();
    });
</script>
@endsection