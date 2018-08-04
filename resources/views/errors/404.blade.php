@extends('layouts.app')
@section('title', "Página no encontrada")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Página no encontrada</div>

                    <div class="card-body">
                        <a href="{{route('home')}}" class="btn btn-primary btn-block"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop