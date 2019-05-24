@extends('layouts.app') @section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-lx-6">

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

            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PUT">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">

                        <div class="text-center">
                            @if($user->image_profile != NULL)
                                <img src="{{ $user->image_profile }}" class="rounded-circle avatar-lg img-thumbnail avatar-xxl" id="imagePreview" alt="profile-image">
                            @else
                                <img src="https://coderthemes.com/ubold/layouts/purple/assets/images/users/user-1.jpg" class="rounded-circle avatar-lg img-thumbnail avatar-xxl" id="imagePreview" alt="profile-image">
                            @endif
                            
                            <p><a href="javascript: void(0);" class="editLink" onclick="changeImage()">Ganti Foto</a></p>
                            <input type="file" name="profile_picture" id="fileInput"  style="display:none"/>
                        </div>

                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Enter first name" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Enter last name" value="{{ $user->name_second }}">
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userbio">Bio</label>
                                    <textarea name="about" class="form-control" id="userbio" rows="4" placeholder="Write something...">{{ $user->profile->about }}</textarea>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="{{ $user->profile->gender }}"> {{ ucfirst($user->profile->gender) }}</option>

                                        @if(strtolower($user->profile->gender) == '')
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        @else
                                            @if(strtolower($user->profile->gender) == 'perempuan'){
                                                <option value="laki-laki">Laki-laki</option>
                                            @else
                                                <option value="perempuan">Perempuan</option>
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_birth">Tanggal Lahir</label>
                                    <input class="form-control" id="date_birth" type="date" name="date_birth" value="{{ $user->profile->date_birth }}">
                                </div>
                            </div>
                            <!-- end col -->
                        </div>

                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Account Info</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="useremail">Email Address</label>
                                    <input name="email" class="form-control" id="useremail" placeholder="Enter email" value="{{ $user->email }}">

                                </div>

                                <div class="form-group">
                                    <label for="useremail">Phone Number</label>
                                    <input name="no_hp" class="form-control" id="useremail" placeholder="Enter email" value="{{ $user->profile->no_hp }}">
                                </div>

                                <div class="form-group">
                                    <label for="useremail">WhatsApp Number</label>
                                    <input name="no_wa" class="form-control" id="useremail" placeholder="Enter email" value="{{ $user->profile->no_wa }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input name="new_password" type="new_password" class="form-control" id="userpassword" placeholder="Enter New password">
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input name="old_password" type="old_password" class="form-control" id="userpassword" placeholder="Enter password">
                                </div>

                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-box -->

        </div>
    </div>
</div>
@endsection

@section('footer')

<script type="text/javascript">

$(document).ready(function(){
  $(".editLink").on('click', function(e){
        e.preventDefault();
        $("#fileInput:hidden").trigger('click');
    });
});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#fileInput").change(function(){
        readURL(this);
    });
</script>

@endsection