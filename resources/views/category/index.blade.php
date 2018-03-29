@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
		    <span class="categories">
		    @foreach ($categories as $category)
			<a href="{{route('categories')}}/{{$category->id}}">{{$category->name}}</a>
		    @endforeach
		    </span>
                </div>
		
            </div>
        </div>
    </div>
</div>
@endsection
