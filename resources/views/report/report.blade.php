@extends('include.master')

@section('title','Inventory | Report')

@section('page-title','Report')

@section('content')

<style>
    .reporte-card-custom .body {
        padding: 22px 18px 20px 18px;
    }

    .reporte-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px 30px;
        margin-bottom: 26px;
    }

    .campo-reporte label {
        display: block;
        font-size: 13px;
        color: #8a8a8a;
        margin-bottom: 8px;
        font-weight: 400;
    }

    .campo-reporte .linea-input {
        width: 100%;
        border: none;
        border-bottom: 1px solid #d8d8d8;
        background: transparent;
        outline: none;
        height: 38px;
        font-size: 14px;
        color: #555;
        box-shadow: none;
        padding: 0 28px 0 0;
        border-radius: 0;
    }

    .campo-reporte .linea-input:focus {
        border-bottom: 2px solid #00a79d;
    }

    .campo-reporte select.linea-input {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg fill='%23888888' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M7 10l5 5 5-5z'/></svg>");
        background-repeat: no-repeat;
        background-position: right center;
        background-size: 18px;
        cursor: pointer;
    }

    .btn-reporte-custom {
        background: #00a79d;
        color: #fff;
        border: none;
        padding: 10px 22px;
        border-radius: 2px;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,.18);
    }

    .btn-reporte-custom:hover,
    .btn-reporte-custom:focus {
        color: #fff;
        background: #009688;
    }

    .reporte-btn-wrap {
        text-align: center;
        margin-top: 6px;
    }

    @media (max-width: 991px) {
        .reporte-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .reporte-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card reporte-card-custom">
            <div class="header">
                <h2>Reporte de Cantidad en Stock</h2>
            </div>

            <div class="body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom:0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('report.store') }}" method="GET">

                    <div class="reporte-grid">

                        <div class="campo-reporte">
                            <label>Tipo de reporte *</label>
                            <select name="type" class="linea-input" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="stock">Stock</option>
                                <option value="sell">Ventas</option>
                                <option value="invoice">Facturas</option>
                                <option value="due">Pendientes</option>
                                <option value="profit">Ganancias</option>
                            </select>
                        </div>

                        <div class="campo-reporte">
                            <label>Fecha hasta *</label>
                            <input type="date" name="start_date" class="linea-input" required>
                        </div>

                        <div class="campo-reporte">
                            <label>Fecha desde *</label>
                            <input type="date" name="end_date" class="linea-input" required>
                        </div>

                        <div class="campo-reporte">
                            <label>Categoría (opcional)</label>
                            <select name="category_id" class="linea-input">
                                <option value="">Seleccione categoría</option>
                                @foreach($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="campo-reporte">
                            <label>Producto (opcional)</label>
                            <input type="text" name="product_id" class="linea-input" placeholder="Ingrese ID del producto">
                        </div>

                        <div class="campo-reporte">
                            <label>Comprobante (opcional)</label>
                            <input type="text" name="comprobante" class="linea-input" placeholder="Ingrese comprobante">
                        </div>

                        <div class="campo-reporte">
                            <label>Proveedor (opcional)</label>
                            <select name="vendor_id" class="linea-input">
                                <option value="">Seleccione proveedor</option>
                                @foreach($vendor as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="campo-reporte">
                            <label>Cliente (opcional)</label>
                            <select name="customer_id" class="linea-input">
                                <option value="">Seleccione cliente</option>
                                @foreach($customer as $item)
                                    <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="campo-reporte">
                            <label>Existencia / Vendedor (opcional)</label>
                            <select name="user_id" class="linea-input">
                                <option value="">Seleccione usuario</option>
                                @foreach($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="reporte-btn-wrap">
                        <button type="submit" class="btn-reporte-custom">Generar reporte</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection