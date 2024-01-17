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
    <title>Chat Surat Masuk - Keluar SIKERIS (Sistem Kerjasama BPRS dengan Notaris) - BPRS HIK MCI Yogyakarta</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Tambahkan link AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
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
    <style>
        div.dataTables_wrapper {
            width: auto;
            margin: 0 auto;
        }

        /* Atur gaya tabel */
        table.table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Atur batas sel di tabel */
        table.table th,
        table.table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* Atur latar belakang header tabel */
        table.table th {
            background-color: #f2f2f2;
        }

        /* Beri warna latar belakang pada baris ganjil */
        table.table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Hindari pemotongan teks dalam sel */
        table.table th,
        table.table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
            /* Sesuaikan dengan kebutuhan Anda */
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
                        <li class="breadcrumb-item active" aria-current="page">Chat Surat Masuk - Keluar</li>
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
                            <h2><i class="fa fa-envelope"></i> Messages</h2><br>
                            <fieldset>
                                <!-- Chat Dialog Form -->
                                <form action="process_chat.php" method="POST">
                                    <div class="mb-3">
                                        <label for="from" class="form-label">Sender</label>
                                        <!-- <input type="text" class="form-control" id="from" name="from"> -->
                                        <?php
                                        // Memeriksa apakah sesi sudah dimulai
                                        if (session_status() == PHP_SESSION_NONE) {
                                            session_start(); // Mulai sesi jika belum ada
                                        }

                                        // Mengambil nilai fullname dari sesi jika sudah login
                                        $fromValue = isset($_SESSION['userid']) ? $_SESSION['fullname'] : '';

                                        // Menampilkan input field dan mengatur nilai default dan atribut readonly
                                        echo '<input type="text" class="form-control" id="from" name="from" value="' . $fromValue . '" readonly>';
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="to" class="form-label">Receiver</label>
                                        <input type="text" class="form-control" id="to" name="to">
                                    </div>
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject">
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send</button>
                                </form>
                            </fieldset>
                        </div>
                    </div><br>

                    <div class="card">
                        <div class="card-body" id="resultsContent">
                            <button class="btn btn-primary" onclick="refreshPage()"><i class="fa fa-sync"></i> Refresh</button><br><br>
                            <!-- Tabel untuk Menampilkan Chat Messages -->
                            <table class="display table table-bordered table-striped table-hover nowrap" style="width:100%" id="chatTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>PDF File</th>
                                        <th>Image File</th>
                                        <th>Sent At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $server = "localhost";
                                    $server = "192.168.1.184";
                                    $username = "root";
                                    $password = "";
                                    $database = "db_mobile_collection";

                                    $connectionServernew = new mysqli($server, $username, $password, $database);

                                    if ($connectionServernew->connect_error) {
                                        $hasil['STATUS'] = "000199";
                                        die(json_encode($hasil));
                                    }

                                    $query = "SELECT * FROM db_mobile_collection.chat_messages";
                                    $result = $connectionServernew->query($query);

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['id']}</td>";
                                        echo "<td>{$row['sender']}</td>";
                                        echo "<td>{$row['receiver']}</td>";
                                        echo "<td>{$row['subject']}</td>";
                                        echo "<td>{$row['message']}</td>";
                                        // echo "<td><a href='uploads/pdf/{$row['file_pdf']}' download>{$row['file_pdf']}</a></td>";
                                        // echo "<td><a href='uploads/images/{$row['file_image']}' download>{$row['file_image']}</a></td>";
                                        // Link untuk mendownload file PDF
                                        echo "<td>";
                                        if (!empty($row['file_pdf'])) {
                                            echo "<a href='download.php?file={$row['file_pdf']}' download>{$row['file_pdf']}</a>";
                                        } else {
                                            echo "No PDF available";
                                        }
                                        echo "</td>";

                                        // Link untuk mendownload file gambar
                                        echo "<td>";
                                        if (!empty($row['file_image'])) {
                                            echo "<a href='download.php?file={$row['file_image']}' download>{$row['file_image']}</a>";
                                        } else {
                                            echo "No image available";
                                        }
                                        echo "</td>";
                                        echo "<td>{$row['sent_at']}</td>";
                                        echo "<td>";
                                        echo "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#uploadModal{$row['id']}'>Upload</button>";
                                        echo "<button type='button' class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
                                        echo "</td>";
                                        echo "</tr>";

                                        // Modal untuk setiap baris
                                        echo "<div class='modal fade' id='uploadModal{$row['id']}' tabindex='-1' aria-labelledby='uploadModalLabel{$row['id']}' aria-hidden='true'>";
                                            echo "<div class='modal-dialog'>";
                                                echo "<div class='modal-content'>";
                                                    echo "<div class='modal-header'>";
                                                        echo "<h5 class='modal-title' id='uploadModalLabel{$row['id']}'>Upload Files</h5>";
                                                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                                    echo "</div>";
                                                    echo "<div class='modal-body'>";
                                                    // Form untuk mengunggah file PDF dan gambar
                                                        echo "<form action='process_upload.php' method='POST' enctype='multipart/form-data'>";
                                                            echo "<input type='hidden' name='message_id' value='{$row['id']}'>";
                                                            echo "<div class='mb-3'>";
                                                                echo "<label for='pdfFile' class='form-label'>PDF File</label>";
                                                                echo "<input type='file' class='form-control' id='pdfFile' name='pdfFile' accept='.pdf'>";
                                                            echo "</div>";
                                                            echo "<div class='mb-3'>";
                                                                echo "<label for='imageFile' class='form-label'>Image File</label>";
                                                                echo "<input type='file' class='form-control' id='imageFile' name='imageFile' accept='.png, .jpg, .jpeg'>";
                                                            echo "</div>";
                                                            echo "<button type='submit' class='btn btn-primary'>Upload</button>";
                                                        echo "</form>";
                                                    echo "</div>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div><br>

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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <!-- Tambahkan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function () {
            $('#chatTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                dom: 'lBfrtip'
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
        function refreshPage() {
            location.reload(true);
        }
    </script>
    <script>
        $(document).ready(function () {
            // Inisialisasi Select2 pada input "Receiver"
            $("#to").select2({
                ajax: {
                    url: "get_notaris_data.php",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                placeholder: 'Masukkan Nama Penerima',
                allowClear: true
            });
        });

        function confirmDelete(messageId) {
            var confirmDelete = confirm("Are you sure you want to delete this chat?");
            if (confirmDelete) {
                // Redirect to delete script or call AJAX to delete the chat
                window.location.href = 'delete_chat.php?message_id=' + messageId;
            }
        }
    </script>

    </body>
</html>