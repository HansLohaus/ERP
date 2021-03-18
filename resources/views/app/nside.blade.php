@extends("layouts.base",["sidebar" => false])

@section("wrapper")
@if (!Auth::guest())
    <div class="row">
        <div class="col-lg-12">
            @include("layouts.alerts")
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title m-b-5"><span class="lstick"></span>@yield("breadcrumb-title")</h4>
                        </div>
                        <div class="col-md-6 align-self-center page-titles">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
                                @yield("breadcrumb")
                            </ol>
                        </div>
                    </div>
                    <hr style="margin-top:0px;">
                    @yield("content")
                </div>
            </div>
        </div>
    </div>
@else
    @yield("content")
@endif
@endsection