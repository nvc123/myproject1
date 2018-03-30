@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:50px">
    <div class="row justify-content-center">
        <div class="col-md-12">
	    <h1 class="bd-title" id="content" style="text-align:center">{{$title}}</h1>	    
	    <p align="center"><a href="{{ route('articles') }}/{{$article->id}}" class="btn">Вернуться к просмотру статьи</a></p>
	    @if ($listType=='user')
	    	<p align="center"><a href="#" class="btn">Список ваших статей</a></p>
	    @endif
	    @if ($listType=='moderator')
	    	<p align="center"><a href="{{route('moderator')}}" class="btn">Список статей на модерации</a></p>
	    @endif
	</div>
    </div>
</div>
@endsection
