@extends('include.master')

@section('title','Inventory | Reparaciones')

@section('page-title','Gestión de Reparaciones')

@section('content')

<style>
    .tabla-reparaciones th,
    .tabla-reparaciones td {
        vertical-align: middle !important;
        font-size: 13px;
    }

    .tabla-reparaciones th {
        font-weight: 700;
    }

    .btn-circle-custom {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,.18);
    }

    .btn-edit-custom {
        background: #2196f3;
    }

    .btn-delete-custom {
        background: #f44336;
    }

    .estado-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .estado-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .estado-proceso {
        background: #d1ecf1;
        color: #0c5460;
    }

    .estado-finalizado {
        background: #d4edda;
        color: #155724;
    }
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card">

            <div class="header">
                <h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-reparacion">
                        Reparación nueva
                    </button>
                </h2>
            </div>

            <div class="body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
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

                <form method="GET" action="{{ url('reparaciones') }}">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-6">
                            <input type="text"
                                   name="buscar"
                                   class="form-control"
                                   placeholder="Buscar por etiqueta"
                                   value="{{ request('buscar') }}">
                        </div>

                        <div class="col-md-6">
                            <select name="cliente_id" class="form-control">
                                <option value="">Todos los clientes</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->customer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped tabla-reparaciones">
                        <thead>
                            <tr>
                                <th>Etiqueta</th>
                                <th>Cliente</th>
                                <th>Equipo</th>
                                <th>Problema Encontrado</th>
                                <th>Accesorios</th>
                                <th>Estado</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Salida</th>
                                <th>Responsable</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reparaciones as $item)
                                <tr>
                                    <td>{{ $item->etiqueta }}</td>
                                    <td>
                                        @php
                                            $cliente = $clientes->firstWhere('id', $item->cliente_id);
                                        @endphp
                                        {{ $cliente ? $cliente->customer_name : 'Cliente no encontrado' }}
                                    </td>
                                    <td>{{ $item->equipo }}</td>
                                    <td>{{ $item->problema }}</td>
                                    <td>{{ $item->accesorios }}</td>
                                    <td>
                                        @php
                                            $estadoClass = 'estado-pendiente';
                                            if ($item->estado == 'proceso') $estadoClass = 'estado-proceso';
                                            if ($item->estado == 'finalizado') $estadoClass = 'estado-finalizado';
                                        @endphp

                                        <span class="estado-badge {{ $estadoClass }}">
                                            {{ $item->estado }}
                                        </span>
                                    </td>
                                    <td>{{ $item->fecha_ingreso }}</td>
                                    <td>{{ $item->fecha_salida }}</td>
                                    <td>{{ $item->responsable }}</td>

                                    <td>
                                        <button type="button"
                                                class="btn-circle-custom btn-edit-custom"
                                                data-toggle="modal"
                                                data-target="#edit-reparacion-{{ $item->id }}">
                                            <i class="material-icons">edit</i>
                                        </button>
                                    </td>

                                    <td>
                                        <form action="{{ url('reparaciones/delete/' . $item->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta reparación?');">
                                            <button type="submit" class="btn-circle-custom btn-delete-custom">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- MODAL EDITAR -->
                                <div class="modal fade" id="edit-reparacion-{{ $item->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <form action="{{ url('reparaciones/estado') }}" method="POST">
                                                

                                                <div class="modal-header">
                                                    <h4 class="modal-title">Editar estado de reparación</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Etiqueta</label>
                                                                <input type="text" class="form-control" value="{{ $item->etiqueta }}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Estado</label>
                                                                <select name="estado" class="form-control" required>
                                                                    <option value="pendiente" {{ $item->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                                    <option value="proceso" {{ $item->estado == 'proceso' ? 'selected' : '' }}>En proceso</option>
                                                                    <option value="finalizado" {{ $item->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No hay reparaciones registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    {{ $reparaciones->appends(request()->query())->links() }}
                </div>

            </div>

        </div>

    </div>
</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="create-reparacion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ url('reparaciones/store') }}" method="POST">
               

                <div class="modal-header">
                    <h4 class="modal-title">Nueva reparación</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cliente</label>
                                <select name="cliente_id" class="form-control" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Equipo</label>
                                <input type="text" name="equipo" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Problema</label>
                                <textarea name="problema" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Problema encontrado</label>
                                <textarea name="encontrado" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Accesorios</label>
                                <input type="text" name="accesorios" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable</label>
                                <input type="text" name="responsable" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de ingreso</label>
                                <input type="date" name="fecha_ingreso" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de salida</label>
                                <input type="date" name="fecha_salida" class="form-control">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="estado" value="pendiente">

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection