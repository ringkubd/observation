@section('title','DIGIPLAN')

@extends('layouts.login')

@section('style')

    <link rel="stylesheet" href="{{asset('assets/css/create_account.css')}}">

      <style>
      .main-content-area {padding: 30px;}input[type="checkbox"] + label {width: 30px;height: 30px;border: 5px solid #f5f5f5;border-radius: 100%;top: 50%;left: 10%;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);-webkit-transition: all ease-out 200ms;transition: all ease-out 200ms;text-indent: 40px;white-space: nowrap;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;margin: 20px 0 0 15px;}input[type="checkbox"] + label:after {content: "";position: absolute;width: 0px;height: 10px;border-bottom: 5px solid #22b573;border-left: 5px solid #22b573;top: 25%;left: 50%;-webkit-transform-origin: bottom left;transform-origin: bottom left;-webkit-transform: rotate(-45deg);transform: rotate(-45deg);opacity: 0;-webkit-transition: all ease-out 200ms;transition: all ease-out 200ms;}
      input[type="checkbox"]:checked + label {border: 5px solid #22b573;}
      input[type="checkbox"]:checked + label:after {opacity: 1;width: 30px;}
      #chk, #chk_2 {display: none;}
      input.account-submit-btn {padding: 5px 20px;}
      input.account-submit-btn {padding: 5px 20px;}
      .dropdown-menu {top: -50%;}
      .dropdown-menu li a {cursor: pointer;}
      .bankid-form-container, .opt-form-container, .login_btn_hide, .hide_verify_input {display: none;}

</style>
@endsection
@section('content')
<section class="slider-area">
      <div class="container">
            <div class="content-wrapper">
                  <h3>LOGGA IN</h3>
                  <div class="main-content-area">
                        @if (Session()->has('message'))
                              <div class="alert alert-info">{{ Session()->get('message') }}</div>
                        @endif
                        <div class="password-form-container">
                              <form class="form-horizontal" method="POST" action="{{ route('login') }}" id="login_form">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                          <label for="email">E-post adress</label>
                                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                          @if ($errors->has('email'))
                                                <span class="help-block">
                                                      <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                          @endif
                                    </div>
                                    <div class="form-group">
                                          <label for="password">Lösenord</label>
                                          <input id="password" type="password" class="form-control" name="password" required>
                                          @if ($errors->has('password'))
                                                <span class="help-block">
                                                      <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                          @endif
                                    </div>

                                    <div class="form-group">
                                          <label class="checkbox-inline">
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>  Kom ihåg mig
                                          </label>
                                          <label class="checkbox-inline pull-right hide-bid">
                                                <a style="color:white" class="btn btn-link" href="{{ route('password.request')}}">Glömt ditt lösenord??</a>
                                          </label>
                                    </div>
                                    <div class="submit-btn-area">
                                          <input type="submit" id="login_btn" class="account-submit-btn" value="Logga in" />
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>
@endsection
