@extends('layouts.app')

@section('content')
<div class="content">	
	<div class="row">
	<p class="text-center">Here are some of the all time top rated movies!</p>
	<br>
		@foreach ($movies as $movie)	
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body" style="height:400px;">
					<div class="panel-info">
						<div class="row">
							<a href="{{route('movie.show',$movie['id'])}}"><p class="text-center"><b>{{$movie['title']}}</b></p>
							<img src="{{$movie['poster_path']}}" class="img-responsive"></a>
						</div>
					</div>					                
				</div>
			</div>
		</div>
		@endforeach
	</div>			
	<?php echo $movies->render(); ?>			    
	<div class="clearfix"> </div>	
</div>
@endsection