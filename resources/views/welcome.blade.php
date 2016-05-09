@extends('layouts.app')

@section('content')
<div class="slider">
	<div class="callbacks_container">
		<ul class="rslides" id="slider">
			<a href="{{route('movie.show',$featured['id'])}}">
				<li>
					<img src="{{$featured['backdrop_path']}}" class="img-responsive" alt=""/>
				</li>	
			</a>
		</ul>			
	</div>
	<div class="banner_desc">
		<div class="col-md-9">
			<ul class="list_1">
				<li>{{$featured['title']}}</li>
				<li>Published <span class="m_1">{{date_format(date_create($featured['release_date']),"F d, Y")}}</span></li>				
				<li>Rating <span class="m_1">{{$featured['vote_average']}}</span></li>				
			</ul>
		</div>
	</div>
</div>
<div class="content">
	<div class="box_1">
		<div class="search col-md-6">
			<form id="movie-search" method="POST" action="{{route('redirect.movie')}}">
				{!!csrf_field()!!}
				<div class="input-group">
				<input type="text" placeholder="Search for movies..." name="movies" id="movies" class="typeahead">
					<span class="input-group-btn">
						<button class="btn movie-search" onclick="checkInput()">Search!</button>
					</span>
				</div>
				<input class="movie_id" type="hidden" id="movie_id" name="movie_id" value="">  				
			</form>	
		</div>	
		<div class="search col-md-6">										
			<p class="text-center"><a id="surprise-me" href="{{route('redirect.surprise')}}" class="btn movie-search" title="Click me to get a suprise movie suggestion!" data-toggle="tooltip" data-placement="bottom">Suprise me!</a></p>
		</div>		
		<h1 class="m_2">Popular Movies</h1>		
		<div class="clearfix"> </div>
	</div>
	<div class="box_2">			
		@foreach (array_chunk($movies, 2) as $movie_set)
		<div class="row">
			@foreach ($movie_set as $movie)	
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body" style="height:400px;">
						<div class="panel-info">
							<div class="row">
								<div class="col-md-6">
									<a href="{{route('movie.show',$movie->id)}}"><p class="original_title">{{$movie->title}}</p></a>
									<p class="vote_average">{{$movie->release_date}} || {{$movie->vote_average}} <i class="fa fa-star" ></i></p>
									<br>
									<p class="article overview">{{$movie->overview}}</p>
								</div>
								<div class="col-md-6">
									<img src="{{$movie->poster_path}}" class="img-responsive">
								</div>
							</div>
						</div>					                
					</div>
				</div>
			</div>
			@endforeach
		</div>	
		@endforeach		
		<div class="clearfix"> </div>		
	</div>
</div>
@endsection
