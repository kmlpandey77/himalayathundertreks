<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login :: {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/backdo0r/icon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/backdo0r/stylesheets/style.css') }}">
    <link rel="icon" href="{{ asset('vendors/backdo0r/images/favicon.ico') }}" type="image/x-icon" />
</head>

<body class="login">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 mx-auto">
                <div class="login-wrap">
                    <div class="logo"><img src="{{ asset('images/logo.png') }}"
                            alt="IT Villa" class="img-fluid" /></div>
                    <div class="card">
                        <div class="card-header px-5 py-4">
                            <h2 class="card-title">Login</h2>
                            <h6 class="card-subtitle">Sign In to your account</h6>
                        </div>
                        <div class="card-body px-5 py-4">
                            <form class="" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}


                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label sr-only">E-Mail Address</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="lnr lnr-user"></i></div>
                                        </div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                            required autofocus>
                                    </div>
                                    @if($errors->has('email'))
                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label sr-only">Password</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="lnr lnr-lock"></i></div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            required>
                                    </div>
                                    @if($errors->has('password'))
                                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Remember Me</label>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="button button-p-dark button-raised button-pill">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-muted">
                            <span class="float-left">IP Logged:
                                <?=Request::ip();?></span>
                            <span class="float-right">&copy; &amp; Powered by <a href="https://w3web.co.uk/" target="_blank">W3 Web Technology</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>