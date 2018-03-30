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
		    {!! Form::open(array('url' => route('article_edit', ['id' => isset($article) ? $article->id : '0']),'files'=>'true')); !!}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Название</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $article->name or '' }}" name="name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Краткое описание</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ $article->description or '' }}" required>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">Описание</label>

                            <div class="col-md-6">
                                <textarea id="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" required>{{$article->text or ' '}}</textarea>

                                @if ($errors->has('text'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
			
			<div class="form-group row">
                            <label for="categories" class="col-md-4 col-form-label text-md-right">Категория</label>

                            <div class="col-md-6">

				<select id="categories" class="input-medium" name="categories" value="{{$article->category->id or '1'}} ">
				    @foreach($categories as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
		    		    @endforeach  	  
				</select>
			    </div>
                        </div>

			<div class="form-group row">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">Тэги</label>

                            <div class="col-md-6">

				<select id="tags" class="js-example-basic-multiple input-medium" name="tags[]" multiple="multiple">
				    @foreach($alltags as $tag)
					<option value="{{$tag->id}}">{{$tag->name}}</option>
				    @endforeach  	  
				</select>
			    </div>
                        </div>

			<div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Основное изображение</label>

                            <div class="col-md-6">
				{!! Form::file('img') !!}
			    </div>
                        </div>


                        <div class="form-group row">
                            <label for="files" class="col-md-4 col-form-label text-md-right">Файлы</label>

                            <div class="col-md-6">
                                <input id="files" type="file" class="form-control{{ $errors->has('files') ? ' is-invalid' : '' }}" name="files[]" value="{{ $files or '' }}" multiple>
                                @if ($errors->has('files'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('files') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
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
<script type="text/javascript">
var valarr=[{{$texttags or ''}}];
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({ width: '100%' });
    $('.js-example-basic-multiple').val(valarr);
    $('.js-example-basic-multiple').trigger('change');
});
</script>
@endsection
