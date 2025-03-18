<?php

require_once "includes/functions.php";

include "layout/header.php";

?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php
        include "layout/main-header.php";
        include "layout/sidebar.php";
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
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <a href="contact-list.php" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- DONUT CHART -->
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Gender Chart</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <canvas id="pieChart" style="height:250px"></canvas>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
        </div>
        <?php
        include "layout/main-footer.php";
        include "layout/control-sidebar.php";
        ?>
    </div>
    <?php
    include "layout/footer.php";
    ?>

    <script>
        //jquery scripts starts
        $(document).ready(function() {
            //dashboard ajax scripts starts
            $.ajax({
                url: window.location.href, // Replace with your API endpoint
                method: 'POST', // You can change this to POST if needed
                dataType: 'json',
                data: {
                    action: "readContacts"
                },
                success: function(response) {
                    // Check if the response is an array
                    if (Array.isArray(response.data)) {
                        let rowCount = response.data.length; // Get the number of rows
                        // console.log('Number of rows:', rowCount);
                        document.getElementById('contact-num').innerHTML = rowCount;
                    } else {
                        console.log('The response is not an array.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', status, error);
                }
            });
            //dashboard ajax scripts ends
        });
        //jquery scripts ends

        //pie chart scripts starts
        $(function() {
            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas);
            var PieData = [{
                    value: <?php echo genderCount("male"); ?>,
                    color: "#00a65a",
                    highlight: "#00a65a",
                    label: "Male"
                },
                {
                    value: <?php echo genderCount("female"); ?>,
                    color: "#f56954",
                    highlight: "#f56954",
                    label: "Female"
                }
            ];
            var pieOptions = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke: true,
                //String - The colour of each segment stroke
                segmentStrokeColor: "#fff",
                //Number - The width of each segment stroke
                segmentStrokeWidth: 2,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 50, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps: 100,
                //String - Animation easing effect
                animationEasing: "easeOutBounce",
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate: true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale: false,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true,
                // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
            };
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            pieChart.Doughnut(PieData, pieOptions);
        });
        //pie chart scripts ends
    </script>