@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="content">
	<div class="register">
		<div class="col-md-6 col-md-offset-3">
			<h3 class="text-center">Reset Password</h3>           
			@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
			{!! csrf_field() !!}
			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<span>Email Address<label>*</label></span>
				<input type="email" class="form-control" name="email" value="{{ old('email') }}">

				@if ($errors->has('email'))
				<span class="help-block">
					<strong>{{ $errors->first('email') }}</strong>
				</span>
				@endif
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-danger">
					<i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
				</button>    
			</div>
		</form>
		</div> 		
		<div class="clearfix"> </div>
	</div>
</div>

@endsection
