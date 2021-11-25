<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('index') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="FutureAdmin" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>Future</b>Admin</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->avatar ?? asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="{{ Auth::user()->getName() }}">
            </div>
            <div class="info w-100">
                <a href="#" class="d-block">{{ Auth::user()->getName() }}</a>
            </div>
            <div class="logout">
                <a href="{{ route('admin.auth.sign-out') }}" title="Выйти" class="btn"><i class="fas fa-sign-out-alt fa-fw"></i></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <x-future-menu/>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
