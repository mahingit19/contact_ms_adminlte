<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets\img\profile-picture.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['username'] ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="menu-links"><a href="<?= APP_URI ?>/"><i class="bi bi-speedometer"></i> <span>Dashboard</span></a></li>
            <li class="menu-links"><a href="<?= APP_URI ?>/contact-list.php"><i class="bi bi-person-lines-fill"></i> <span>Contact List</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function() {
        // Get the current URL path
        var currentPath = window.location.href;

        // Loop through all <a> tags in the menu and check their href
        $(".sidebar-menu .menu-links a").each(function() {
            if ($(this).attr("href") === currentPath) {
                // Add active class to the parent <li> if href matches the current path
                $(this).parent("li").addClass("active");
            }
        });
    });
</script>