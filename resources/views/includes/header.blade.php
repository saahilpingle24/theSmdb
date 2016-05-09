<div class="header_top">
	<div class="col-sm-3 logo"><a href="{{url('/')}}">theSmdb</a></div>
	
	<div class="col-sm-6 nav">		
		<ul>						
			<li>				
				<form id="user-search" method="POST" action="{{route('redirect.profile')}}">
					{!!csrf_field()!!}
					<div class="input-group">
						<input type="text" placeholder="Search user" name="users" id="users" class="form-control typeahead">
						<span class="input-group-btn">
		        			<button class="btn btn-default" type="submit">Go!</button>
		      			</span>
		      		</div>
					<input class="user_id" type="hidden" id="user_id" name="user_id" value="">  				
				</form>
				</span>
			</li>

		</ul>
	</div>

	<div class="col-sm-3 header_right">
		<ul class="header_right_box pull-right">  
			@if (Auth::guest())               
			<li><p><a href="{{ url('/login') }}">Login</a></p></li>
			<li><p><a href="{{ url('/register') }}">&nbsp;Register</a></p></li>                 
			<div class="clearfix"> </div>
			@else
			<li id="notification_li"> 
				<p><a href="#" id="notificationLink"><i class="fa fa-globe feed" aria-hidden="true"></i></a></p>
				<div id="notificationContainer">
						<div id="notificationTitle">Notifications</div>
						<div id="notificationsBody" class="notifications">
						<ul class="notifications">		
							@if(sizeof($feed))
								<ul class="notifications">
									@foreach(json_decode($feed) as $feed)
										<li>{{$feed}}</li>
									@endforeach
								</ul>
							@else
								<p class="text-center"> You've got no new notifications!</p>
							@endif
						</div>
						<div id="notificationFooter"><a href="#">See All</a></div>
					</div>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					<p>{{ Auth::user()->name }} <span class="caret"></span></p>
				</a>				
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{ route('profile.index')}}">View Profile</a></li>
					<li><a href="{{ url('logout') }}">Logout</a></li>
				</ul>
			</li>
			@endif
		</ul>
	</div>
	<div class="clearfix"> </div>
</div>