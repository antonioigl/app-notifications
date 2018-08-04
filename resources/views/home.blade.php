@extends('layouts.app')
@section('title', "Home")


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session()->has('flash'))
                <div class="container">
                    <div class="alert alert-success">{{session('flash')}}</div>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Enviar mensaje</div>
                    <form action="{{route('messages.store')}}" method="POST">
                        {{csrf_field()}}
                        <div class="card-body">
                            <div class="form-group">
                                <select name="recipient_id" class="form-control" required>
                                    <option value="">Selecciona el usuario</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" {{$user->id == old('recipient_id') ? 'selected' : ''}}>{{$user->email}} ({{$user->name}})</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('recipient_id'))
                                    <p class="text-danger">
                                     <strong>{{ $errors->first('recipient_id') }}</strong>
                                   </p>
                                @endif
                            </div>
                            <div class="form-group">
                                <textarea name="body" class="form-control" required maxlength="400" placeholder="Escribe aquí tu mensaje">{{old('body')}}</textarea>
                                @if ($errors->has('body'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block">Enviar</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
