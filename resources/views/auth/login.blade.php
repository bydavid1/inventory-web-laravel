<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="PIXINVENT">
  <title>Login with Background Color - Stack Responsive Bootstrap 4 Admin Template</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/vendors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/app.css') }}">

</head>
<body class="horizontal-layout horizontal-menu 1-column  bg-cyan bg-lighten-2 menu-expanded blank-page blank-page"
data-open="hover" data-menu="horizontal-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img src="{{ URL::asset('app-assets/images/logo/stack-logo-dark.png') }}" alt="branding logo">
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Easily Using</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body pt-0">
                    <form class="form-horizontal" id="loginform">
                      @csrf
                      <fieldset class="form-group floating-label-form-group">
                        <label for="user-name">Your Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required placeholder="Your Username">
                      </fieldset>
                      <fieldset class="form-group floating-label-form-group mb-1">
                        <label for="user-password">Enter Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Enter Password">
                      </fieldset>
                      <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-sm-left">
                          <fieldset>
                            <input type="checkbox" id="remember-me" class="chk-remember">
                            <label for="remember-me"> Remember Me</label>
                          </fieldset>
                        </div>
                        <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a href="recover-password.html" class="card-link">Forgot Password?</a></div>
                      </div>
                      <button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-user" id="icon-lock"></i><i class="fa fa-spinner spinner d-none" id="spinner"></i> Login</button>
                    </form>
                  </div>
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>New to Stack ?</span>
                  </p>
                  <div class="card-body">
                    <a href="{{ route('register') }}" class="btn btn-outline-danger btn-block"><i class="ft-user"></i> Register</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
  ///FAtara arreglar el login
$('#loginform').unbind('submit').bind('submit', function (stay) {
            stay.preventDefault();
            var formdata = $(this).serialize();
            var url = "{{ route('login') }}";
            $.ajax({
                type: 'POST',
                url: url,
                data: formdata,
                beforeSend: function () {
                  document.getElementById('icon-lock').classList.add('d-none')
                  document.getElementById('spinner').classList.add('d-block')
                },
                error: function (xhr, textStatus, errorMessage) {

                }
            });
        });

</script>
</body>
</html>
