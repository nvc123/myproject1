@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    <div class="row justify-content-center">
	<h1 class="bd-title" id="content" style="text-align:center">{{$title}}</h1>
	@include('article.list')
    </div>
</div>
@endsection
