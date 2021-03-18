<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    @if (File::exists(public_path("assets/images/users/".Auth::user()->id.".jpg")))
    <img src="{{ asset('assets/images/users/'.Auth::user()->id.'.jpg') }}" alt="user" class="profile-pic"/>
    @else
    <img src="{{ asset('assets/images/users/user.png') }}" alt="user" class="profile-pic"/>
    @endif
    <span class="hidden-sm-down">&nbsp;&nbsp;&nbsp;{{ Auth::user()->name }}</span></a>
    <div class="dropdown-menu dropdown-menu-right scale-up">
        <ul class="dropdown-user">
            <li>
                <div class="dw-user-box">
                    <div class="u-img" style="width: 70px;">
                        @if (File::exists(public_path("assets/images/users/".Auth::user()->id.".jpg")))
                        <img src="{{ asset('assets/images/users/'.Auth::user()->id.'.jpg') }}" alt="user"/>
                        @else
                        <img src="{{ asset('assets/images/users/user.png') }}" alt="user"/>
                        @endif
                    </div>
                    <div class="u-text">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>{{-- <a href="#" class="btn btn-rounded btn-danger btn-sm">Ver Perfil</a> --}}
                    </div>
                </div>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="Cerrar sesión"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</li>