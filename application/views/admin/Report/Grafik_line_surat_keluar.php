<div class="right_col" role="main">
    <div class="row">
        <form action="<?php echo base_url('report/grafik_line_surat_keluar') ?>" method="post">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tahun</label>
                    <select name="tahun" class="form-control">
                        <option value="">Please Select</option>
                        <?php
                        $thn_skr = date('Y');
                        for ($x = $thn_skr; $x >= 2010; $x--) {
                        ?>
                            <option value="<?php echo $x ?>" <?= set_value("tahun") == $x ? "selected" : "" ?>><?php echo $x ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>


            </div>
            <div class="col-md-3">
                <div class="form-group"><button name="cari" class="btn btn-success" style="margin-top:22px;">Cari</button></div>
            </div>
        </form>
        <div class="col-md-10">
            <canvas id="speedChart" width="600" height="400"></canvas>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript">
    let surat = <?= @$surat ?>;

    var speedCanvas = document.getElementById("speedChart");

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;

    var speedData = {
        labels: surat.map(surat => "Bulan " + surat.month),
        datasets: [{
            label: "Surat Keluar",
            data: surat.map(surat => surat.jumlah),
            lineTension: 0,
            fill: false,
            borderColor: 'orange',
            backgroundColor: 'transparent',
            borderDash: [5, 5],
            pointBorderColor: 'orange',
            pointBackgroundColor: 'rgba(255,150,0,0.5)',
            pointRadius: 5,
            pointHoverRadius: 10,
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rectRounded'
        }]
    };

    var chartOptions = {
        legend: {
            display: true,
            position: 'top',
            labels: {
                boxWidth: 80,
                fontColor: 'black'
            }
        }
    };

    var lineChart = new Chart(speedCanvas, {
        type: 'line',
        data: speedData,
        options: chartOptions
    });
</script>