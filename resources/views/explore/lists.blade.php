@extends('layouts.app')

@section('content')
<div class="content">	
	<div class="row">
	<p class="text-center">A handfull of colections to glance through! Refresh to discover more.</p>
	<br>
		@foreach ($collections as $collection)	
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body" style="height:200px;">
					<div class="panel-info">												
						<p class="text-center"><b><a href="{{route('collection.show', $collection->collection_id)}}">{{$collection->name}}</a></b><small> 
						<a href="{{route('profile.show',$collection->user_id)}}">(By {{$collection->user_name}})</small></p></a>
						<br><small><p class="review">
							@if($collection->description)
						  		{{$collection->description}}
						  	@else
						  		<p>A lazy lad indeed!</p>
						  		<p>Why don't you check the collection to find the type of movies in there?</p>
						  	@endif
						</p></small>
					</div>					                
				</div>
			</div>
		</div>
		@endforeach
	</div>			
	<!-- <?php echo $collections->render(); ?> -->
	<div class="clearfix"> </div>	
</div>
@endsection