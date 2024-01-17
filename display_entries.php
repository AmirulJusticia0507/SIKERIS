<?php
// Display entries in a table format
$query = "SELECT e.id, e.notarisId, e.namaNasabah, e.noSertifikat, e.pemilikSertifikat, e.entryId, e.scanSertifikatPath, e.created_at, n.namalengkapnotaris
FROM db_mobile_collection.entry_pengikatan_berkas e
LEFT JOIN db_mobile_collection.notaris n ON e.notarisId = n.notaris_id 
WHERE 1;";
$result = $connectionServernew->query($query);
$nomorUrutTerakhir = 1;

echo "<table border='1'>";
echo "<tr><th>No</th><th>Nama Nasabah</th><th>No Sertifikat</th><th>Pemilik Sertifikat</th><th>Scan Sertifikat</th><th>Action</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $nomorUrutTerakhir . "</td>";
    echo "<td>{$row['namaNasabah']}</td>";
    echo "<td>{$row['noSertifikat']}</td>";
    echo "<td>{$row['pemilikSertifikat']}</td>";
    echo "<td>{$row['namalengkapnotaris']}</td>";
    echo "<td><a href='download.php?file={$row['scanSertifikatPath']}' download>{$row['scanSertifikatPath']}</a></td>";
    echo "<td>";
    echo "<button class='btn btn-danger' onclick='confirmDelete({$row['id']})'>Delete</button>";
    echo "</td>";
    $nomorUrutTerakhir++;
    echo "</tr>";
}

echo "</table>";
?>
