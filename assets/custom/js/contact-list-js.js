$(document).ready(function () {

  const app_uri = "/adminlte_practice01/";

  // Load table data using AJAX
  function loadTableData() {
    $.ajax({
      url: app_uri + "includes/functions.php", // Path to your PHP script
      method: "GET",
      data: {
        action: "readContacts",
      },
      dataType: "json",
      success: function (data) {
        let rows = "";
        data.forEach((item) => {
          rows += `<tr>
                                <td class="id">${item.id}</td>
                                <td class="image-path" data-src="${item.photo}"><img src="${app_uri}includes/${item.photo}" width="50px"></td>
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
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
      },
    });
  }

  loadTableData(); // Load table data on page load

  // Use event delegation for delete buttons
  $(document).on("click", ".delete-btn", function () {
    const button = $(this); // Reference to the clicked button
    const id = button.data("id");
    if (confirm("Are you sure you want to delete this row?")) {
      $.ajax({
        url: app_uri + "includes/functions.php", // PHP script to handle the data
        type: "POST",
        data: {
          id: id,
          action: "deleteContact",
        },
        success: function (response) {
          alert("Data deleted successfully: " + response);
          button.closest("tr").remove(); // Remove the row from the table
          loadTableData(); // Refresh the table
        },
        error: function (xhr, status, error) {
          alert("An error occurred: " + error);
        },
      });
    }
  });
});
