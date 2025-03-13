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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Contact List
                    <small>All the contact lists are here</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Contact List</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="box">
                    <div class="box-header" style="display: flex;">
                        <h3 class="box-title">Contact Table</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="addNewBtn" style="margin-left: auto;">
                            <i class="bi bi-person-plus-fill"></i> Add New Contact
                        </button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="overflow-x: auto;">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Image</th>
                                                <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" aria-sort="descending">Full Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Email</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Address</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <!-- Table data goes here -->

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </section>

        </div>

        <?php
        include $APP_URL . ("/layout/main-footer.php");
        include $APP_URL . ("/layout/control-sidebar.php");
        ?>

    </div>

    <script src="/<?= $APP_NAME ?>/assets/custom/js/contact-list-js.js"></script>
    <!-- /.content -->

    <?php include $APP_URL . "/pages/form-modal.php"; ?>

    <?php
    include $APP_URL . ("/layout/footer.php");
    ?>