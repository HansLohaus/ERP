<li> <a class="waves-effect waves-dark" href="{{route('facturas.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Facturas</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('pagos.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Pagos</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('boletasliquidaciones.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">BoletasLiquidaciones</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('servicios.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Presupuestos</span></a></li>

	
<li> <a class="waves-effect waves-dark" href="{{route('clientes.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Clientes</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('proveedores.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Proveedores</span></a></li>

<li> <a class="waves-effect waves-dark" href="{{route('trabajadores.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Recursos humanos</span></a></li>

@role('superadmin')

<li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-format-list-bulleted"></i>
        <span class="hide-menu">Administración</span>
    </a>
    <ul aria-expanded="false" class="collapse">
    	<li> <a class="waves-effect waves-dark" href="{{route('usuarios.index')}}" aria-expanded="false"><i class="mdi mdi-account"></i><span>Usuarios</span></a></li>
		<li> <a class="waves-effect waves-dark" href="{{route('logs')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span>Logs</span></a></li>
		<li> <a class="waves-effect waves-dark" href="{{route('ayuda')}}" aria-expanded="false"><i class="fa fa-info-circle"></i><span>Ayuda</span></a></li>
    </ul>
</li>

@endrole

{{-- <li> <a class="waves-effect waves-dark" href="{{route('gastos.index')}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Gastos</span></a></li> --}}