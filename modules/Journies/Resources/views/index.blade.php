@extends('general.index-client', $setup)
@section('thead')
    <th>{{ __('Name') }}</th>
    <th>{{ __('crud.actions') }}</th>
@endsection
@section('tbody')
@foreach ($setup['items'] as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>
            <!-- Kanban Edit -->
            <a href="{{ route('journies.kanban',['journey'=>$item->id]) }}" 
               class="btn btn-light-success btn-sm" 
               data-bs-toggle="tooltip" title="{{__('Kanban')}}">
                <i class="fas fa-columns"></i>
            </a>

            <!-- EDIT -->
            <a href="{{ route('journies.edit',['journey'=>$item->id]) }}" 
               class="btn btn-light-primary btn-sm" 
               data-bs-toggle="tooltip" title="{{__('Edit')}}">
                <i class="fas fa-edit"></i>
            </a>

            <!-- DELETE -->
            <a href="{{ route('journies.delete',['journey'=>$item->id]) }}" 
               class="btn btn-light-danger btn-sm" 
               onclick="return confirm('Are you sure you want to delete this journey?')" 
               data-bs-toggle="tooltip" title="{{__('Delete')}}">
                <i class="fas fa-trash-alt"></i>
            </a>
        </td>
    </tr> 
@endforeach
@endsection