<div class="card">
    <div class="card-body">
	@if (isset($isAdmin))
	<a href="{{route('notifications')}}/{{$notification->id}}" class="btn btn-danger float-right clickable close-icon" data-effect="fadeOut">
	    <span aria-hidden="true">&times;</span>
	</a>
  	@endif
	@if (session('status'))
            <div class="alert alert-success">
        	{{ session('status') }}
            </div>
	@endif
	<div class="container row card-title">
	    <a href="{{ route('users') }}/{{$user->id}}" class="card-link">
	    	<h4>{{$user->name}} ({{$user->total or ''}})</h4>
    	    </a>
    	</div>
	<p class="card-text" style="margin-top:20px">{{$user->text}}</p>
    </div>
</div>