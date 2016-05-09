@extends('layouts.app')

@section('content')
<div class="slider">		
	<div class="banner_desc">
		<div class="col-md-12">
			<ul class="list_1">
				<a href="{{route('user.followers',$profile->id)}}"><li>{{count($followers)}} <span class="m_1">Followers</span></li></a>
				<a href="{{route('user.following',$profile->id)}}"><li>{{count($following)}} <span class="m_1">Following</span></li></a>
				<li>{{count($collections)}} <span class="m_1">Collection(s)</span></li>				
				@if($allow_creation)
					<li><a data-toggle="modal" style="cursor:pointer; cursor: hand;" data-target="#create_collection"><span class="m_1 no-hover">Create Collection</span></a></li>
				@endif				
			</ul>
		</div>			
	</div>
</div>
<div class="profile-back">		
	<div class="profile-name col-md-4">
		<img src="{{$profile->profile_picture}}" style="height:200px;">
	</div>
	<div class="profile-name col-md-3">
		<h2 style="color:white">{{$profile->name}}</h2>
		<p><small style="color:white">{{$profile->username}} | {{$profile->email}}</small></p>		
		<p><small style="color:white">Member since - {{date_format(date_create($profile['registered_on']),"F d, Y")}}</small></p>
		<a href="{{route('profile.edit',$profile->id)}}"><small> (edit)</small></a>
	</div>
</div>
<div class="content">
		@if(count($collections)==0)
			<p class="text-center">
				You've got no collections to your name! Add some and share some!<br>
				<i class="fa fa-hand-spock-o fa-5x" aria-hidden="true"></i>
			</p>
		@endif
		@foreach (array_chunk($collections->all(), 2) as $collections)
			<div class="row">
				@foreach ($collections as $collection)	
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<a href="{{route('collection.show',$collection->id)}}"><b>{{$collection->name}}<small> || ({{count($collection->movies)}} movies)</small></b></a>
								<span class="pull-right"><small>Created about <time class="timeago" datetime="{{$collection->created_at}}">{{$collection->created_at}}</time></small></span>
							</div>
						  	<div class="panel-body">
						  		@if($collection->description)
						  			<small>{{$collection->description}}</small>
						  		@else
						  			<small>How about a lil description about your list? This will help you gain some really interesting audience for your collection.</small>
						  		@endif
						  		<br>					  		
						  	</div>
						</div>
					</div>		
				@endforeach	
			</div>		
		@endforeach		
</div>


@endsection
