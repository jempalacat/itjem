<?php 
session_start();
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDICORDS</title>
    <link rel="stylesheet" href="css/user_mngt.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<div class="user">
    <div class="user_header">
        <h5>USER MANAGEMENT</h5>
    </div>
    <div class="content">
        <div class="user-activity-header">
            <h5>User List</h5>
            <?php include 'newuser.php' ?>
            <button class="addnew" data-toggle="modal" data-target="#registrationModal"><strong>+ ADD NEW</strong></button>
        </div>
        <button class="users"><a href="user_mngt.php"><strong>User Activities</strong></a></button><br>
        <table id="addedTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                 include 'includes/db_connect.php';
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        // Concatenate first name, middle name, and last name
                        $fullName = $row["last_name"] . ", " . $row["first_name"];
                        if (!empty($row["middle_name"])) {
                            $fullName .= " " . $row["middle_name"];
                        }

                        // Determine button text based on active_status
                        $buttonText = $row["active_status"] == 'Active' ? "Deactivate" : "Activate";
                        $buttonClass = $row["active_status"] == 'Active' ? "btn-danger" : "btn-success";
                        $toggleAction = $row["active_status"] == 'Active' ? "deactivateUser" : "activateUser";

                        echo "<tr id='userRow_" . $row["user_id"] . "'>";
                        echo "<td>" . $row["user_id"] . "</td>";
                        echo "<td>" . $fullName . "</td>";
                        echo "<td>" . $row["user_type"] . "</td>";
                        echo "<td>" . $row["active_status"] . "</td>"; // Display current status
                        echo "<td>
                            <button class='btn btn-info btn-sm' onclick='viewUser(" . $row["user_id"] . ")'>View</button>
                            <button class='btn btn-primary btn-sm' onclick='editUser(" . $row["user_id"] . ")'>Edit</button>
                            <button class='btn " . $buttonClass . " btn-sm' onclick='" . $toggleAction . "(" . $row["user_id"] . ")'>" . $buttonText . "</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div id="pagination" class="mt-3"></div>
    </div>
</div>


<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">View User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="modal-body">
                <!-- Display user details here -->
                <p><strong>User ID:</strong> <span id="viewUserId"></span></p>
                <p><strong>Name:</strong> <span id="viewUserName"></span></p>
                <p><strong>User Type:</strong> <span id="viewUserType"></span></p>
                <p><strong>Address:</strong> <span id="viewAddress"></span></p>
                <p><strong>Email Address:</strong> <span id="viewEmail"></span></p>
                <p><strong>Mobile Number:</strong> <span id="viewNumber"></span></p>
                
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editMiddleName">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddleName" name="middle_name">
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserType">User Type</label>
                        <input type="text" class="form-control" id="editUserType" name="user_type" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email Address</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editNumber">Mobile Number</label>
                        <input type="tel" class="form-control" id="editNumber" name="mobile_number" required>
                    </div>
                    <input type="hidden" id="editUserId" name="user_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateUser()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
<script src="pagination.js" defer></script>

<script>
    $(document).ready(function() {
        $('#addedTable').DataTable();
    });

    function viewUser(userId) {
        $.ajax({
            type: "GET",
            url: "fetch_user.php",
            data: { id: userId },
            dataType: "json",
            success: function(user) {
                $('#viewUserId').text(user.user_id);
                $('#viewUserName').text(user.first_name + ' ' + user.last_name);
                $('#viewUserType').text(user.user_type);
                $('#viewNumber').text(user.mobile_number);
                $('#viewEmail').text(user.email);
                $('#viewAddress').text(user.address);
                $('#viewUserModal').modal('show');
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred: " + error, "error");
            }
        });
    }

    function editUser(userId) {
    $.ajax({
        type: "GET",
        url: "fetch_user.php",
        data: { id: userId },
        dataType: "json",
        success: function(user) {
            $('#editFirstName').val(user.first_name);
            $('#editMiddleName').val(user.middle_name);
            $('#editLastName').val(user.last_name);
            $('#editUserType').val(user.user_type);
            $('#editAddress').val(user.address);
            $('#editEmail').val(user.email);
            $('#editNumber').val(user.mobile_number);
            // No need to handle active_status here
            $('#editUserId').val(user.user_id);
            $('#editUserModal').modal('show');
        },
        error: function(xhr, status, error) {
            swal("Error", "An error occurred: " + error, "error");
        }
    });
}


    function updateUser() {
        var formData = $('#editUserForm').serialize();
        $.ajax({
            type: "POST",
            url: "update_user.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                if(response.status === 'success') {
                    swal("Success", response.message, "success");
                    $('#editUserModal').modal('hide');
                    location.reload(); // Reload to reflect the changes
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred: " + error, "error");
            }
        });
    }


    function activateUser(userId) {
    swal({
        title: "Are you sure?",
        text: "This user will be activated!",
        icon: "warning",
        buttons: true,
        dangerMode: false,
    })
    .then((willActivate) => {
        if (willActivate) {
            $.ajax({
                type: "POST",
                url: "updatestatus_user.php",
                data: { id: userId, active_status: 'Active' },
                dataType: "json",
                success: function(response) {
                    if(response.status === 'success') {
                        location.reload(); // Reload to reflect the changes
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred: " + error, "error");
                }
            });
        } else {
            swal("User activation cancelled!");
        }
    });
}

function deactivateUser(userId) {
    swal({
        title: "Are you sure?",
        text: "This user will be deactivated and will no longer be able to access the system!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDeactivate) => {
        if (willDeactivate) {
            $.ajax({
                type: "POST",
                url: "updatestatus_user.php",
                data: { id: userId, active_status: 'Inactive' },
                dataType: "json",
                success: function(response) {
                    if(response.status === 'success') {
                        location.reload(); // Reload to reflect the changes
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred: " + error, "error");
                }
            });
        } else {
            swal("User deactivation cancelled!");
        }
    });
}


</script>

</body>
</html>
