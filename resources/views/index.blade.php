@extends('layouts.master')
@section('content')
<br><br><br><br>

{{-- <style>
    .table-sortable tbody tr {
    cursor: move;
}

</style> --}}
<div class="container">
<router-view></router-view>
</div>

@endsection
