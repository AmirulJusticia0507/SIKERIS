<?php
// sidebar.php

// sidebar.php
function isPageActive($pageName) {
    if (isset($_GET['page']) && $_GET['page'] == $pageName) {
        return 'active';
    }
    return '';
}

function isUserNotaris() {
    // Gantilah dengan logika sesuai dengan struktur data user Anda
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Notaris';
}

?>

<style>
    /* CSS untuk spinner */
.page-spinner {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Warna latar belakang dengan transparan */
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    border: 4px solid rgba(0, 0, 0, 0.3);
    border-radius: 50%;
    border-top: 4px solid #007bff; /* Warna utama */
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Tambahkan konten sidebar AdminLTE di sini -->
    <a href="index.php" class="brand-link">
        <span class="brand-text font-weight-light">SIKERIS BPRS <img src="img/logo_white.png" alt="" style="width:80px;"></span>
    </a>
    <div class="sidebar">
        <ul class="nav nav-pills nav-sidebar flex-column nowrap" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="index.php?page=dashboard" class="nav-link <?php echo isPageActive('dashboard'); ?>">
                    <i class="fa fa-tachometer-alt nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <?php if (!isUserNotaris()) { ?>
            <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link <?php echo isPageActive('transaction'); ?>">
                    <i class="fa fa-cogs nav-icon"></i>
                    <p>Settings</p>
                    <i class="fas fa-caret-down float-right"></i>
                </a>
                <ul class="nav nav-treeview">
                    
                        <li class="nav-item">
                            <a href="settingbank.php?page=settingbank" class="nav-link <?php echo isPageActive('settingbank'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setting Bank</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="settingnotaris.php?page=settingnotaris" class="nav-link <?php echo isPageActive('settingnotaris'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setting Notaris</p>
                            </a>
                        </li>
                    
                </ul>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a href="progesspengikatan.php?page=progesspengikatan" class="nav-link <?php echo isPageActive('progesspengikatan'); ?>">
                    <i class="fa fa-link nav-icon"></i>
                    <p>Progress Pengikatan</p>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="chat_dialog.php?page=chat_dialog" class="nav-link <?php echo isPageActive('chat_dialog'); ?>">
                    <i class="fa fa-comments nav-icon"></i>
                    <p>Chat Dialog</p>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="usermanagements.php?page=usermanagements" class="nav-link <?php echo isPageActive('usermanagements'); ?>">
                    <i class="fa fa-users nav-icon"></i>
                    <p>User Management</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link logout-link">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <p>Logout</p>
                </a>
            </li>

        </ul>
    </div>
</aside>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Skrip JavaScript untuk mengontrol pushmenu -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const body = document.querySelector("body");
        const pageSpinner = document.getElementById("page-spinner");

        // Function to toggle the sidebar
        const toggleSidebar = () => {
            body.classList.toggle("sidebar-collapse");
            body.classList.toggle("sidebar-open");
        };

        // Add event listener to the sidebar button
        const sidebarButton = document.querySelector(".nav-link[data-widget='pushmenu']");
        sidebarButton.addEventListener("click", function (e) {
            e.preventDefault();
            toggleSidebar();
        });

        // Add event listener to the caret-down icons for submenu
        const submenuToggles = document.querySelectorAll(".nav-item.has-treeview > .nav-link > .fas.fa-caret-down");
        submenuToggles.forEach((toggle) => {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = toggle.parentElement.parentElement;
                parent.classList.toggle("menu-open");
            });
        });

        // Fungsi untuk menampilkan spinner
        function showSpinner() {
            pageSpinner.style.display = "flex";
        }

        // Fungsi untuk menyembunyikan spinner
        function hideSpinner() {
            pageSpinner.style.display = "none";
        }

        // Tambahkan event listener ke setiap tautan navigasi yang akan menampilkan spinner
        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach(function (link) {
            link.addEventListener("click", function () {
                showSpinner();
            });
        });

        // Sembunyikan spinner saat halaman baru dimuat
        window.addEventListener("load", function () {
            hideSpinner();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk menampilkan SweetAlert konfirmasi logout
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman logout.php jika pengguna menekan "Ya"
                window.location.href = "logout.php";
            }
        });
    }

    // Tambahkan event listener ke tautan "Logout"
    const logoutLink = document.querySelector(".logout-link");
    logoutLink.addEventListener("click", function (e) {
        e.preventDefault();
        confirmLogout();
    });
});
</script>