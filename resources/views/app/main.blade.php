@extends("layouts.base",["sidebar" => true])

@section("wrapper")
@if (!Auth::guest())
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row mb-3" style="border-bottom: 1px solid #E6E6E6">
                        <div class="col-md-6">
                            <h4 class="card-title m-b-5"><span class="lstick"></span>@yield("breadcrumb-title")</h4>
                            <div class="page-titles ">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
                                    @yield("breadcrumb")
                                </ol>
                            </div>
                        </div>
                        @yield("options")
                    </div>
                    @include("layouts.alerts")
                    @yield("content")
                </div>
            </div>
        </div>
    </div>
@else
    @yield("content")
@endif
@endsection