@extends('layouts.app')
@section('title', "Notificaciones recibidas")

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session()->has('flash'))
                    <div class="container">
                        <div class="alert alert-success">{{session('flash')}}</div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Notificaciones</div>
                    <div class="card-body">
                        <form action="{{route('messages.update')}}" method="POST" id="recipient-form">
                            {!! method_field('PUT') !!}
                            {!! csrf_field() !!}

                            <button type="submit" class="btn btn-default" name="submit_button" value="unread" title="Marcar como no leído"><i class="fa fa-envelope"></i></button>
                            <button type="submit" class="btn btn-default" name="submit_button" value="read" title="Marcar como leído"><i class="fa fa-envelope-open"></i></button>
                            <button type="button" class="btn btn-danger" title="Eliminar" data-toggle="modal" data-target="#recipient-delete-modal"><i class="fa fa-trash-o"></i></button>

                            @if ($errors->has('recipients_id'))
                                <p class="text-danger">
                                    <strong>{{ $errors->first('recipients_id') }}</strong>
                                </p>
                            @endif

                            {{--@include('modal')--}}
                            @include('modal')

                            <p><strong>No leídos: {{auth()->user()->recipient()->where('read', 0)->count()}}</strong></p>

                            <table id="recipient-table" class="display" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" name="select_all" value="1" id="recipient-table-select-all"></th>
                                    <th>Remitente</th>
                                    <th>Texto</th>
                                    <th>Fecha</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach(auth()->user()->recipient as $recipient)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="recipients_id[]" value="{{$recipient->id}}">
                                            </td>
                                            <td>
                                                <a href="{{route('messages.show', $recipient->id)}}" title="Leer más" class="btn btn-link text-dark {!! !$recipient->read ? 'font-weight-bold' : ''!!}">
                                                    {{$recipient->sender->email}} ({{$recipient->sender->name}})
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('messages.show', $recipient->id)}}" title="Leer más" class="btn btn-link text-dark {!! !$recipient->read ? 'font-weight-bold' : ''!!}">
                                                    {{strlen($recipient->body) <= 20 ? $recipient->body : substr($recipient->body, 0, 20) . '...'}}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('messages.show', $recipient->id)}}" title="Leer más" class="btn btn-link text-dark {!! !$recipient->read ? 'font-weight-bold' : ''!!}">
                                                    {{$recipient->created_at}}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>

    $(document).ready(function (){
        var table = $('#recipient-table').DataTable({
            'language': {
                'url': '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
            },
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
            }],
            'order': [[1, 'asc']]
        });

        // Handle click on "Select all" control
        $('#recipient-table-select-all').on('click', function(){
            // Get all rows with search applied
            var rows = table.rows({ 'search': 'applied' }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#recipient-table tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            if(!this.checked){
                var el = $('#recipient-table-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if(el && el.checked && ('indeterminate' in el)){
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

    });

</script>

@endsection