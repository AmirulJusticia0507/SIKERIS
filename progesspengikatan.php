<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna telah terautentikasi
if (!isset($_SESSION['userid'])) {
    // Jika tidak ada sesi pengguna, alihkan ke halaman login
    header('Location: login.php');
    exit;
}

// Ambil informasi peran pengguna dari sesi
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';

// Ganti judul berdasarkan peran pengguna
$pageTitle = '';
if ($userRole == "Superadmin") {
    $pageTitle = "Progress Pengikatan";
} elseif ($userRole == "Notaris") {
    $pageTitle = "Cek Intip";
} else {
    // Jika peran tidak dikenali, atur ke nilai default atau sesuai kebutuhan
    $pageTitle = "Default Title";
}

// Ambil informasi user ID
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';

// Tentukan apakah tab Entry harus ditampilkan berdasarkan peran pengguna
$displayEntryTab = ($userRole == "Superadmin" || in_array($userId, array(1, 2, 3, 4, 5, 6, 7)));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Pengikatan SIKERIS (Sistem Kerjasama BPRS dengan Notaris) - BPRS HIK MCI Yogyakarta</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Tambahkan link AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
    <style>
        .clickable {
            cursor: pointer;
        }

        .accordion-body {
            display: none;
        }
        .file-input-group {
            display: none;
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
                        <li class="breadcrumb-item active" aria-current="page">Progress Pengikatan</li>
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
                    <h2><i class="fa fa-spinner"></i> <?php echo $pageTitle; ?></h2><br>
                    <?php include 'step.php'; ?>
                    <div class="card">
                        <div class="card-body" id="resultsContent">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="step1Tabs">
                                        <!-- <li class="nav-item">
                                            <a class="nav-link active" id="entryTab" data-bs-toggle="tab" href="#entryContent">Entri</a>
                                        </li> -->
                                        <?php if ($displayEntryTab): ?>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="entryTab" data-bs-toggle="tab" href="#entryContent">Entri Data</a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="documentsTab" data-bs-toggle="tab" href="#documentsContent">Documents</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-2">
                                        <!-- Entri Tab -->
                                        <?php if ($displayEntryTab): ?>
                                        <div class="tab-pane fade show active" id="entryContent">
                                            <!-- Form Entri -->
                                            <form action="process_entry.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" id="entryId" name="entryId">
                                                <div class="mb-3">
                                                    <label for="namaNasabah" class="form-label">Nama Calon Debitur:</label>
                                                    <input type="text" class="form-control" id="namaNasabah" name="namaNasabah" placeholder="Masukkan nama calon Debitur">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="no_Sertifikat" class="form-label">No Sertifikat:</label>
                                                    <input type="text" class="form-control" id="no_Sertifikat" name="no_Sertifikat" placeholder="Masukkan no Sertifikat">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pemilikSertifikat" class="form-label">Pemilik Sertifikat:</label>
                                                    <input type="text" class="form-control" id="pemilikSertifikat" name="pemilikSertifikat" placeholder="Pemilik Sertifikat">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="notaris" class="form-label">Nama Notaris</label>
                                                    <input type="text" class="form-control" id="namaNotaris" name="namaNotaris" placeholder="nama notaris yg dicari" autocomplete="off">
                                                    <input type="hidden" id="notarisId" name="notarisId">
                                                    <div id="namaNotarisSuggestions" class="autocomplete-suggestions"></div>
                                                </div>
                                                <br>
                                                <div class="row justify-content-center" align="center">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Submit</button>&emsp;
                                                    <button type="reset" class="btn btn-danger"><i class="fa fa-power-off"></i> Reset</button>
                                                </div>
                                            </form>
                                        </div>
                                        <?php endif; ?>

                                        <!-- Documents Tab -->
                                        <div class="tab-pane fade" id="documentsContent">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEntryModal" data-entry-id="<?= isset($entryId) ? $entryId : '' ?>"><i class="fa fa-plus"></i> Tambah</button><br><br>

                                            <table class="display table table-bordered table-striped table-hover nowrap" style="width:100%" id="documentsTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Entri</th>
                                                        <th>Nama Nasabah</th>
                                                        <th>No Sertifikat</th>
                                                        <th>Pemilik Sertifikat</th>
                                                        <th>Nama Notaris</th>
                                                        <th>Scan Sertifikat (Pdf)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $server = "192.168.1.184";
                                                    $username = "root";
                                                    $password = "";
                                                    $database = "db_mobile_collection";

                                                    $connectionServernew = new mysqli($server, $username, $password, $database);

                                                    if ($connectionServernew->connect_error) {
                                                        $hasil['STATUS'] = "000199";
                                                        die(json_encode($hasil));
                                                    }

                                                    $userRole = "Notaris";
                                                    // Ambil informasi ID Notaris dari sesi
                                                    $notarisId = isset($_SESSION['notaris_id']) ? $_SESSION['notaris_id'] : '';

                                                    $query = "SELECT 
                                                    e.id, 
                                                    e.notarisId,
                                                    n.notaris_id, 
                                                    e.namaNasabah, 
                                                    e.noSertifikat, 
                                                    e.pemilikSertifikat, 
                                                    e.entryId, 
                                                    e.scanSertifikatPath, 
                                                    e.created_at, 
                                                    n.namalengkapnotaris
                                                    FROM db_mobile_collection.entry_pengikatan_berkas e
                                                    LEFT JOIN db_mobile_collection.notaris n ON e.notarisId = n.notaris_id 
                                                    WHERE e.notarisId = '$notarisId';";
                                                    $result = $connectionServernew->query($query);
                                                    $nomorUrutTerakhir = 1;

                                                    while ($row = $result->fetch_assoc()) {
                                                        // Check if 'scanSertifikatPath' is not empty
                                                        if (!empty($row['scanSertifikatPath'])) {
                                                            // Explode the string into an array using a delimiter (assuming it's a comma)
                                                            $filePaths = explode(',', $row['scanSertifikatPath']);
                                                            $rowCount = count($filePaths);

                                                            // Display row information for each file upload
                                                            for ($i = 0; $i < $rowCount; $i++) {
                                                                echo "<tr>";
                                                                // Output the first column only for the first file
                                                                if ($i === 0) {
                                                                    echo "<td>{$nomorUrutTerakhir}</td>";
                                                                    echo "<td>{$row['entryId']}</td>";
                                                                    echo "<td>{$row['namaNasabah']}</td>";
                                                                    echo "<td>{$row['noSertifikat']}</td>";
                                                                    echo "<td>{$row['pemilikSertifikat']}</td>";
                                                                    echo "<td>{$row['namalengkapnotaris']}</td>"; // Displaying the notaris name
                                                                    echo "<td><a href='download.php?file={$filePaths[$i]}' download>{$filePaths[$i]}</a></td>";
                                                                    echo "<td>";
                                                                    echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                                                    // Tambahkan pengecekan peran pengguna sebelum menampilkan tombol Delete
                                                                    // if ($userRole == "Superadmin") {
                                                                    //     echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                                                    // } else {
                                                                    //     echo "Not allowed";
                                                                    // }
                                                                    echo "</td>";
                                                                    echo "</tr>";
                                                                } else {
                                                                    // For subsequent files, leave the first column empty
                                                                    echo "<tr><td></td>";
                                                                    // Display other columns without duplicating data
                                                                    echo "<td>{$row['entryId']}</td>";
                                                                    echo "<td>{$row['namaNasabah']}</td>";
                                                                    echo "<td>{$row['noSertifikat']}</td>";
                                                                    echo "<td>{$row['pemilikSertifikat']}</td>";
                                                                    echo "<td>{$row['namalengkapnotaris']}</td>";
                                                                    echo "<td><a href='download.php?file={$filePaths[$i]}' download>{$filePaths[$i]}</a></td>";
                                                                    echo "<td>";
                                                                    echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                                                    // Tambahkan pengecekan peran pengguna sebelum menampilkan tombol Delete
                                                                    // if ($userRole == "Superadmin") {
                                                                    //     echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                                                    // } else {
                                                                    //     echo "Not allowed";
                                                                    // }
                                                                    echo "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            }
                                                        } else {
                                                            // Handle the case where 'scanSertifikatPath' is empty
                                                            echo "<tr>";
                                                            echo "<td>{$nomorUrutTerakhir}</td>";
                                                            echo "<td>{$row['entryId']}</td>";
                                                            echo "<td>{$row['namaNasabah']}</td>";
                                                            echo "<td>{$row['noSertifikat']}</td>";
                                                            echo "<td>{$row['pemilikSertifikat']}</td>";
                                                            echo "<td>{$row['namalengkapnotaris']}</td>"; // Displaying the notaris name
                                                            echo "<td>No file uploads available</td>";
                                                            echo "<td>";
                                                            echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                                            // Tambahkan pengecekan peran pengguna sebelum menampilkan tombol Delete
                                                            // if ($userRole == "Superadmin") {
                                                            //     echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                                            // } else {
                                                            //     echo "Not allowed";
                                                            // }
                                                            echo "</td>";
                                                            echo "</tr>";
                                                        }

                                                        $nomorUrutTerakhir++;
                                                    }
                                                ?>
                                                </tbody>
                                            </table>

                                            <!-- Modal for Tambah Entry -->
                                            <div class="modal fade" id="addEntryModal" tabindex="-1" aria-labelledby="addEntryModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content text-center">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addEntryModalLabel">
                                                                Tambah Entry
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Tambah Entry -->
                                                            <form id="addEntryForm" action="process_additional_entry.php" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" id="entryId" name="entryId" value="">
                                                                <div class="mb-3">
                                                                    <label for="scanSertifikatModal" class="form-label">Upload tambahan document pendukung (PDF)</label>
                                                                    <input type="file" class="form-control" id="scanSertifikatModal" name="scanSertifikatModal[]" accept=".pdf" multiple>
                                                                </div>
                                                                <div id="additionalUploads"></div>
                                                                <button type="button" class="btn btn-success" onclick="addMoreUploads()"><i class="fa fa-plus"></i></button>
                                                                <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Save</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $('#documentsTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip'
            });
        });
    </script>
    <script>
        function refreshPage() {
            location.reload(true);
        }
    </script>
    <script>
        $(document).ready(function () {
            $("#namaNotaris").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "autocomplete.php",
                        method: "GET",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    // Mengisi nilai notarisId saat notaris dipilih
                    $("#notarisId").val(ui.item.id);
                }
            });
        });
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
        // Tambahkan kelas 'complete' pada step yang telah selesai
        $('.step:lt(1)').addClass('complete');

        function addEntry() {
            // Mengambil nilai dari formulir modal
            var entryId = $("#entryId").val() || ''; // Sesuaikan dengan cara Anda mengidentifikasi entri yang sesuai
            var scanSertifikat = $("#scanSertifikatModal")[0].files[0];
            // Menambahkan entryId ke form data
            var formData = new FormData($("#addEntryForm")[0]);
            formData.append('entryId', entryId);

            // Proses penyimpanan data tambahan ke server (Anda perlu menyesuaikan dengan metode penyimpanan yang Anda gunakan)
            $.ajax({
                url: 'process_additional_entry.php',
                method: 'POST',
                data: new FormData($("#addEntryForm")[0]),
                processData: false,
                contentType: false,
                success: function (response) {
                    // Parsing respons sebagai objek JSON
                    var responseData = JSON.parse(response);

                    // Setelah data tambahan disimpan, tambahkan baris baru ke tabel
                    var newRow =
                        "<tr>" +
                        "<td>" + responseData.nomor + "</td>" +
                        "<td>" + responseData.namaNasabah + "</td>" +
                        "<td>" + responseData.noSertifikat + "</td>" +
                        "<td>" + responseData.pemilikSertifikat + "</td>" +
                        "<td>" + scanSertifikat.name + "</td>" +
                        "<td>Action buttons here</td>" +
                        "</tr>";

                    // Mendapatkan jumlah baris kosong yang akan ditambahkan
                    var numEmptyRows = 4; // Ganti sesuai kebutuhan

                    // Menambahkan baris kosong
                    for (var i = 0; i < numEmptyRows; i++) {
                        newRow += "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                    }

                    // Memasukkan baris ke dalam tabel
                    $("#documentsTable tbody").append(newRow);

                    // Tutup modal setelah penyimpanan
                    $("#addEntryModal").modal("hide");
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Gagal menyimpan data tambahan.');
                }
            });
        }

        $('#addEntryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var entryId = button.data('entry-id');
            
            // Set the entryId in the modal form
            $('#entryId').val(entryId || '');
        });

        function addMoreUploads() {
            var additionalUploadsContainer = document.getElementById('additionalUploads');

            var newUploadDiv = document.createElement('div');
            newUploadDiv.className = 'mb-3';

            var newFileInput = document.createElement('input');
            newFileInput.type = 'file';
            newFileInput.className = 'form-control';
            newFileInput.name = 'scanSertifikatModal[]';
            newFileInput.accept = '.pdf';
            newUploadDiv.appendChild(newFileInput);

            additionalUploadsContainer.appendChild(newUploadDiv);
        }

        function confirmDelete(entryId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proses penghapusan data dengan menggunakan AJAX
                    $.ajax({
                        url: 'hapus_entry.php', // Ganti dengan URL yang sesuai
                        method: 'POST',
                        data: { entryId: entryId },
                        success: function (response) {
                            // Hapus baris dari tabel jika penghapusan berhasil
                            $('#documentsTable').on('click', '.btn-danger', function () {
                                $(this).closest('tr').remove();
                            });

                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                            
                            // Redirect ke halaman progesspengikatan.php setelah 2 detik
                            setTimeout(function () {
                                window.location.href = 'progesspengikatan.php?page=progesspengikatan';
                            }, 2000);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        }

        // Fungsi untuk menambahkan kelas "complete" pada lingkaran langkah
        function markStepAsComplete(stepNumber) {
            var step = document.querySelector(".step:nth-child(" + stepNumber + ")");
            step.classList.add("complete");
        }

        // Panggil fungsi untuk menandai langkah 1 sebagai selesai
        window.onload = function () {
            markStepAsComplete(1);
        };
    </script>
</body>
</html>