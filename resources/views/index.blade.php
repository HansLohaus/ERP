@extends("app.main")

{{-- Cabecera --}}
@section("title","Inicio")
@push("header")
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Inicio")
@section("breadcrumb")
    {{-- <li class="breadcrumb-item active" href="#"></li> --}}
@endsection

{{-- Contenido --}}
@section("content")
@endsection

{{-- Scripts --}}
@push("scripts")
<script type="text/javascript"> 
</script>
@endpush