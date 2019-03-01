@extends('app')

@section('content')
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col"># &or;  &and;	&#9660; 	&#9650;</th>
            <th scope="col">Name<span class="glyphicon glyphicon-triangle-bottom"></span></th>
            <th scope="col">Job Title</th>
            <th scope="col">Pay</th>
            <th scope="col">Boss</th>
        </tr>
        </thead>
        <tbody>

          @foreach($staff as $row)
           <tr>
            <th scope="row">{{$row->id}}</th>
            <td>{{$row->full_name}}</td>
            <td>{{$row->position}}</td>
            <td>{{$row->pay}}</td>
            <td>{{$row->boss['full_name']}}</td>
           </tr>
          @endforeach

        </tbody>
    </table>
    {{$staff->links()}}
</div>
@endsection
