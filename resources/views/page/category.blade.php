@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6">

            <div class="card">
                <div class="card-header">
                    Kategori
                </div>

                <ul class="pl-0">
                    @foreach ($categories as $category)
                        <li class="cat-list-p"><a href="{{ url('/c/') }}/{{ $category->category }}">{{ $category->category }}</a></li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection