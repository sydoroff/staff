@extends('app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col"><a id="id" class="text-dark" href="#"># </a></th>
            <th scope="col">Photo</th>
            <th scope="col"><a id="full_name" class="text-dark" href="#">Name </a></th>
            <th scope="col"><a id="position" class="text-dark" href="#">Job Title </a></th>
            <th scope="col"><a id="employment" class="text-dark" href="#">Start at </a></th>
            <th scope="col"><a id="pay" class="text-dark" href="#">Pay </a></th>
            <th scope="col"><a id="boss_name" class="text-dark" href="#">Boss </a></th>
            <th><a href="" class="btn btn-default">Reset</a></th>
        </tr>
        <tr>
            <form class="form-group row" method="get" onsubmit="show_table();return false;">
                <th class="align-middle">
                    <input  name="id_from"         value="" type="number"  class="form-control input-sm" style="width: 70px" placeholder="From">
                    <input  name="id_to"           value="" type="number"  class="form-control input-sm" style="width: 70px" placeholder="To">
                </th>
                <th class="align-middle">&nbsp;</th>
                <th class="align-middle">
                    <input  name="full_name"       value="" type="text"    class="form-control input-sm">
                </th>
                <th class="align-middle">
                    <input  name="position"        value="" type="text"    class="form-control input-sm">
                </th>
                <th class="align-middle">
                    <input  name="employment_from" value="" type="date"    class="form-control input-sm" style="width: 160px" placeholder="From">
                    <input  name="employment_to"   value="" type="date"    class="form-control input-sm" style="width: 160px" placeholder="To">
                </th>
                <th class="align-middle">
                    <input  name="pay_from"        value="" type="number"  class="form-control input-sm" style="width: 110px" placeholder="From">
                    <input  name="pay_to"          value="" type="number"  class="form-control input-sm" style="width: 110px" placeholder="To">
                </th>
                <th class="align-middle">
                    <input  name="boss_name"       value="" type="text"    class="form-control input-sm">
                </th>
                <th class="align-middle"><button name="search" value="1" type="submit"  class="btn btn-default">Search</button></th>

            </form>
        </tr>
        </thead>
    </table>
    <div id="pages"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/staff_table.js"></script>
    <script>
        show_table();
    </script>
</div>
@endsection
