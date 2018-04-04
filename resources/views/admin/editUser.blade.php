@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Редактирование пользователя</div>
		@if(session()->has('message'))
	            <div class="alert alert-success">
        	      {{ session()->get('message') }}
       		    </div>
		@endif
                <div class="card-body">
                    <form method="POST" action="{{ route('edit_user', ['id' => $user->id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ФИО</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name}}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

			<div class="form-group row">
            		    <label for="role" class="col-md-4 col-form-label text-md-right">Роль</label>

			    <div class="col-md-6">
		    		<select id="role" class="input-medium" name="role" value="{{ old('role') }}" required>
				    @foreach($roles as $role)
					@if ($role==$user->role)
			    		    <option value="{{$role}}" selected>{{$role}}</option>
					@else
			    		    <option value="{{$role}}">{{$role}}</option>
					@endif
		        	    @endforeach  	  
		    		</select>
			    </div>
	    		</div>

                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">Описание</label>

                            <div class="col-md-6">
                                <textarea id="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" required>{{$user->text}}</textarea>

                                @if ($errors->has('text'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите пароль</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Редактировать
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
