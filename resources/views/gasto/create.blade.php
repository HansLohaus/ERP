@extends("app.main")

{{-- Cabecera --}}
@section("title","Gastos")
@push("header")
<style type="text/css"></style>
@endpush
{{-- Breadcrumb --}}
@section("breadcrumb-title","Gastos")
@section("breadcrumb")
    <li class="breadcrumb-item">Gastos</li>
    <li class="breadcrumb-item active">Nuevo Gasto</li>
@endsection
{{-- Contenido --}}
@section("content")


<div class="col-md-12 col-md-offset-2"> 
      @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Error!</strong> Revise los campos obligatorios.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Nuevo Gasto</h3>
        </div>
        <div class="panel-body">          
          <div class="table-container">
            <form method="POST" action="{{ route('gastos.store') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Trabajador</label>
                    <select name="trabajador_id" id="trabajador_id" class="form-control input-sm">
                      <option value="" disabled hidden>Seleccione trabajador</option>
                      @foreach ($trabajadores as $trabajador)
                        <option value="{{ $trabajador->id }}">{{$trabajador->nombres}} {{$trabajador->apellidoP}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto</label>
                    <input type="number" name="monto" id="monto" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" name="descrip" id="descrip" class="form-control input-sm">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <input type="submit"  value="Guardar" class="btn btn-success btn-block">
                  <a href="{{ route('gastos.index') }}" class="btn btn-info btn-block" >Atrás</a>
                </div>  
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


@endsection
@push("scripts")
<script type="text/javascript"> 
</script>
@endpush