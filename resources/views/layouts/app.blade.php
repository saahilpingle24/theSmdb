<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>The Social Movie Database</title>
	
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
	
	<!-- Custom CSS -->
	<link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />    
	
	<!-- Custom Font -->
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'> 

	<!-- Logo Font -->
	<link href='https://fonts.googleapis.com/css?family=Amita:700' rel='stylesheet' type='text/css'>
	
	<!-- jQuery-UI CSS -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

	<!-- Typeahead CSS -->
	<link href="{{asset('assets/css/Typeahead-BS3-css.css')}}" rel="stylesheet" type="text/css" media="all" />        

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</head>

<body id="app-layout">
	<div class="container">
		<div class="container_wrap">
			@include('includes.header')
			@yield('content')    
		</div>
	</div>

	<!-- Modals -->

	<!-- Create Collection Modal -->
	<div id="create_collection" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Create a new collection</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('collection.store') }}">
						{!! csrf_field() !!}
						<div class="form-group{{ $errors->has('collection_name') ? ' has-error' : '' }}">
							<span>Collection Name<label>*</label></span>
							<input type="text" class="form-control" name="collection_name" value="{{ old('collection_name') }}">

							@if ($errors->has('collection_name'))
							<span class="help-block">
								<strong>{{ $errors->first('collection_name') }}</strong>
							</span>
							@endif
						</div>

						<div class="form-group{{ $errors->has('collection_description') ? ' has-error' : '' }}">
							<span>Collection Description<label><small>(Optional)</small></label></span>
							<textarea class="form-control" name="collection_description"></textarea>
							@if ($errors->has('collection_description'))
							<span class="help-block">
								<strong>{{ $errors->first('collection_description') }}</strong>
							</span>
							@endif
						</div>
						<input type="hidden" name="collection_modal" id="collection_modal" value="1">					
				</div>
				<div class="modal-footer">			
					<button type="submit" class="btn btn-danger">
						Create Collection
					</button>   
					</form> 				
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	@include('includes.footer')
	
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>    
	
	<!-- jQuery UI -->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<!-- Bootstrap JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
	<!-- Twitter Tyepahead JS -->
	<script src="{{ asset('assets/js/typeahead.bundle.js') }}"></script>    

	<!-- Capture data from typeahead -->
	<script type="text/javascript">
		$('#users').on('typeahead:selected typeahead:autocompleted', function(ev, suggestion) {			
			$('#user_id').val(suggestion.id);
		});
	</script>

	<script type="text/javascript">
		$('#movies').on('typeahead:selected typeahead:autocompleted', function(ev, suggestion) {			
			$('#movie_id').val(suggestion.id);
			console.log(suggestion.id);
		});
	</script>

	<!-- Readmore JS -->
	<script src="{{asset('assets/node_modules/readmore-js/readmore.min.js')}}"></script>

	<!-- Handlebars JS -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js" type="text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{ asset('assets/js/custom.js') }}"></script>

	<!-- Timeago JS -->
	<script src="{{asset('assets/js/jquery.timeago.js')}}" type="text/javascript"></script>
    
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery("time.timeago").timeago();
        });
    </script>

	<!-- Manage modal view/hide -->
	<script type="text/javascript">
        @if(count($errors) > 0)         	
        	@if($errors->first('collection_name'))
            	$('#create_collection').modal('show');
            @endif
        @endif
    </script>
</body>
</html>
