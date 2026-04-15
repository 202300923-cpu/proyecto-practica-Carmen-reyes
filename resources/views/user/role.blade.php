@extends('include.master')

@section('title','Inventory | Gestión de roles')

@section('page-title','Gestión de roles')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-role">
                        Rol nuevo
                    </button>
                </h2>
            </div>

            <div class="body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Otorgar permiso</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->role_name }}</td>

                                <td>
                                    <a href="{{ url('role/' . $role->id) }}" class="btn btn-info btn-circle">
                                        <i class="material-icons">vpn_key</i>
                                    </a>
                                </td>

                                <td>
                                    <button type="button"
                                            class="btn btn-primary btn-circle"
                                            data-toggle="modal"
                                            data-target="#edit-role-{{ $role->id }}">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </td>

                                <td>
                                    <form action="{{ url('role/delete/' . $role->id) }}" method="GET" onsubmit="return confirm('¿Deseas eliminar este rol?');">
                                        <button type="submit" class="btn btn-danger btn-circle">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- MODAL EDITAR ROL -->
                            <div class="modal fade" id="edit-role-{{ $role->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ url('role/update/' . $role->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Editar rol</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nombre del rol</label>
                                                    <input type="text" name="role_name" class="form-control" value="{{ $role->role_name }}" required>
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
                                <td colspan="4" class="text-center">No hay roles registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR ROL -->
<div class="modal fade" id="create-role" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Crear nuevo rol</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del rol</label>
                        <input type="text" name="role_name" class="form-control" required>
                    </div>
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