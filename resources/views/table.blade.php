@extends('app')

@section('content')
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a class="text-dark" href="{!!$sort['id']!!}"># {!! $set['id'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['full_name']!!}">Name {!! $set['full_name'] !!}</a><span class="glyphicon glyphicon-triangle-bottom"></span></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['position']!!}">Job Title {!! $set['position'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['employment']!!}">Start at {!! $set['employment'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['pay']!!}">Pay {!! $set['pay'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['boss']!!}">Boss {!! $set['boss'] !!}</a></th>
        </tr>
        </thead>
        <tbody>

          @foreach($staff as $row)
           <tr>
            <th scope="row">{{$row->id}}</th>
            <td>{{$row->full_name}}</td>
            <td>{{$row->position}}</td>
            <td>{{$row->employment}}</td>
            <td>{{$row->pay}}</td>
            <td>{{$row->boss['full_name']}}</td>
           </tr>
          @endforeach

        </tbody>
    </table>
    {{$pages->links()}}
</div>
@endsection
