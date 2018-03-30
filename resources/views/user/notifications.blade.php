@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:50px">
    <div class="row justify-content-center">
        <div class="col-md-12">
	    <a href="{{route('remove_all_notifications')}}" class="btn btn-danger float-right clickable close-icon" data-effect="fadeOut">
	    	<span aria-hidden="true">Удалить все уведомления</span>
	    </a>
	    <h1 class="bd-title" id="content" style="text-align:center">{{$title}}</h1>
	    
	    @each('user.notification', $notifications, 'notification')
	</div>
    </div>
</div>
@endsection
