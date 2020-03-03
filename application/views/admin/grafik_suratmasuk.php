  <div class="right_col" role="main">
    <div class="row">
      <form action="<?php echo base_url('admin/surat_masukperiode') ?>" method="post">
      <div class="col-md-3">
        <div class="form-group">
          <label>Jenis Surat</label>
          <select name="jenis" class="form-control">
            <?php foreach ($jenis as $tampil) {
              # code...
             ?>
            <option value="<?=$tampil->id_surat?>"><?=$tampil->jenis_surat?></option>
          <?php }?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Periode Awal</label>
          <input type="date" name="periode_awal" class="form-control">
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label>Periode Akhir</label>
          <input type="date" name="periode_akhir" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
        <button class="btn btn-success" style="margin-top:23px;" name="cari">Show</button>
        </div>
      </div>
      </form>
    </div>

    <div class="row">
      <form action="<?php echo base_url('user/masuk_bulan') ?>" method="post">
      <div class="col-md-3">
        <div class="form-group">
      <label>Bulan</label>
      <select name="bulan" class="form-control">
    <option value="">--Pilih Bulan--</option>
    <option value="01">Januari</option>
     <option value="02">Febuari</option>
      <option value="03">Maret</option>
       <option value="04">April</option>
        <option value="05">Mei</option>
         <option value="06">Juni</option>
          <option value="07">Juli</option>
           <option value="08">Agustus</option>
            <option value="09">September</option>
             <option value="10">OKtober</option>
             <option value="11">November</option>
             <option value="12">Desember</option>
  </select>
      </div>
      </div>
       <div class="col-md-3">
        <div class="form-group">
          <label>Jenis Surat</label>
          <select name="jenis" class="form-control">
            <?php foreach ($jenis as $tampil) {
              # code...
             ?>
            <option value="<?=$tampil->id_surat?>"><?=$tampil->jenis_surat?></option>
          <?php }?>
          </select>
        </div>
      </div>
       <div class="col-md-3">
        <div class="form-group">
        <button class="btn btn-success" style="margin-top:23px;" name="cari">Show</button>
        </div>
      </div>
</form>
    </div>
  

                 <div style="width: 500px;height: 500px;">
    <canvas id="myChart"></canvas>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<?Php if (isset($_POST['cari'])) {
  # code...
 ?>
 <script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php foreach ($grafik as $tamp){ echo  '"' . $tamp->tgl_berkas . '",';


                    } ?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach ($count as $tamp){ echo  '"' . $tamp->jumlah . '",';


                    } ?>],
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
<?php }?>
               