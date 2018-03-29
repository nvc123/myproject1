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
    	    <h4>{{$article->name}}</h4>
    </div>
    <p class="card-text">{{$article->date}} 
	от <a href="{{route('users')}}/{{$article->author->id}}">{{$article->author->name}}</a> 
	в категории <a href="{{ route('categories') }}/{{$article->category->id}}">{{$article->category->name}}</a>
    </p>
    <div class="row container">
	Теги :
	<span class="categories">
	@foreach ($article->tags as $tag)
	    <a href="{{route('home')}}?tags[]={{$tag->id}}">{{$tag->name}}</a>
	@endforeach
	</span>
    </div>
		    <div class="row container" align="center">
    		    	<img src="/{{$article->foto->name}}" alt="{{$article->name}}">
    		    </div>
		    <p class="card-text">{{$article->text}}</p>
		    <div>
			<h4>Файлы</h4>
			@each('file.file', $article->files, 'file')
		    </div>
                </div>
            </div>
	    <h4 align="center" style="margin-top:20px">Комментарии:</h4>
	    <div style="margin-top:20px">
		@each('comment.view', $article->comments, 'comment')
		<div class="card">
    		    <div class="card-body">
			<div class="container row card-title ">
			    <h4>Ваш комментарий:</h4>
    			</div>
			<form method="POST" action="{{ route('articles') }}/{{$article->id}}">
                        @csrf
                        <div class="form-group row">
                            
                            <div class="col-md-12">
                                <textarea id="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" required></textarea>

                                @if ($errors->has('text'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
		    </div>
		</div>
	    </div>
        </div>
    </div>
</div>
@endsection
