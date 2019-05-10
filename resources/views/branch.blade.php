@if (!empty($staff))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if($staff->branch)
            @foreach($staff->branch as $row)
                <li class="breadcrumb-item"><a href="{{route('staff.edit',['id'=>$row->id])}}">{{$row->full_name}}</a></li>
            @endforeach
            @endif
                <li class="breadcrumb-item active" aria-current="page">{{$staff->full_name}}</li>
        </ol>
    </nav>
@endif