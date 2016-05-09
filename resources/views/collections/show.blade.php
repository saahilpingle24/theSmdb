@extends('layouts.app')

@section('content')
<div class="content">
	<div class="movie_top">
		<div class="col-md-9 movie_box">
			<div class="row">
				<h3>
					{{$collection->name}} 
					@if(Auth::check())
						@if(Auth::user()->id==$collection->user_id)
						<small><a href="{{route('collection.edit',$collection->id)}}">(edit)</a></small>
						@endif
					@endif
				</h3>
				@if(Auth::check()) 
					@if(Auth::user()->id==$collection->user_id)				
					<form method="POST" action="{{route('collection.destroy', $collection->id)}}">
						{!!csrf_field()!!}
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="collection_id" value="{{$collection->id}}">
						<small>
							<input type="submit" class="btn btn-warning btn-sm" title="This will delete your collection!" data-toggle="tooltip" data-placement="bottom" value="Delete collection?">
						</small>
					</form>
					@endif
				@endif
				<p class="m_4">
					{{$collection->description}}				
				</p>
			</div>
			@if(Auth::check())
				<div class="row">
					<form method="post" action="{{route('comment.store')}}">
						{!!csrf_field()!!}
						<div class="text">
							<textarea name="comment" id="expand" class="form-control" style="height:2.5em !important;" rows="1" placeholder="Leave a comment"></textarea>
							<input type="hidden" name="collection_id" value="{{$collection->id}}">
						</div>
						@if ($errors->has('comment'))
						<span class="help-block">
							<strong>{{ $errors->first('comment') }}</strong>
						</span>
						@endif
						<div>
							<input name="submit" class="btn btn-danger btn-sm" type="submit" id="comment_submit" value="Post Comment" style="display:none"><br>
						</div>
						<div class="clearfix"></div>
					</form>
				</div>
			@endif
			<br>			
			<div class="row">
				<div class="single">
					@if(sizeof($collection->movies))
						<div class="col-md-2" id="carousel-bounding-box">
							<div id="myCarousel" class="carousel slide">                        
								<div class="carousel-inner">
									<div class="active item" data-slide-number="0">
										<img class="img-rounded img-responsive" src="{{$collection->movies[0]->poster_path}}">
									</div>
									@if(count($collection->movies)>1)
										@foreach($collection->movies as $key=>$movie)
										<div class="item" data-slide-number="{{$key}}">
											<img class="img-rounded img-responsive" src="{{$movie->poster_path}}">
										</div>                            	
										@endforeach
									@endif
								</div><!--/carousel-inner-->
							</div><!--/carousel-->
							<ul class="carousel-controls-mini list-inline text-center">
								<li><a href="#myCarousel" data-slide="prev">‹</a></li>
								<li><a href="#myCarousel" data-slide="next">›</a></li>
							</ul><!--/carousel-controls-->
						</div><!--/col-->
						<div class="col-md-4" id="carousel-text"></div>
						<div style="display:none;" id="slide-content">
							@foreach($collection->movies as $key=>$movie)
							<div id="slide-content-{{$key}}">
								<h5>{{$movie->title}}</h5>                        	
							</div>
							@endforeach                    
						</div><!--/slide-content-->
					@endif
				</div>
			</div>
			<div class="row">
				<h2>{{count($comments)}} Comments</h2>
				<ul class="single_list">					
					@foreach($comments as $comment)
					<li>
						<div class="preview">
							<a href="#"><img src="{{$comment->profile_picture}}" class="img-responsive" alt=""></a>							
						</div>
						<div class="data">
							<div>
								<b><a href="{{route('profile.show',$comment->user_id)}}">{{$comment->name}} | {{$comment->username}}</a></b>
								<span class="pull-right" style="margin-right: 200px;">
									<small>									
										@if(Auth::check()) 										
										<form method="post" action="{{route('comment.destroy', $comment->comment_id)}}">
											{!!csrf_field()!!}
											<input type="hidden" name="_method" value="delete">
											<input type="hidden" name="comment_id" value="{{$comment->comment_id}}">
											<button type="submit" class="delete-link fa fa-times" title="This will delete your comment!" data-toggle="tooltip" data-placement="bottom"></button>
										</form>										
									@endif															
									</small>	
								</span>							
							</div>
							<small>
									(Created about <time class="timeago" datetime="{{$comment->created_at}}">{{$comment->created_at}}</time>)
								</small>
							<p>{{$comment->comment}}</p>
						</div>
						<div class="clearfix"></div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>		
	</div> 
	<div class="clearfix"> </div>
</div>
@endsection