@role('superadmin')

<li><a class="waves-effect waves-dark" aria-expanded="false" id="dropdownMenuLink" data-bs-toggle="dropdown"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Administración</span></a></li>

<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
	<li> <a class="waves-effect waves-dark" href="{{route('usuarios.index')}}" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Usuarios</span></a></li>
	<li> <a class="waves-effect waves-dark" href="{{route('logs')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Logs</span></a></li>
	<li> <a class="waves-effect waves-dark" href="{{route('ayuda')}}" aria-expanded="false"><i class="fa fa-info-circle"></i><span class="hide-menu">Ayuda</span></a></li>
</ul>

@endrole



<li> <a class="waves-effect waves-dark" href="{{route('clientes.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Clientes</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('proveedores.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Proveedores</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('servicios.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Servicio</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('facturas.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Facturas</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('pagos.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Pagos</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('trabajadores.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Trabajadores</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('boletasliquidaciones.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">BoletasLiquidaciones</span></a></li>

