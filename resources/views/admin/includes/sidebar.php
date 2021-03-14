<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="<?= $segment == 'admin_dashboard' ? 'active' : '' ?>">
                <a href="<?= asset('admin_dashboard') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>

            </li>

            <li class="treeview <?= $segment == 'users_admin' || $segment == 'trainers_admin' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'users_admin' ? 'active' : '' ?>"><a href="<?= asset('users_admin') ?>"><i class="fa fa-circle-o"></i> Users</a></li>
                    <li class="<?= $segment == 'trainers_admin' ? 'active' : '' ?>"><a href="<?= asset('trainers_admin') ?>"><i class="fa fa-circle-o"></i> Trainers</a></li>
                </ul>
            </li>


            <li class="<?= ($segment == 'trainer_approvals') ? 'active' : '' ?>">
                <a href="<?= asset('trainer_approvals') ?>">
                    <i class="fa fa-user-plus"></i> <span>Trainer Approvals Requests</span>
                </a>
            </li>

            <li class="treeview <?= $segment == 'all_session' || $segment == 'all_classes' ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span>Session Appointments <br> & Classes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $segment == 'all_session' ? 'active' : '' ?>"><a href="<?= asset('all_session') ?>"><i class="fa fa-circle-o"></i> Sessions</a></li>
                    <li class="<?= $segment == 'all_classes_appointments' ? 'active' : '' ?>"><a href="<?= asset('all_classes_appointments') ?>"><i class="fa fa-circle-o"></i> Classes Appointments</a></li>
                    <li class="<?= $segment == 'all_classes' ? 'active' : '' ?>"><a href="<?= asset('all_classes') ?>"><i class="fa fa-circle-o"></i> Classes</a></li>
                </ul>
            </li>
 
            <li class="<?= $segment == 'reviews' ? 'active' : '' ?>">
                <a href="<?= asset('reviews') ?>">
                    <i class="fa fa-star" aria-hidden="true"></i> <span>Ratings</span>
                </a>
            </li>

            <li class="<?= $segment == 'feedbacks' ? 'active' : '' ?>">
                <a href="<?= asset('feedbacks') ?>">
                    <i class="fa fa-envelope" aria-hidden="true"></i><span>User's Feedback</span>
                </a>
            </li>

            <li class="<?= $segment == 'class_gallery' ? 'active' : '' ?>">
                <a href="<?= asset('class_gallery') ?>">
                    <i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Class Gallery</span>
                </a>
            </li>

            <li class="<? = $segment == 'class_types' ? 'active' : '' ?>">
                <a href="<?= asset('class_types')?>">
                    <i class="fa fa-plus-circle"></i> <span>Class Types</span>
                </a>
            </li>

            <li class="<?= $segment == 'fitness_goals_admin' ? 'active' : '' ?>">
                <a href="<?= asset('fitness_goals_admin') ?>">
                    <i class="fa fa-plus-circle"></i> <span>Fitness Goals</span>
                </a>
            </li>

            <li class="<?= $segment == 'specializations_admin' ? 'active' : '' ?>">
                <a href="<?= asset('specializations_admin') ?>">
                    <i class="fa fa-plus-circle"></i> <span>Discipline </span>
                </a>
            </li>

            <li class="<?= $segment == 'training_types_admin' ? 'active' : '' ?>">
                <a href="<?= asset('training_types_admin') ?>">
                    <i class="fa fa-plus-circle"></i> <span>Training Types</span>
                </a>
            </li>

            <li class="<?= $segment == 'qualifications_admin' ? 'active' : '' ?>">
                <a href="<?= asset('qualifications_admin') ?>">
                    <i class="fa fa-plus-circle"></i> <span>Qualifications</span>
                </a>
            </li>

            <li class="<?= ($segment == 'business_cards_orders' || $segment == 'view_order_detail') ? 'active' : '' ?>">
                <a href="<?= asset('business_cards_orders') ?>">
                    <i class="fa fa-address-card"></i> <span>Fitness Card</span>
                </a>
            </li>
            
            <li class="<?= $segment == 'coupons' ? 'active' : '' ?>">
                <a href="<?= asset('coupons') ?>">
                    <i class="fa fa-gift"></i> <span>Coupons</span>
                </a>
            </li>
            
            <li class="<?= ($segment == 'manage_pages' || $segment == 'add_pages') ? 'active' : '' ?>">
                <a href="<?= asset('manage_pages') ?>">
                    <i class="fa fa-address-card"></i> <span>Manage Pages</span>
                </a>
            </li>

<!--            <li class="<?= $segment == 'pass_price' ? 'active' : '' ?>">
    <a href="<?= asset('pass_price') ?>">
        <i class="fa fa-usd" aria-hidden="true"></i> <span>Change Pass Price</span>
    </a>
</li>-->

            <li class="<?= $segment == 'change_password_admin' ? 'active' : '' ?>">
                <a href="<?= asset('change_password_admin') ?>">
                    <i class="fa fa-lock"></i> <span>Change Password</span>
                </a>
            </li>

            <li>
                <a href="<?= asset('logout_admin') ?>">
                    <i class="fa fa-sign-out"></i> <span>Sign out</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    $(document).ready(function () {
        $('li.active').parent('.treeview-menu').toggle();
    });
</script>