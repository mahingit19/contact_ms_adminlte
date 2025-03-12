<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Contact List
        <small>All the contact lists are here</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
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
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
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
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            <ul class="pagination">
                                <li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li>
                                <li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li>
                                <li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</section>

<script>
    $(document).ready(function() {
        // Load table data using AJAX
        function loadTableData() {
            $.ajax({
                url: "functions.php", // Path to your PHP script
                method: "GET",
                data: {
                    action: 'readContacts'
                },
                dataType: "json",
                success: function(data) {
                    let rows = "";
                    data.forEach(item => {
                        rows += `<tr>
                                    <td class="id">${item.id}</td>
                                    <td class="image-path" data-src="../../model/${item.photo}"><img src="../../model/${item.photo}" width="50px"></td>
                                    <td><span class="first-name">${item.first_name}</span> <span class="last-name">${item.last_name}</span></td>
                                    <td class="email">${item.email}</td>
                                    <td>+880<span class="phone">${item.phone}</span></td>
                                    <td><span class="address">${item.address}</span>, <span class="city">${item.city}</span>, <span class="state">${item.state}</span>, <span class="zip">${item.zip}</span>, <span class="country">${item.country}</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary edit-btn"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-danger delete-btn" data-id="${item.id}"><i class="bi bi-trash3-fill"></i></button>
                                        </div>
                                    </td>
                                </tr>`;
                    });
                    $("#table-body").html(rows);
                    $("#total").html($(data).length);


                },
                error: function(xhr, status, error) {
                    console.error("An error occurred:", error);
                }
            });
        }

        loadTableData(); // Load table data on page load

        // Use event delegation for delete buttons
        $(document).on("click", ".delete-btn", function() {
            const button = $(this); // Reference to the clicked button
            const id = button.data("id");
            if (confirm("Are you sure you want to delete this row?")) {
                $.ajax({
                    url: "functions.php", // PHP script to handle the data
                    type: "POST",
                    data: {
                        id: id,
                        action: 'deleteContact'
                    },
                    success: function(response) {
                        alert("Data deleted successfully: " + response);
                        button.closest("tr").remove(); // Remove the row from the table
                        loadTableData(); // Refresh the table
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            }
        });
    });
</script>
<!-- /.content -->

<?php include "includes/form-modal.php"; ?>