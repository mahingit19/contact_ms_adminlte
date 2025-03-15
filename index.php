<?php

require_once "includes/functions.php";

include "includes/session.php" ;

include "layout/header.php" ;

?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php
        include "layout/main-header.php" ;
        include "layout/sidebar.php" ;
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Your customized admin panel</small>
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
                            <a href="contact-list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php
        include "layout/main-footer.php" ;
        include "layout/control-sidebar.php" ;
        ?>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: window.location.href, // Replace with your API endpoint
                method: 'GET', // You can change this to POST if needed
                dataType: 'json',
                data: {
                    action: "readContacts",
                },
                success: function(response) {
                    // Check if the response is an array
                    if (Array.isArray(response)) {
                        let rowCount = response.length; // Get the number of rows
                        console.log('Number of rows:', rowCount);
                        document.getElementById('contact-num').innerHTML = rowCount;
                    } else {
                        console.log('The response is not an array.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', status, error);
                }
            });
        });
    </script>

    <?php
    include "layout/footer.php" ;
    ?>