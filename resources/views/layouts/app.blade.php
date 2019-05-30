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
        function getNotif(){
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: 'http://127.0.0.1:8000/notif/nl',
                success: function (data) {
                    $('.noti-scroll').empty();
                    //var obj = JSON.parse(data);
                    console.log(data);
                    $.each(data, function (key, val) {
                        $(".noti-scroll").append('<a href="{{ url("post") }}/'+val.post_id+'" class="dropdown-item notify-item active"> <div class="notify-icon"> <img src="'+val.image_profile+'" class="img-fluid rounded-circle" alt=""/> </div><p class="notify-details">'+val.name+'</p><p class="text-muted mb-0 user-msg"> <small>'+val.comment_content+' postingan anda</small> '+val.created_at+'</p></a>');
                       //console.log(val.comment_content);
                    });
                    //$(".noti-icon-badge").html(data)   //// For replace with previous one
                },
                error: function() { 
                    console.log(data);
                }
            });
        }
    </script>

<script>
    function clearNotif(){
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: 'http://127.0.0.1:8000/notif/cn',
            success: function (data) {
                console.log(data);
                $(".noti-icon-badge").remove();
                //$("#noticon").append('<span class="badge badge-danger rounded-circle noti-icon-badge">'+data+'</span>')
                //$(".noti-icon-badge").html(data)   //// For replace with previous one
            },
            error: function() { 
                console.log(data);
            }
        });
    }
</script>

    @yield('footer')

</body>

</html>