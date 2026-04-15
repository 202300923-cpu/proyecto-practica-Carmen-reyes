@extends('include.master')


@section('title','Inventory | Stock-Report')


@section('page-title','Stock Report')


@section('content')



<form method="GET" action="{{ route('report.store') }}">

<div class="row">

    <!-- TIPO DE REPORTE -->
    <div class="col-md-3">
        <label>Tipo de reporte *</label>
        <select name="type" class="form-control" required>
            <option value="">Seleccione un tipo</option>
            <option value="stock">Stock</option>
            <option value="ventas">Ventas</option>
            <option value="facturas">Facturas</option>
            <option value="pendientes">Pendientes</option>
            <option value="ganancias">Ganancias</option>
        </select>
    </div>

    <!-- FECHA DESDE -->
    <div class="col-md-3">
        <label>Fecha desde *</label>
        <input type="date" name="from_date" class="form-control" required>
    </div>

    <!-- FECHA HASTA -->
    <div class="col-md-3">
        <label>Fecha hasta *</label>
        <input type="date" name="to_date" class="form-control" required>
    </div>

    <!-- USUARIO -->
    <div class="col-md-3">
        <label>Usuario *</label>
        <select name="user_id" class="form-control" required>
            <option value="">Seleccione usuario</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

</div>

<br>

<button type="submit" class="btn btn-success">
    Generar reporte
</button>

</form>