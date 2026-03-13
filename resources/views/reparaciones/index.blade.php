@extends('include.master')

@section('title','Inventory | Reparaciones')

@section('page-title','Gestión de Reparaciones')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card">

            <div class="header">
                <h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-reparacion">
                        Nueva reparación
                    </button>
                </h2>
            </div>

            <view-reparacion :reparaciones="{{ $reparaciones }}"></view-reparacion>

        </div>

    </div>
</div>