 <div class="right_col" role="main">
    <div class="row">
    	<form action="<?php echo base_url('admin/grafik_line') ?>" method="post">
    	<div class="col-md-3">
    		<div class="form-group">
    			<label>Tahun</label>
    			<select name="tahun" class="form-control">
                <option value="">Please Select</option>
                <?php
                $thn_skr = date('Y');
                for ($x = $thn_skr; $x >= 2010; $x--) {
                ?>
                    <option value="<?php echo $x ?>"><?php echo $x ?></option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<?php if (isset($_POST['cari'])) {
	# code...
 ?>
	<script type="text/javascript">
		var speedCanvas = document.getElementById("speedChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var speedData = {
  labels: [<?php foreach ($grafik as $tamp){ echo  '"' . date('Y',strtotime($tamp->tgl_berkas)) . '",';


                    } ?>],
  datasets: [{
    label: "Surat Keluar",
    data: [<?php foreach ($count as $tamp){ echo  '"' . $tamp->jumlah . '",';


                    } ?>],
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
<?php }?>
</div>


    </div>