@extends('app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col"><a class="text-dark" href="{!!$sort['id']['url']        !!}"># {!! $sort['id']['ico'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['full_name']['url'] !!}">Name {!! $sort['full_name']['ico'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['position']['url']  !!}">Job Title {!! $sort['position']['ico'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['employment']['url']!!}">Start at {!! $sort['employment']['ico'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['pay']['url']       !!}">Pay {!! $sort['pay']['ico'] !!}</a></th>
            <th scope="col"><a class="text-dark" href="{!!$sort['boss']['url']!!}">Boss {!! $sort['boss']['ico'] !!}</a></th>
            <th><a href="{{route('staff')}}" class="btn btn-default">Reset</a></th>
        </tr>
        </thead>
        <tbody>
              <tr>
                <form class="form-group row" method="get" action="{{route('staff')}}">
                    <th class="align-middle">
                                             <input  name="id_from"         value="{{ $form_input['id_from'] ?? ''         }}" type="number"  class="form-control input-sm" style="width: 70px" placeholder="From">
                                             <input  name="id_to"           value="{{ $form_input['id_to'] ?? ''           }}" type="number"  class="form-control input-sm" style="width: 70px" placeholder="To">
                    </th>
                    <th class="align-middle"><input  name="full_name"       value="{{ $form_input['full_name'] ?? ''       }}" type="text"    class="form-control input-sm"></th>
                    <th class="align-middle"><input  name="position"        value="{{ $form_input['position'] ?? ''        }}" type="text"    class="form-control input-sm"></th>
                    <th class="align-middle">
                                             <input  name="employment_from" value="{{ $form_input['employment_from'] ?? '' }}" type="date"    class="form-control input-sm" style="width: 160px" placeholder="From">
                                             <input  name="employment_to"   value="{{ $form_input['employment_to'] ?? ''   }}" type="date"    class="form-control input-sm" style="width: 160px" placeholder="To">
                    </th>
                    <th class="align-middle">
                                             <input  name="pay_from"        value="{{ $form_input['pay_from'] ?? ''        }}" type="number"  class="form-control input-sm" style="width: 110px" placeholder="From">
                                             <input  name="pay_to"          value="{{ $form_input['pay_to'] ?? ''          }}" type="number"  class="form-control input-sm" style="width: 110px" placeholder="To">
                    </th>
                    <th class="align-middle"><input  name="boss"            value="{{ $form_input['boss'] ?? ''            }}" type="text"    class="form-control input-sm"></th>
                    <th class="align-middle"><button name="search"          value="1"                                     type="submit"  class="btn btn-default">Search</button></th>
                    @foreach($form_url as $n_url=>$m_url)
                        <input type="hidden" name="{{$n_url}}" value="{{$m_url}}">
                    @endforeach
                </form>
              </tr>

          @foreach($staff as $row)
           <tr>
            <th scope="row">{{$row->id}}</th>
            <td>{{$row->full_name}}</td>
            <td>{{$row->position}}</td>
            <td>{{$row->employment->format('d.m.Y')}}</td>
            <td>{{$row->pay}}$</td>
            <td colspan="2">{{$row->boss['full_name']}}</td>
           </tr>
          @endforeach

        </tbody>
    </table>
    {{$staff->links()}}
</div>
@endsection
