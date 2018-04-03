@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:50px">
    <div class="row justify-content-center">
        <div class="col-md-12">
	    <h1 class="bd-title" id="content" style="text-align:center">{{$title}}</h1>
	    
	    @each('user.user', $users, 'user')
	</div>
    </div>
</div>
@endsection
