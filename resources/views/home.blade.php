@extends('layouts.app')

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
                                <select name="recipient_id" class="form-control">
                                    <option value="">Selecciona el usuario</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="body" class="form-control" placeholder="Escribe aquí tu mensaje">{{old('body')}}</textarea>
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
