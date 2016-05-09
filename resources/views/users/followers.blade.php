@extends('layouts.app')

@section('content')
<div class="content">
	@if(count($followers)>0)	
		@foreach (array_chunk($followers, 4) as $follower_set)
		<div class="row">
			@foreach ($follower_set as $user)	
			<div class="col-md-4 col-sm-4 col-xs-6">
				<div class="twPc-div">
					<a class="twPc-bg twPc-block"></a>
					<div>
						<a class="twPc-avatarLink">
							<img src="{{$user->profile_picture}}" class="twPc-avatarImg">
						</a>
						<div class="twPc-divUser">
							<div class="twPc-divName">
								<a href="#">{{$user->name}}</a>
							</div>
							<span>
								<em><span>{{$user->username}}</span></em>
							</span>
						</div>
					</div> 
				</div>   
			</div>
			@endforeach
		</div>
		@endforeach	
	@else
		<p class="text-center">Oops! Not being followed by anyone.</p>
	@endif
</div>
@endsection