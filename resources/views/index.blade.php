@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session()->has('flash'))
                    <div class="container">
                        <div class="alert alert-danger">{{session('flash')}}</div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Notificaciones</div>
                    <div class="card-body">
                        <form action="{{route('messages.update')}}" method="POST">
                            {!! method_field('PUT') !!}
                            {!! csrf_field() !!}

                            <button class="btn btn-default" name="submit_button" value="unread" title="Marcar como no leído"><i class="fa fa-envelope"></i></button>
                            <button class="btn btn-default" name="submit_button" value="read" title="Marcar como leído"><i class="fa fa-envelope-open"></i></button>
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
                                            <td {!! !$recipient->read ? 'class="font-weight-bold"' : ''!!}>
                                                {{$recipient->sender->email}} ({{$recipient->sender->name}})
                                            </td>
                                            <td {!! !$recipient->read ? 'class="font-weight-bold"' : ''!!}>
                                                {{strlen($recipient->body) <= 20 ? $recipient->body : substr($recipient->body, 0, 20) . '...'}}
                                            </td>
                                            <td {!! !$recipient->read ? 'class="font-weight-bold"' : ''!!}>
                                                {{$recipient->created_at}}
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