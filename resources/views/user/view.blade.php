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
		    <div class="container row card-title">
    			<h4 align="center">{{$user->name}}</h4>
		    </div>
		    <p class="card-text">{{$user->text}}</p>
		    <h4 class="card-text" align="center">Статьи({{$user->count}})</h4>
		    @include('article.list', ['articles' => $user->articles])
		</div>
	    </div>
        </div>
    </div>
</div>
@endsection
