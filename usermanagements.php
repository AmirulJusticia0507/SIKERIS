<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna telah terautentikasi
if (!isset($_SESSION['userid'])) {
    // Jika tidak ada sesi pengguna, alihkan ke halaman login
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management SIKERIS (Sistem Kerjasama BPRS dengan Notaris) - BPRS HIK MCI Yogyakarta</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Tambahkan link AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="icon" href="img/logo_white.png" type="image/png">
    <style>
        .myButton {
            box-shadow: 3px 4px 0px 0px #899599;
            background: linear-gradient(to bottom, #ededed 5%, #bab1ba 100%);
            background-color: #ededed;
            border-radius: 10px;
            border: 1px solid #d6bcd6;
            display: inline-block;
            cursor: pointer;
            color: #3a8a9e;
            font-family: Arial;
            font-size: 10px;
            padding: 7px 25px;
            text-decoration: none;
            text-shadow: 0px 1px 0px #e1e2ed;
        }

        .myButton:hover {
            background: linear-gradient(to bottom, #bab1ba 5%, #ededed 100%);
            background-color: #bab1ba;
        }

        .myButton:active {
            position: relative;
            top: 1px;
        }
    </style>


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <?php include 'header.php'; ?>
        </nav>

        <?php include 'sidebar.php'; ?>

        <div class="content-wrapper">
            <main class="content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    if ($page === 'usermanagements' && basename($_SERVER['PHP_SELF']) !== 'usermanagements.php') {
                        header("Location: usermanagements.php");
                        exit;
                    }
                    elseif ($page === 'settingbank' && basename($_SERVER['PHP_SELF']) !== 'settingbank.php') {
                        header("Location: settingbank.php");
                        exit;
                    }
                    elseif ($page === 'settingnotaris' && basename($_SERVER['PHP_SELF']) !== 'settingnotaris.php') {
                        header("Location: settingnotaris.php");
                        exit;
                    }
                    elseif ($page === 'progesspengikatan' && basename($_SERVER['PHP_SELF']) !== 'progesspengikatan.php') {
                        header("Location: progesspengikatan.php");
                        exit;
                    }
                    elseif ($page === 'chat_dialog' && basename($_SERVER['PHP_SELF']) !== 'chat_dialog.php') {
                        header("Location: chat_dialog.php");
                        exit;
                    }
                    // elseif ($page === 'lantai_2' && basename($_SERVER['PHP_SELF']) !== 'lantai_2.php') {
                    //     header("Location: lantai_2.php");
                    //     exit;
                    // }
                    elseif ($page === 'dashboard' && basename($_SERVER['PHP_SELF']) !== 'index.php') {
                        // echo "<h2>Dashboard Sistem Report</h2>";
                        header("Location: index.php");
                        exit;
                    }
                }
                ?>
                <div class="container">
                    <div class="card">
                        <div class="card-body" id="resultsContent">
                            <h2><i class="fa fa-users"></i> User Management</h2><br>
                            
                            <!-- Modal Add User -->
                            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createModalLabel">Add User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk menambahkan pengguna -->
                                            <form action="add_user_process.php" method="post">
                                                <!-- Tambahkan elemen formulir sesuai kebutuhan -->
                                                <div class="mb-3">
                                                    <label for="fullname" class="form-label">Fullname :</label>
                                                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username :</label>
                                                    <input type="text" class="form-control" id="username" name="username" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password :</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password" name="password" required>
                                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="user_role" class="form-label">User Role</label>
                                                    <select class="form-select" id="user_role" name="user_role" required>
                                                        <option value="Superadmin">Superadmin</option>
                                                        <option value="Notaris">Notaris</option>
                                                    </select>
                                                </div>
                                                <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                                                <div class="row justify-content-center" align="center">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Submit</button>&emsp;
                                                    <button type="reset" class="btn btn-danger"><i class="fa fa-power-off"></i> Reset</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>

                            <!-- Modal User Details -->
                            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel">User Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="detailsModalBody">
                                            <!-- User details will be displayed here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button type="button" class="myButton" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa fa-plus"></i> Add User</button>&emsp;
                                <button class="myButton" onclick="refreshPage()"><i class="fa fa-sync"></i> Refresh</button>
                            </div><br>
                            <table id="userTable" class="display table table-bordered table-striped table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Created At</th>
                                        <th>User Role</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $server = "192.168.1.184";
                                    // $server = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $database = "db_mobile_collection";
                                    
                                    // Buat koneksi ke server
                                    $connectionServernew = new mysqli($server, $username, $password, $database);
                                    
                                    // Periksa koneksi ke server
                                    if ($connectionServernew->connect_error) {
                                        $hasil['STATUS'] = "000199";
                                        die(json_encode($hasil));
                                    }
                                    // Ambil data pengguna dari database dan tampilkan dalam tabel
                                    $query = "SELECT 	
                                        userid, 
                                        username, 
                                        fullname,
                                        DATE_FORMAT(created_at, '%d-%m-%Y') AS formatted_created_at,
                                        user_role
                                         
                                        FROM 
                                        db_mobile_collection.users_new";
                                    $result = $connectionServernew->query($query);

                                    $nomorUrutTerakhir = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $nomorUrutTerakhir . "</td>";
                                        echo "<td>{$row['username']}</td>";
                                        echo "<td>{$row['fullname']}</td>";
                                        echo "<td>{$row['formatted_created_at']}</td>";
                                        echo "<td>{$row['user_role']}</td>";
                                        echo "<td>
                                                <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateModal' data-userid='{$row['userid']}' data-username='{$row['username']}' data-fullname='{$row['fullname']}' data-userrole='{$row['user_role']}'><i class='fa fa-pen'></i> Update</button>
                                                <button type='button' class='btn btn-danger btn-sm' onclick='confirmDelete({$row['userid']})'><i class='fa fa-trash'></i> Delete</button>
                                                <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#detailsModal' onclick='loadUserDetails({$row['userid']})'><i class='fa fa-eye'></i> Details</button>
                                            </td>";
                                        $nomorUrutTerakhir++;
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- Modal Update User -->
                            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk mengupdate pengguna -->
                                            <form action="update_user_process.php" method="post">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                                <!-- Tambahkan elemen formulir sesuai kebutuhan -->
                                                <div class="mb-3">
                                                    <label for="updateFullname" class="form-label">Fullname :</label>
                                                    <input type="text" class="form-control" id="updateFullname" name="updateFullname" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateUsername" class="form-label">Username :</label>
                                                    <input type="text" class="form-control" id="updateUsername" name="updateUsername" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updatePassword" class="form-label">Password :</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="updatePassword" name="updatePassword" required>
                                                        <button class="btn btn-outline-secondary" type="button" id="toggleUpdatePassword">Show</button>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateUserRole" class="form-label">User Role</label>
                                                    <select class="form-select" id="updateUserRole" name="updateUserRole" required>
                                                        <option value="Superadmin">Superadmin</option>
                                                        <option value="Notaris">Notaris</option>
                                                    </select>
                                                </div>
                                                <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                                                <button type="submit" class="btn btn-primary">Update User</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <!-- jQuery, Bootstrap, AdminLTE, and DataTables scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.15/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- Tambahkan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        function refreshPage() {
            location.reload(true);
        }
    </script>
    <script>
        $(document).ready(function () {
            // Tambahkan event click pada tombol pushmenu
            $('.nav-link[data-widget="pushmenu"]').on('click', function () {
                // Toggle class 'sidebar-collapse' pada elemen body
                $('body').toggleClass('sidebar-collapse');
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                dom: 'lBfrtip'
                // buttons: [
                //     'copy', 'excel', 'pdf'
                // ]
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');

            togglePasswordButton.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePasswordButton.textContent = type === 'password' ? 'Show' : 'Hide';
            });

            const updatePasswordInput = document.getElementById('updatePassword');
            const toggleUpdatePasswordButton = document.getElementById('toggleUpdatePassword');

            toggleUpdatePasswordButton.addEventListener('click', function () {
                const type = updatePasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                updatePasswordInput.setAttribute('type', type);
                toggleUpdatePasswordButton.textContent = type === 'password' ? 'Show' : 'Hide';
            });
        });
    </script>

    <!-- Gantilah bagian ini di akhir halaman Anda -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('#updateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userid = button.data('userid');
            var username = button.data('username');
            var fullname = button.data('fullname');
            var userrole = button.data('userrole');

            var modal = $(this);
            modal.find('#updateFullname').val(fullname);
            modal.find('#updateUsername').val(username);
            modal.find('#updateUserRole').val(userrole);
            modal.find('#updateUserID').val(userid);
        });

        function confirmDelete(userid) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this user!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // Redirect ke skrip delete_user_process.php dengan menyertakan parameter userid
                    window.location.href = 'delete_user_process.php?userid=' + userid;
                } else {
                    swal("User is safe!");
                }
            });
        }

        function loadUserDetails(userid) {
            // Use Ajax to fetch user details from the server
            $.ajax({
                url: 'get_user_details.php', // Update with the correct endpoint
                type: 'POST',
                data: { userid: userid },
                success: function (response) {
                    // Display the user details in the details modal
                    document.getElementById('detailsModalBody').innerHTML = response;
                },
                error: function () {
                    // Handle errors if any
                    alert('Error fetching user details.');
                }
            });
        }
    </script>


</body>
</html>