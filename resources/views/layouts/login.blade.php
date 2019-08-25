<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @include('inc.style')
    @include('inc.script')
    <script>
       /* preloading option start................... */

       $(window).on("load", function () {
         // Animate loader off screen
         $(".se-pre-con").delay(600).fadeOut("slow");;
       });

      /* preloading option end................... */

      $(document).on('click','.manual_btn', function () {
        var manualItem = $(this).attr('data-manual-name');
        $('.manual_modal').modal('show');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url: '{{ url('getManual') }}',
            type: 'POST',
            data: {'manual_item': manualItem},
        })
        .done(function(data) {
          $('#manualEmbed').html("<embed src="+data.url+" width='100%' height='780'>")
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

      })
    </script>
  </head>

    <body>
        <!--=== PAGE PRELOADER ===-->
        <!--<div class="se-pre-con"></div>-->

      	<div class="wrapper">

        {{-- @if(Auth::guard('owner')->check()) --}}
        {{-- @include('inc.left-sidebar') --}}
        {{-- @endif --}}
          	<div id="content">
          	{{-- @include('inc.header') --}}
                <div class="main-content">
                    <div class="container-fluid">
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                        @endif

                        @if ($errors->any())
                           <ul class="alert alert-danger">
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @yield('content')
                </div>
                @include('inc.footer')
          	</div>
      	</div>
      @yield('script')
  </body>
</html>
