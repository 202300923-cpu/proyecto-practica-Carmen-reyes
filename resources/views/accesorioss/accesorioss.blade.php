@extends('include.master')

@section('title','Inventory | accesorios')

@section('page-title','Lista de Accesorios')

@section('content')

<div class="row clearfix">
    <create-accesorio :categorys="{{ json_encode($category) }}"></create-accesorio>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-accesorio">
                        Accesorio nuevo
                    </button>
                </h2>
            </div>

            <view-accesorio :categorys="{{ json_encode($category) }}"></view-accesorio>

        </div>
    </div>
</div>

@endsection

@push('script')

<script type="text/javascript" src="{{ url('public/js/accesorio.js') }}"></script>

@endpush