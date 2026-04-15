@extends('include.master')

@section('title','Inventory | Existencias')

@section('page-title','Lista de Existencias')

@section('content')

<style>
    .stock-card .body {
        padding: 22px;
    }
    .stock-top-form {
        margin-bottom: 20px;
    }
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card stock-card">
            <div class="header">
                <h2>Agregar Existencias</h2>
            </div>

            <div class="body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom:0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stock.store') }}" method="POST" class="stock-top-form">
                    @csrf

                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Seleccione categoría</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Producto</label>
                                <select name="product" class="form-control" required>
                                    <option value="">Seleccione producto</option>
                                    @foreach($product as $item)
                                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Proveedor</label>
                                <select name="vendor" class="form-control" required>
                                    <option value="">Seleccione proveedor</option>
                                    @foreach($vendor as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Precio de compra</label>
                                <input type="number" step="0.01" name="buying_price" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Precio de venta</label>
                                <input type="number" step="0.01" name="selling_price" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nota</label>
                                <input type="text" name="note" class="form-control" placeholder="Nota opcional">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-teal waves-effect">
                            Guardar existencia
                        </button>
                    </div>
                </form>

                <hr>

                <h4 style="margin-bottom:15px;">Listado rápido</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Producto</th>
                                <th>Proveedor</th>
                                <th>Cantidad</th>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stocks = \App\Stock::with(['category:id,name','product:id,product_name','vendor:id,name'])
                                    ->orderBy('id','desc')
                                    ->take(10)
                                    ->get();
                            @endphp

                            @forelse($stocks as $item)
                                <tr>
                                    <td>{{ optional($item->category)->name }}</td>
                                    <td>{{ optional($item->product)->product_name }}</td>
                                    <td>{{ optional($item->vendor)->name }}</td>
                                    <td>{{ $item->current_quantity }}</td>
                                    <td>{{ $item->buying_price }}</td>
                                    <td>{{ $item->selling_price }}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay existencias registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection