<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @include("menus.main")
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>

    <div class="sidebar-footer">
        <a href="https://www.neering.cl" class="link" target="_blank">
            <img src="{{ asset('assets/images/logo-neering.png') }}">
        </a> 
    </div>
    
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <!-- End Bottom points-->
</aside>