<style >
	.garis
		{
			border-top: 3px solid black;
		}
		.box1{
			 	position: left-fixed;
 				right: 220px;
				width:355px;
				height:230px;
				border-radius: 8px;
				margin-left: 580px;
			}
			.box2{
			 	position: relative;
 				left: 20px;
				width:250px;
				height:230px;
				
			}
			.box3{
			 	position: top-fixed;
			 	margin-top: -245px;
 			}
</style>
<!DOCTYPE html>
<html>
<head>
	<title>	</title>
	<!-- <link href="<?= base_url('assets/'); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
</head>
<body>
	<div class="container">	
<div class="box2">
			<img src="<?php echo base_url('assets/img/pemprov.png')?> " style="width: 100px; height: 100px; margin-top: 10px;">
		</div>
		<div class="box3">
					<h3 style="padding-top: 20px;"><center>PEMERINTAH PROVINSI BALI</center></h3>
					<h3 style="margin-top: -20px;margin-left: 80px;"><center>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</center></h3>
					<p style=" margin-top: -20px;"><center>Jalan Beliton No. 2, Telp. 0361-222883, Fax. 0361-228311</center>
						<center>Denpasar-80112</center></p>
		</div>
			
			<div class="garis"></div>
			<div><p align="right" style="margin-right:90px;">Denpasar,<?=date('d-M-Y')?></p>	
					<p align="right" style="margin-right:190px;">Kepada</p> <p align="right" style="margin-right:60px;margin-bottom:0px;">Yth<span style="padding-left:10px;">  <?=$surat['nama_divisi']?>	</span></p>
					<p align="right" style="margin-right:160px;margin-top:0px;">	ditempat</p>

			</div>
<h4 align="center" style="margin-bottom:1px;">SURAT PENGANTAR	</h4>
<p align="center" style="margin-top:0px;padding-top:0;" >NOMOR:<?=$surat['kd_berkas']?>	</p>

<div align="center"><?=$surat['pesan']?>	</div>
<p align="" style="margin-left:88px;margin-bottom:0px;">Diterima tangaal:...........</p>
<p align="" style="margin-left:88px;margin-top:1px;margin-bottom:0px;">Penerima, <span style="margin-left:260px;">Kepala Dinas Pekerjaan Umum dan</span></p>
<p align="" style="margin-left:88px;margin-top:1px;margin-bottom:0px;"><?=$surat['jabatan']?> <span style="margin-left:227px;">Penataan Ruang Provinsi Bali</span></p>
<p align="" style="margin-left:88px;margin-top:1px;margin-bottom:0px;">TTD <span style="margin-left:290px;"><img src="<?php echo base_url('assets/files/'.$surat['ttd'].'') ?>" style="width:170px;height:70px;"></span></p>
<p align="" style="margin-left:88px;margin-top:1px;margin-bottom:0px;width:200px;"><u><?=$surat['nama_penerima']?></u> <span style="margin-left:367px;"><u><?=$this->session->userdata('nama')?></u></span></p>
<p align="" style="margin-left:88px;margin-top:1px;margin-bottom:0px;"> <?=$surat['pangkat']?> <span style="margin-left:281px;"><?=$surat['nama_jabatan']?></span></p>
<p align="" style="margin-left:88px;margin-top:1px;margin-bottom:0px;">NIP <?=$surat['nip_penerima']?> <span style="margin-left:280px;">NIP <?=$this->session->userdata('nip')?></span></p>
			</div>
</body>
</html>
<script>

window.print();

//setTimeout(function(){ this.close(); }, 500);

</script>