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
    <title>Setting Bank SIKERIS (Sistem Kerjasama BPRS dengan Notaris) - BPRS HIK MCI Yogyakarta</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Setting Bank</li>
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
                            <h2><i class="fa fa-building"></i> Setting Bank</h2><br><hr>

                            <!-- Modal Bank Details -->
                            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel">Details Bank</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="detailsModalBody">
                                            <!-- Bank details will be displayed here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Add Bank -->
                            <div class="modal fade" id="addBankModal" tabindex="-1" aria-labelledby="addBankModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBankModalLabel">Add Bank</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk menambahkan data bank -->
                                            <form action="add_bank_process.php" method="post">
                                                <!-- Tambahkan elemen formulir sesuai dengan kolom-kolom bank -->
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="kode_bank" class="form-label">Kode Bank:</label>
                                                        <input type="text" class="form-control" id="kode_bank" name="kode_bank" style="width:100%;">
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label for="nama_bank" class="form-label">Nama Bank:</label>
                                                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat:</label>
                                                    <textarea id="alamat" name="alamat" class="form-control" cols="3" rows="1"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="telepon" class="form-label">Telepon:</label>
                                                    <input type="tel" class="form-control" id="telepon" name="telepon" style="width:100%;" maxlength="14">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="website" class="form-label">Website:</label>
                                                    <input type="text" class="form-control" id="website" name="website" style="width:100%;">
                                                </div>
                                                <!-- <div class="mb-3">
                                                    <label for="tanggal_berdiri" class="form-label">Tanggal Berdiri:</label>
                                                    <input type="date" class="form-control" id="tanggal_berdiri" name="tanggal_berdiri" style="width:50%;">
                                                </div> -->
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="jenis_bank" class="form-label">Jenis Bank:</label>
                                                        <input type="text" class="form-control" id="jenis_bank" name="jenis_bank" style="width:100%;">
                                                    </div>
                                                </div>
                                                <br>
                                                <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                                                <div class="row justify-content-center" align="center">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Submit</button>&emsp;
                                                    <button type="reset" class="btn btn-danger"><i class="fa fa-power-off"></i> Reset</button>
                                                </div>
                                            </form><br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button type="button" class="myButton" data-bs-toggle="modal" data-bs-target="#addBankModal"><i class="fa fa-plus"></i> Add Bank</button>&emsp;
                                <button class="myButton" onclick="refreshPage()"><i class="fa fa-sync"></i> Refresh</button>
                            </div><br>

                            <table id="bankTable" class="display table table-bordered table-striped table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bank</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Website</th>
                                        <!-- <th>Tanggal Berdiri</th> -->
                                        <!-- <th>Kode Bank</th> -->
                                        <th>Jenis Bank</th>
                                        <th>Action</th>
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
                                    // Ambil data bank dari database dan tampilkan dalam tabel
                                    $query = "SELECT 
                                                id,
                                                nama_bank,
                                                alamat,
                                                telepon,
                                                website,
                                                -- tanggal_berdiri,
                                                kode_bank,
                                                jenis_bank
                                            FROM 
                                                db_mobile_collection.bank";
                                    $result = $connectionServernew->query($query);

                                    $nomorUrutTerakhir = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $nomorUrutTerakhir . "</td>";
                                        echo "<td>{$row['kode_bank']} - {$row['nama_bank']}</td>";
                                        echo "<td>{$row['alamat']}</td>";
                                        echo "<td>{$row['telepon']}</td>";
                                        echo "<td>{$row['website']}</td>";
                                        // echo "<td>{$row['tanggal_berdiri']}</td>";
                                        // echo "<td>{$row['kode_bank']}</td>";
                                        echo "<td>{$row['jenis_bank']}</td>";
                                        echo "<td>
                                                <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateBankModal' data-bankid='{$row['id']}' data-namabank='{$row['nama_bank']}' data-alamat='{$row['alamat']}' data-telepon='{$row['telepon']}' data-website='{$row['website']}' data-berdiri='{$row['tanggal_berdiri']}' data-kodebank='{$row['kode_bank']}' data-jenisbank='{$row['jenis_bank']}'><i class='fa fa-pencil'></i> Update</button>
                                                <button type='button' class='btn btn-danger btn-sm' onclick='confirmDelete({$row['id']})'><i class='fa fa-trash'></i> Delete</button>
                                                <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#detailsModal' onclick='loadBankDetails({$row['id']})'><i class='fa fa-eye'></i> Details</button>
                                            </td>";
                                        $nomorUrutTerakhir++;
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Modal Update Bank -->
                            <div class="modal fade" id="updateBankModal" tabindex="-1" aria-labelledby="updateBankModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateBankModalLabel">Update Data Bank</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk mengupdate bank -->
                                            <form action="update_bank_process.php" method="post">
                                                <input type="hidden" name="bankid" id="updateBankID">
                                                <!-- Tambahkan elemen formulir sesuai kebutuhan -->
                                                <div class="mb-3">
                                                    <label for="updateNamaBank" class="form-label">Nama Bank :</label>
                                                    <input type="text" class="form-control" id="updateNamaBank" name="updateNamaBank" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateAlamat" class="form-label">Alamat :</label>
                                                    <textarea class="form-control" id="updateAlamat" name="updateAlamat" cols="3" rows="1"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateTelepon" class="form-label">Telepon :</label>
                                                    <input type="tel" class="form-control" id="updateTelepon" name="updateTelepon" style="width:50%;" maxlength="14">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateWebsite" class="form-label">Website :</label>
                                                    <input type="text" class="form-control" id="updateWebsite" name="updateWebsite" style="width:50%;">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateBerdiri" class="form-label">Tanggal Berdiri :</label>
                                                    <input type="date" class="form-control" id="updateBerdiri" name="updateBerdiri" style="width:50%;">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateKodeBank" class="form-label">Kode Bank :</label>
                                                    <input type="text" class="form-control" id="updateKodeBank" name="updateKodeBank" style="width:50%;">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateJenisBank" class="form-label">Jenis Bank :</label>
                                                    <input type="text" class="form-control" id="updateJenisBank" name="updateJenisBank" style="width:50%;">
                                                </div>
                                                <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                                                <button type="submit" class="myButton"><i class="fa fa-pencil"></i> Update</button>
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
    <!-- Tambahkan library Inputmask.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#bankTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                dom: 'lBfrtip'
            });
        });

        // Terapkan masking pada elemen input telepon
        $(document).ready(function () {
            // Masking untuk form entry
            $('#telepon').inputmask('(999) 999-9999');

            // Masking untuk form update
            $('#updateTelepon').inputmask('(999) 999-9999');
        });

        function loadBankDetails(id) {
            // Use Ajax to fetch bank details from the server
            $.ajax({
                url: 'get_bank_details.php',
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    // Display the bank details in the details modal
                    $('#detailsModalBody').html(response);
                },
                error: function () {
                    // Handle errors if any
                    alert('Error fetching bank details.');
                }
            });
        }

    </script>
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
</body>
</html>