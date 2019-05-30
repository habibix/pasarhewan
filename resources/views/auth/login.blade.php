@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6">

            <!-- START -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mb-3 header-title">Login</h4>

                                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkmeout0" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="checkmeout0">Remember Me</label>
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>

                                            <div class="form-group mt-2">
                                                <a href="{{ route('password.request') }}">Forgot Your Password? </a>
                                            </div>
                                            
                                        </form>



                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <a href="{{ url('/register') }}" class="btn btn-primary waves-effect waves-light col-lg-12">Register</a>

                            </div>
                            <!-- END -->
                    
        </div>
    </div>
</div>
@endsection
