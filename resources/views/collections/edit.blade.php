@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="content">
	<div class="register">
		<div class="col-md-6 col-md-offset-3">
			<h3 class="text-center">Edit your collection</h3>           
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif
			<form class="form-horizontal" role="form" method="POST" action="{{ route('collection.update',$collection->id) }}">
				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PUT">
				<div class="form-group{{ $errors->has('collection_name') ? ' has-error' : '' }}">
					<span>Collection Name<label>*</label></span>
					<input type="text" class="form-control" name="collection_name" value="{{$collection->name}}">

					@if ($errors->has('collection_name'))
					<span class="help-block">
						<strong>{{ $errors->first('collection_name') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('collection_description') ? ' has-error' : '' }}">
					<span>Collection Description<label><small>(Optional)</small></label></span>
					<textarea class="form-control" name="collection_description">{{$collection->description}}</textarea>

					@if ($errors->has('collection_description'))
					<span class="help-block">
						<strong>{{ $errors->first('collection_description') }}</strong>
					</span>
					@endif
				</div>			
				<div class="form-group">
					<button type="submit" class="btn btn-danger">
						Edit Collection
					</button>    
				</div>
			</form>
		</div> 		
		<div class="clearfix"> </div>
	</div>
</div>

@endsection
