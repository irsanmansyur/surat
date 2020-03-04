<div class="right_col h-100" role="main">
    <h2>Report Surat Masuk</h2>
    <div class="row">
        <div class="x_panel">
            <form action="<?= base_url("report/surat_masuk") ?>" method="post">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <select name="jenis" class="form-control">
                            <?php
                            $this->db->group_by("jenis_surat");
                            $jenis = $this->db->get("mst_surat")->result();

                            foreach ($jenis as $tampil) {
                                # code...
                            ?>
                                <option value="<?= $tampil->id_surat ?>" <?= set_value('jenis') == $tampil->id_surat ? "selected" : "" ?>><?= $tampil->jenis_surat ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Periode Awal</label>
                        <input type="date" name="periode_awal" value="<?= set_value('periode_awal'); ?>" class="form-control">
                    </div>
                    <?= form_error('periode_awal', '<small class="text-danger">', '</small>'); ?>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label>Periode Akhir</label>
                        <input type="date" name="periode_akhir" class="form-control" value="<?= set_value('periode_akhir'); ?>">
                    </div>
                    <?= form_error('periode_akhir', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-success" style="margin-top:23px;" name="cari">Show</button>
                    </div>
                </div>
            </form>
            <form action="<?= base_url("report/surat_masuk") ?>" method="post">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">--Pilih Bulan--</option>
                            <option value="01" <?= set_value('bulan') == "01" ? "selected" : "" ?>>Januari</option>
                            <option value="02" <?= set_value('bulan') == "02" ? "selected" : "" ?>>Febuari</option>
                            <option value="03" <?= set_value('bulan') == "03" ? "selected" : "" ?>>Maret</option>
                            <option value="04" <?= set_value('bulan') == "04" ? "selected" : "" ?>>April</option>
                            <option value="05" <?= set_value('bulan') == "05" ? "selected" : "" ?>>Mei</option>
                            <option value="06" <?= set_value('bulan') == "06" ? "selected" : "" ?>>Juni</option>
                            <option value="07" <?= set_value('bulan') == "07" ? "selected" : "" ?>>Juli</option>
                            <option value="08" <?= set_value('bulan') == "08" ? "selected" : "" ?>>Agustus</option>
                            <option value="09" <?= set_value('bulan') == "09" ? "selected" : "" ?>>September</option>
                            <option value="10" <?= set_value('bulan') == "10" ? "selected" : "" ?>>OKtober</option>
                            <option value="11" <?= set_value('bulan') == "11" ? "selected" : "" ?>>November</option>
                            <option value="12" <?= set_value('bulan') == "12" ? "selected" : "" ?>>Desember</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <select name="jenis" class="form-control">
                            <?php
                            $this->db->group_by("jenis_surat");
                            $jenis = $this->db->get("mst_surat")->result();

                            foreach ($jenis as $tampil) {
                                # code...
                            ?>
                                <option value="<?= $tampil->id_surat ?>" <?= set_value('jenis') == $tampil->id_surat ? "selected" : "" ?>><?= $tampil->jenis_surat ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-success" style="margin-top:23px;" name="cari_bulan">Show</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div style="width: 1050px;height: 500px;">
        <canvas id="myChart"></canvas>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script>
    let surat = <?= @$surat ?>;
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: surat.map(surat => surat.tgl_berkas),
            datasets: [{
                label: "Jumlah Surat",
                data: surat.map(surat => surat.jumlah),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>