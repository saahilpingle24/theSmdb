@extends('layouts.app')

@section('content')
	<div class="content">
		<div class="movie_top">
			<div class="col-md-9 movie_box">
				<div class="grid images_3_of_2">
					<div class="movie_image">
						<span class="movie_rating">{{$movie['vote_average']}}</span>
						<img src="{{$movie['poster_path']}}" class="img-responsive" alt=""/>
					</div>					
				</div>
				<div class="desc1 span_3_of_2">															
					<p class="movie_option">
						<strong>Release date: </strong>{{date_format(date_create($movie['release_date']),"F d, Y")}}
					</p>
					<p class="movie_option">
						<strong>Overview: </strong>
						<span class="overview">{{$movie['overview']}}</span>
					</p>					
					@if(sizeof($cast))
						<p class="movie_option">
							<strong>Cast: </strong><br>
							<span class="overview">
								@foreach($cast as $key=>$member)
									@if($key<4)
										{{$member['name']}} ({{($member['character'])}})<br>
									@else
										@break
									@endif
								@endforeach
							</span>
						</p>
					@endif
					@if(sizeof($crew))
						<p class="movie_option">
							<strong>Crew: </strong><br>
							<span class="overview">
								@foreach($crew as $key=>$member)
									@if($key<4)
										{{$member['job']}} <em>{{($member['name'])}}</em><br>
									@else
										@break
									@endif
								@endforeach							
							</span>
						</p>
					@endif
					<p class="movie_option"><span class="stars">{{$movie['vote_average']}}</span></p> ({{$movie['vote_average']}}/10)					
				</div>
				<div class="clearfix"> </div>
				<p class="m_4">
					@if(count($reviews) > 0)
						<h2>{{count($reviews)}} Reviews</h2>
						<ul class="single_list">					
							@foreach($reviews as $review)											
							<li>								
								<div class="data">
									<div class="title">{{$review['author']}}</div>
									<p class="review">{!!str_replace("\n","<br>", strip_tags($review['content']))!!}</p>
								</div>								
								<div class="clearfix"></div>
							</li>
							@endforeach
						</ul>
					@endif
				</p>

				<p class="m_4">
					@if(count($videos) > 0)
						<h2>Videos/Trailers</h2>
						<ul class="single_list">					
							@foreach($videos as $video)											
							<li>				
								<div class="row">
									<div class="col-md-7">								
										<iframe width="426" height="240"
											src="http://www.youtube.com/embed/{{$video['key']}}?autoplay=0">
										</iframe>
									</div>		
									<div class="col-md-5">
										<b>{{$video['name']}}</b><br>
										<b>Size</b> {{$video['size']}}
									</div>
								</div>

								<div class="clearfix"></div>
							</li>
							@endforeach
						</ul>
					@endif
				</p>
			</div>
			<div class="col-md-3">					
				@if(Auth::user())
					@if(sizeof($collections) == 0)
						<p class="movie_option"><b>Hola {{Auth::user()->name}}!</b> / <em>{{Auth::user()->username}}</em></p>
						<p><span>You've got no collections yet <i class="fa fa-frown-o" aria-hidden="true"></i> <br>
						Go ahead and create one to add this movie to your curated collection!</span></p>
						<br>
						<button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#create_collection">Create collection</button>					
					@else
						<p class="movie_option"><b>Howdy {{Auth::user()->name}}!</b> / <em>{{Auth::user()->username}}</em></p>
						<p><span>You've got some collections to your name!<br><br>
						<button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#create_collection">Create collection</button>
						<br>
						<div id="add-success-status" class="panel panel-success" style="display: none">
    						<div id="add-success-message" class="panel-body"></div>
  						</div>  						
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h4 class="panel-title">
									Collections
									<div class="pull-right">										
										<a href="#" data-perform="panel-collapse" class="btn btn-inverse btn-xs pull-right"><i class="fa fa-plus"></i></a>
									</div>
								</h4>
							</div>
							<div class="panel-wrapper collapse">
								<div class="panel-body">
									@foreach($collections as $key=>$collection)										
										<form name="add-movie" id="{{$key}}" class="submission" method="POST" action="{{route('movie.to.collection')}}">
											{!!csrf_field()!!}											
											<input type="hidden" name="collection_id" id="collection_id" value="{{$collection['id']}}">
											<input type="hidden" name="movie_id" id="movie_id" value="{{$movie['id']}}">
											<input type="submit" class="add-to-collection btn btn-default btn-sm btn-block" data-value="{{$key}}" value="{{$collection['name']}}">
										</form>
										<br>
									@endforeach
								</div>									
							</div>							
						</div>						
					@endif				
				@endif
				<br>
				@if(count($suggestions)>0)
					<em>We figured you might like some of these aswell!</em>
					<br>			
					@foreach ($suggestions as $suggestion)					
						 <div class="update-nag">            			
	            			<div class="update-text">
	            			<a href="{{route('movie.show',$suggestion['id'])}}"><small>{{$suggestion['title']}}</small></a>
	            			</div>
	          			</div>					
					@endforeach				
				@endif
			</div> 
			<div class="clearfix"> </div>
		</div>
	</div>
@endsection