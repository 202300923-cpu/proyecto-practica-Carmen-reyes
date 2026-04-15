@extends('include.master')

@section('title','Inventory | Usuarios')

@section('page-title','Usuarios')

@section('content')

<div class="row clearfix">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card">

            <div class="header">
                <h2>
                    <button type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#create-user">
                        Usuario nuevo
                    </button>
                </h2>
            </div>

            <div class="body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- BUSCAR -->

                <form method="GET">

                    <div class="row">

                        <div class="col-md-6">
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Buscar por nombre">
                        </div>

                        <div class="col-md-6">
                            <input type="text"
                                   name="email"
                                   class="form-control"
                                   placeholder="Buscar por correo">
                        </div>

                    </div>

                </form>

                <br>

                <!-- TABLA -->

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Rol</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($users as $user)

                        <tr>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>Superadministrador</td>

                            <td>

                                <button class="btn btn-info btn-circle">
                                    <i class="material-icons">edit</i>
                                </button>

                            </td>

                            <td>

                                <form method="POST"
                                      action="{{ route('user.destroy',$user->id) }}">

                                    <button class="btn btn-danger btn-circle">
                                        <i class="material-icons">delete</i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- MODAL CREAR USUARIO -->

<div class="modal fade" id="create-user">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST" action="{{ route('user.store') }}">

                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">
                        Crear Usuario
                    </h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nombre</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Correo</label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Contraseña</label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary">
                        Guardar
                    </button>

                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">
                        Cancelar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection