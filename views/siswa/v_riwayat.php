<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="text-white">Riwayat Selesai</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Lokasi</th>
                            <th>Masalah</th>
                            <th>Feedback Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($r = mysqli_fetch_assoc($laporan_selesai)): ?>
                        <tr>
                            <td><?= $r['tgl_laporan']; ?></td>
                            <td><?= $r['lokasi']; ?></td>
                            <td><?= $r['ket']; ?></td>
                            <td>
                                <div class="alert alert-success p-2 m-0">
                                    <?= $r['feedback']; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>