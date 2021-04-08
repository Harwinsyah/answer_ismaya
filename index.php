<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $conn = new mysqli("localhost", "root", "", "ismaya_db");

        if(isset($_POST['proses'])){
            $sql = $conn->query("SELECT * FROM transaksi" );
            $sql2 = $conn->query("SELECT * FROM laporan ORDER BY id DESC LIMIT 1" );
            $row = mysqli_fetch_row($sql2);
            $tanggal = $row[3];
            $satuan = $row[1] / $row[2];
        
            while($data = $sql->fetch_assoc()):        
                $nama_pelanggan = $data['nama_pelanggan'];
                $qty = $data['qty'];
                $total_belanja = $qty * $satuan;
                $test = $conn->query("INSERT INTO history VALUES('', '$nama_pelanggan', '$tanggal', '$total_belanja')");
            endwhile;            
        }
    ?>

    <h1>Form Input</h1>
    <form action="index.php" method="post">
        <input type="submit" value="Proses Semua Histori" name="proses">
    </form>

    <h1>History</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th>Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                $query = $conn->query("SELECT * FROM history");
                $count = mysqli_num_rows($query);     

                if($count == 0){
                    echo "<tr><td colspan='4'>Belum ada data.</td></tr>";
                } else {
                    while($data = $query->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data["nama_pelanggan"] ?></td>
                            <td><?= $data["tanggal"] ?></td>
                            <td><?= $data["total_belanja"] ?></td>
                        </tr>
                        <?php
                        endwhile;
                }
            ?>
        </tbody>
    </table>
</body>
</html>