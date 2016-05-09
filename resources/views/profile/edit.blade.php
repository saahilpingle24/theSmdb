@extends('layouts.app')

@section('content')
<div class="content">
	<div class="register">		
		<div class="register-top-grid">
			<h3>Personal Information</h3>
			<form class="form-horizontal" role="form" method="POST" action="{{route('profile.update',$user->id)}}" enctype="multipart/form-data">
				{!! csrf_field() !!} 
				<input type="hidden" name="_method" value="PUT">
				<div class="row">
					<div class="col-md-6">
						<div class="{{ $errors->has('name') ? ' has-error' : '' }}">
							<span>Name<label>*</label></span>
							<input type="text" class="form-control" name="name" value="{{$user->name}}">
		                    @if ($errors->has('name'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="{{ $errors->has('username') ? ' has-error' : '' }}">
							<span>Username<label>*</label></span>
							<input type="text" class="form-control" name="username" value="{{$user->username}}" style="background:white" readonly>
		                    @if ($errors->has('username'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('username') }}</strong>
		                        </span>
		                    @endif
						</div>
					</div>
				</div>
				<br>				
				<div class="row">					
					<div class="col-md-6">
						<div class="{{ $errors->has('email') ? ' has-error' : '' }}">
							<span>Email<label>*</label></span>
							<input type="email" class="form-control" name="email" value="{{$user->email}}" style="background:white" readonly>
		                    @if ($errors->has('email'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('email') }}</strong>
		                        </span>
		                    @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="{{ $errors->has('email') ? ' has-error' : '' }}">
							<span>Profile Picture<label><small>(Optional)</small></label></span>									
								<input id="photoCover" type="text" readonly class="form-control" style="background:white" value="{{$user->profile_picture}}">
								<br>
								<a id="button" class="btn btn-primary" onclick="$('input[id=lefile]').click();">Browse</a>
								<input id="lefile" name="profile_picture" type="file" style="display:none">										
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
				<div class="register-but">
					<input type="submit" class="btn btn-danger" value="Update Profile">
					<div class="clearfix"> </div>			
				</div>
			</form>								
		</div>		
		<div class="register-bottom-grid">
			<h3>Want to change your password?</h3>
			<span id="change-password" style="cursor:pointer;cursor:hand;">Click here to change it!</span>	
			<form id="change-password-block" class="form-horizontal" style="display:none" role="form" method="POST" action="{{route('password.update',$user->id)}}" enctype="multipart/form-data">
				{!! csrf_field() !!} 
				<input type="hidden" name="_method" value="PUT">
				<div class="row">
					<div class="col-md-6">
						<div class="{{ $errors->has('password') ? ' has-error' : '' }}">
							<span>Password<label>*</label></span>
							<input type="password" class="form-control" name="password">
		                    @if ($errors->has('password'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('password') }}</strong>
		                        </span>
		                    @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<span>Confirm Password<label>*</label></span>
							<input type="password" class="form-control" name="password_confirmation">
		                    @if ($errors->has('password_confirmation'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('password_confirmation') }}</strong>
		                        </span>
		                    @endif
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
				<div class="register-but">
					<input type="submit" class="btn btn-danger" value="Update Password">
					<div class="clearfix"> </div>			
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>		
</div>
@endsection
