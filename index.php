<?php

$APP_NAME = "adminlte_practice01";
$APP_URL = $_SERVER['DOCUMENT_ROOT'] . "/$APP_NAME";

session_start();
if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
    header("Location: /$APP_NAME/pages/login-page.php");
    exit;
}

include $APP_URL . ("/layout/header.php");

?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php
        include $APP_URL . ("/layout/main-header.php");
        include $APP_URL . ("/layout/sidebar.php");
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>All the contact lists are here</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3 id="contact-num"></h3>

                                <p>Contact List</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="/<?= $APP_NAME ?>/pages/contact-list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php
        include $APP_URL . ("/layout/main-footer.php");
        include $APP_URL . ("/layout/control-sidebar.php");
        ?>
    </div>

    <script src="/<?= $APP_NAME ?>/assets/custom/js/dashboard-js.js"></script>

    <?php
    include $APP_URL . ("/layout/footer.php");
    ?>