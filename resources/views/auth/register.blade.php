@extends('layouts.app')

@section('content')
<div class="content">
	<div class="register">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
			{!! csrf_field() !!} 
			<div class="register-top-grid">
				<h3>Personal Information</h3>
				<div class="row">
					<div class="col-md-6">
						<div class="{{ $errors->has('name') ? ' has-error' : '' }}">
							<span>Name<label>*</label></span>
							<input type="text" class="form-control" name="name" value="{{ old('name') }}">
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
							<input type="text" class="form-control" name="username" value="{{ old('username') }}">
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
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
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
								<input id="photoCover" type="text" readonly class="form-control" style="background:white">
								<br>
								<a id="button" class="btn btn-primary" onclick="$('input[id=lefile]').click();">Browse</a>
								<input id="lefile" name="profile_picture" type="file" style="display:none">										
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
				<a class="news-letter" href="#"></a>
			</div>
			<div class="register-bottom-grid">
				<h3>Login Information</h3>
				<div class="{{ $errors->has('password') ? ' has-error' : '' }}">
					<span>Password<label>*</label></span>
					<input type="password" class="form-control" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
				</div>
				<div class="{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
					<span>Confirm Password<label>*</label></span>
					<input type="password" class="form-control" name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
				</div>
				<div class="clearfix"> </div>
			</div>		
		<div class="clearfix"> </div>
		<div class="register-but">
			<input type="submit" class="btn btn-danger" value="Submit">
			<div class="clearfix"> </div>			
		</div>
		</div>
	</div>
</div>
@endsection
