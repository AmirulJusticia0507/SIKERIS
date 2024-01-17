<style>
    .progressbar {
        counter-reset: step;
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: space-between;
    }

    .progressbar li {
        flex: 1;
        position: relative;
        text-align: center;
        cursor: pointer;
    }

    .progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border: 1px solid #ddd;
        border-radius: 100%;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        background-color: #fff;
    }

    .progressbar li:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 1px;
        background-color: #ddd;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: green;
    }

    .progressbar li.active:before {
        border-color: green;
    }

    .progressbar li.active + li:after {
        background-color: green;
    }

    .progress-line {
        height: 4px;
        background-color: #3498db;
        width: 0;
        transition: width 0.7s ease;
    }
</style>

<div class="card">
    <div class="card-body" id="resultsContent">
        <div class="progress-line" id="progressLine1"></div>
        <ul class="progressbar">
            <li class="active" onclick="handleClickStep(1); window.location.href='progesspengikatan.php?page=progesspengikatan';"> Entri Data</li>
            <li onclick="handleClickStep(2); window.location.href='hasilpengecekan.php';"> Hasil Pengecekan</li>
            <li onclick="handleClickStep(3); window.location.href='uploadSP3.php';"> Upload SP3</li>
        </ul>
    </div>
</div><br>

<script>
    // Fungsi untuk memperbarui garis sesuai langkah yang telah selesai
    function updateProgressLine(completedSteps, progressLineId) {
        var progressLine = document.getElementById(progressLineId);

        // Hitung persentase berdasarkan jumlah langkah yang telah selesai
        var totalSteps = 3; // Total langkah
        var percentage = (completedSteps / totalSteps) * 100;

        // Nonaktifkan efek transisi
        progressLine.style.transition = "none";

        // Atur lebar garis tanpa efek transisi
        progressLine.style.width = percentage + "%";

        // Tandai langkah yang aktif sesuai dengan yang diklik
        var progressBarItems = document.querySelectorAll('.progressbar li');
        progressBarItems.forEach(function (item, index) {
            if (index + 1 <= completedSteps) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Setelah perubahan, aktifkan kembali efek transisi dengan timeout kecil
        setTimeout(function () {
            progressLine.style.transition = "width 0.7s ease";
        }, 50);
    }

    // Panggil fungsi untuk mengatur garis saat halaman dimuat
    window.onload = function () {
        updateProgressLine(1, "progressLine1"); // Secara default, anggap langkah pertama sudah selesai
    };

    // Fungsi untuk menangani klik pada setiap langkah
    function handleClickStep(step) {
        var progressLine = document.getElementById("progressLine1");

        // Set terlebih dahulu lebar garis tanpa efek transisi
        progressLine.style.transition = "none";
        progressLine.style.width = "0";

        // Setelah itu, panggil fungsi updateProgressLine dengan timeout kecil
        setTimeout(function () {
            updateProgressLine(step, "progressLine1");
        }, 50);
    }
</script>