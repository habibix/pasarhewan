<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Anishop - Situs Jual Beli Hewan Piara Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Situs Jual Beli Binatang Hewan Peliharaan Online" name="description" />
    <meta content="Anishop" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="asset/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />

    @yield('header')

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">
        
        @include('layouts.navbar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        
        @yield('content')

        <!-- ============================================================== -->
        <!-- End Page Content here -->
        <!-- ============================================================== -->

        @include('layouts.footer')
    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0 text-white">Settings</h5>
        </div>
        <div class="slimscroll-menu">
            <!-- User box -->
            <div class="user-box">
                <div class="user-img">
                    <img src="{{ asset('images/users/user-1.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                    <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                </div>

                <h5><a href="javascript: void(0);">Geneva Kennedy</a> </h5>
                <p class="text-muted mb-0"><small>Admin Head</small></p>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h5 class="pl-3">Basic Settings</h5>
            <hr class="mb-0" />

            <div class="p-3">
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox1" type="checkbox" checked>
                    <label for="Rcheckbox1">
                        Notifications
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox2" type="checkbox" checked>
                    <label for="Rcheckbox2">
                        API Access
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox3" type="checkbox">
                    <label for="Rcheckbox3">
                        Auto Updates
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox4" type="checkbox" checked>
                    <label for="Rcheckbox4">
                        Online Status
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-0">
                    <input id="Rcheckbox5" type="checkbox" checked>
                    <label for="Rcheckbox5">
                        Auto Payout
                    </label>
                </div>
            </div>

            <!-- Timeline -->
            <hr class="mt-0" />
            <h5 class="pl-3 pr-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
            <hr class="mb-0" />
            <div class="p-3">
                <div class="inbox-widget">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ asset('images/users/user-2.jpg') }}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                        <p class="inbox-item-text">I've finished it! See you so...</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ asset('images/users/user-3.jpg') }}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ asset('images/users/user-4.jpg') }}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                        <p class="inbox-item-text">Nice to meet you</p>
                    </div>

                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ asset('images/users/user-5.jpg') }}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                        <p class="inbox-item-text">Hey! there I'm available...</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{ asset('images/users/user-6.jpg') }}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                    </div>
                </div>
                <!-- end inbox-widget -->
            </div>
            <!-- end .p-3-->

        </div>
        <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script>
        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img width="100">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#gallery-photo-add').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });
        });
    </script>

    <script>
        
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: 'http://127.0.0.1:8000/notif/nc',
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(data);
                if(data > 0)
                    $("#noticon").append('<span class="badge badge-danger rounded-circle noti-icon-badge">'+data+'</span>')
                //$(".noti-icon-badge").html(data)   //// For replace with previous one
            },
            error: function() { 
                console.log(data);
            }
        });

    </script>
    <script type="text/javascript">
        $('.noti-icon').on('click', function() {
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: 'http://127.0.0.1:8000/notif/nl',
                success: function (data) {
                    //var obj = JSON.parse(data);
                    //console.log(data);
                    $.each(data, function (key, val) {
                        $(".noti-scroll").append('<a href="{{ url("post") }}/'+val.post_id+'" class="dropdown-item notify-item active"> <div class="notify-icon"> <img src="{{asset("images/users/user-1.jpg")}}" class="img-fluid rounded-circle" alt=""/> </div><p class="notify-details">'+val.name+' '+val.name_second+'</p><p class="text-muted mb-0 user-msg"> <small>'+val.comment_content+'</small> </p></a>');
                       //console.log(val.comment_content);
                    });
                    //console.log(data);
                    //$(".noti-icon-badge").html(data)   //// For replace with previous one
                },
                error: function() { 
                    console.log(data);
                }
            });
        });
    </script>

    @yield('footer')

</body>

</html>