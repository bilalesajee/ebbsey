<header class="main-header">
    <?php $segment = Request::segment(1); ?>
    <!-- Logo -->
    <a href="<?= asset('admin_dashboard') ?>" class="logo"> 
        <span class="logo-mini"><b>E B </b></span> 
        <span class="logo-lg">
            <img src="<?= asset('adminassets/images/logo.png') ?>" class="user-image" alt="User Image">
 
        </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= asset('adminassets/images/admin.png') ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs">Administrator</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= asset('adminassets/images/admin.png') ?>" class="img-circle" alt="User Image">
                            <p>Administrator</p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= asset('change_password_admin') ?>" class="btn btn-default btn-flat">Change Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= asset('logout_admin') ?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

    </nav>
</header>