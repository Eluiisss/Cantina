@extends('layouts.app')

@section('title','Home')


@section('content')
<table class="table-auto">
    <thead>
      <tr>
        <th>Usuario</th>
        <th>correo</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($users as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->email}}</td>

        </tr>
        @endforeach
        
    </tbody>
  </table>
    
@endsection
    
