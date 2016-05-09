@extends('layouts.app')

@section('content')
<div class="content">
	@if(count($following)>0)	
		@foreach (array_chunk($following, 4) as $following_set)
		<div class="row">
			@foreach ($following_set as $user)	
			<div class="col-md-4 col-sm-4 col-xs-6">
				<div class="twPc-div">
					<a class="twPc-bg twPc-block"></a>
					<div>
						<div class="twPc-button">
            				<a href="{{route('user.unfollow',$user->id)}}" class="btn btn-sm btn-default">Unfollow</a>
            			</div>
						<a class="twPc-avatarLink">
							<img src="{{$user->profile_picture}}" class="twPc-avatarImg">
						</a>
						<div class="twPc-divUser">
							<div class="twPc-divName">
								<a href="{{route('profile.show',$user->id)}}">{{$user->name}}</a>
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
		<p class="text-center">Oops! Not follwowing anyone.</p>
	@endif
</div>
@endsection