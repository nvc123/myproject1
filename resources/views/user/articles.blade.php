@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
    		<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
		    <a href="{{route('article_create')}}" class="btn btn-success float-right clickable close-icon" data-effect="fadeOut">
	    		<span aria-hidden="true">Добавить статью</span>
	    	    </a>
		    <h1 class="bd-title" id="content" align="center" style="white-space:pre-wrap">{{$title}}</h1>
	    
		    @include('article.list')
		</div>
	    </div>
        </div>
    </div>
</div>
@endsection
