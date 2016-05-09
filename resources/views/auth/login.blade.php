@extends('layouts.app')

@section('content')
<div class="content">
   <div class="register">
     <div class="col-md-6 login-left">
       <h3>New to MShare?</h3>
       <p>By creating an account with our MShare, you will be able to discover new movies!</p>
       <a class="btn btn-danger" href="{{ url('/register') }}">Create an Account</a>
   </div>
   <div class="col-md-6 login-right">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
            <span>Email Address<label>*</label></span>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
            <span>Password<label>*</label></span>
            <input type="password" class="form-control" name="password">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>        
    <a class="forgot" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
    <input type="submit" class="btn btn-danger" value="Login">
</form>
</div>   
<div class="clearfix"> </div>
</div>
</div>
@endsection
