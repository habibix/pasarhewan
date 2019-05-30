@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6">

            <!-- START -->
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Register</h4>

                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Nama Depan</label>

                            <input placeholder="Nama Depan" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus> @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span> @endif

                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname">Nama Belakang</label>

                            <input placeholder="Nama Belakang" id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus> @if ($errors->has('lastname'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span> @endif

                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Alamat E-Mail</label>

                            <input placeholder="Alamat E-Mail" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required> @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>

                            <input placeholder="Password" id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif

                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>

                            <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Register</button>
                        </div>
                    </form>

                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->

            <a href="{{ url('/login') }}" class="btn btn-primary waves-effect waves-light col-lg-12">Login</a>

        </div>
        <!-- END -->

    </div>
</div>
</div>
@endsection