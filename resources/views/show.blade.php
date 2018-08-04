@extends('layouts.app')

@section('title', 'Ver notificación')

@section('content')

    <div class="container">


        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>De: </strong>{{$message->sender->email}} ({{$message->sender->name}})</p>
                                <p><strong>Recibido el día: </strong>{{$message->created_at}}</p>
                            </div>
                            <div class="offset-md-4">
                                <form action="{{route('messages.update')}}" method="POST" id="recipient-form">
                                    {!! method_field('PUT') !!}
                                    {!! csrf_field() !!}
                                    <a href="{{route('messages.index')}}" class="btn btn-link" title="Atrás"><i class="fa fa-reply"></i> Atrás</a>
                                    <input type="hidden" name="recipients_id[]" value="{{$message->id}}">
                                    <button type="submit" class="btn btn-default" name="submit_button" value="unread" title="Marcar como no leído"><i class="fa fa-envelope"></i></button>
                                    <button type="button" class="btn btn-danger" title="Eliminar" data-toggle="modal" data-target="#recipient-delete-modal"><i class="fa fa-trash-o"></i></button>
                                    {{--@include('modal')--}}
                                    @include('modal')
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                       {{$message->body}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection