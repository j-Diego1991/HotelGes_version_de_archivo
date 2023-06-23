<!--Llamar al Layout-->
@extends('layout')

<!--Contenido que se invoca en el Layout-->
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-lg-12 margin-tb">


                <div class="pull-right">
                    <div class="container">
                        <div class="pull-left">
                            <h1>Usuarios</h1>
                        </div>
                        <a class="btn btn-success" href="{{ route('users.create') }}">Nuevo usuario</a>
                    </div>

                </div>
            </div>
        </div>
        <br>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <br>
        <div class="container">
            <table class="table table-bordered">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo electronico</th>
                    <th>Rol de usuario</th>

                    <th width="280px">Acciones</th>
                </tr>

                @foreach ($users as $user)
                    <tr class="white-cell">
                        {{-- <td>{{ ++$i }}</td> --}}
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        {{-- <td>{{ $user->role_id }}</td> --}}
                        @switch( $user->role_id )
                        @case(1)
                            <th>Administrador de IT</th>
                        @break
                        @case(2)
                            <th>Gerente de hotel</th>
                        @break
                        @case(3)
                        <th>Operario</th>
                        @break
                        @endswitch
                        <td>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <table>
                                    <tr>
                                        <td class="non-cell">
                                            <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Ver</a>
                                        </td>
                                        <td class="non-cell">
                                            <a class="btn btn-primary"
                                                href="{{ route('users.edit', $user->id) }}">Editar</a>
                                        </td>
                                        <td class="non-cell">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="confirmDelete(event, {{ $user->id }})">Eliminar</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>

        <script>
            function confirmDelete(event, typeId) {
                event.preventDefault();
                if (confirm('¿Está seguro que desea eliminar esta habitación?')) {
                    document.getElementById('delete-form-' + typeId).submit();
                }
            }
        </script>
    </div>
@endsection
