@extends('include.master')

@section('title','Inventory | Dashboard')
@section('page-title','¡Bienvenido, INNOVATEC!')

@section('content')

<div class="row clearfix">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-orange hover-expand-effect">
        <div class="icon">
            <i class="material-icons">build</i>
        </div>
        <div class="content">
            <div class="text">REPARACIONES</div>
            <div class="number">{{ $reparaciones }}</div>
        </div>
    </div>
</div>

</div>

{{-- dashboard original --}}
<info-box></info-box>

@endsection

@push('script')
<script type="text/javascript" src="{{ url('public/js/dashboard.js') }}"></script>
@endpush