<b>{{$item->full_name}}</b>.
<span class="text-success">Post: </span>
<i><u>{{$item->position}}</u></i>
@if($item->subject_count>0)
    <sup> sub.{{$item->subject_count}}</sup>
@endif
<span class="text-success">Working start:</span> {{$item->employment}}
<span class="text-success">Pay:</span> {{$item->pay}}$