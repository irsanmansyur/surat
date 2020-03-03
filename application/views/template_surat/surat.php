<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			
		}
		.container
		{
			
			
		}
		.garis
		{
			border-top: 3px solid black;
		}
		.h2
		{
			margin-top: 10px;
			position: top-fixed;
		}
		.atas
		{
			margin-top: -20px;
		}
		.text1 {
			text-indent: 25px;
			text-align: justify;
			margin-left: 60px;
			margin-right: 60px;
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
 			.tabel{
 				font-family: sans-serif;
    		color: #232323;
    		border-collapse: collapse;
    		margin-left: -500px;
 			}
 			.kotak {
 				border: 1px solid #999;
    			padding: 8px 20px;
				}
 			}
	</style>
</head>
<body>
	<div class="container">
		<div class="box2">
			<img src="<?php echo base_url('assets/img/pemprov.png')?> " style="width: 100px; height: 100px; margin-top: 10px;">
		</div>
		<div class="box3">
					<h2 style="padding-top: 20px;"><center>PEMERINTAH PROVINSI BALI</center></h2>
					<h2 style="margin-top: -20px;margin-left: 50px;"><center>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</center></h2>
					<p style=" margin-top: -20px;"><center>Jalan Beliton No. 2, Telp. 0361-222883, Fax. 0361-228311</center>
						<center>Denpasar-80112</center></p>
		</div>
			
			<div class="garis"></div>

			<div class="isi">
				<p align="right" style="margin-right: 170px;">
					Denpasar, <?=date('d-M-y')?><br>

				</p>
				<p align="right" style="margin-right: 263px;margin-bottom:1px;">Kepada</p>
				<div class="atas">
					<table >
						<td>
							<p style="margin-left: 60px;">
								Nomor 	<br>
								Sifat 	<br>
								Lampiran<br>
								Hal		
							</p>
						</td>

						<td>
							:<?=$surat['kd_berkas']?> <br>
							:<?=$surat['sifat']?><br>
							:<?=$surat['lampiran']?><br>
							:Permohonan Audiensi
						</td>
						<td>
							<p style="margin-left: 334px; margin-right: 60px;margin-top: 0px;">Yth. <?=$surat['nama_divisi']?><br>
								ditempat
							</p>
						</td>
					</table>
					<div class="text1">
					<?=$surat['pesan']?>
					</div>
				
					<div class="box1">
							<table class="tabel">
						<tr>
							

							<th class="kotak" colspan="2">Paraf Hirarki
							</th>
						</tr>
						<tr>
							<td class="kotak">Sekertaris Dinas</td>
							<td class="kotak">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td class="kotak">
								Kasubag Penyusunan Program<br>
								Keuangan Evaluasi dan Pelaporan
							</td>
							<td class="kotak">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
					</table>
					<div style="margin-top: -145px;">
					<p>Kepala Dinas Pekerjaan Umum dan<br>
					Penataan Ruang Provinsi Bali<br>
				<img src="<?php echo base_url('assets/files/'.$surat['ttd'].'') ?>" style="width:170px;height:70px;">
					<p style="margin-top: 0px;"><u><?=$this->session->userdata('nama')?></u>
							<br><?=$surat['nama_jabatan']?>
							<br>NIP. <?=$this->session->userdata('nip')?>
						</p>
				</p>
				</div>	
				</div>
				<p  style="margin-top:0px;  padding-bottom: 0px;">Tembusan disampaikan Kepada Yth:<br>

				
				</p>
				<?=$surat['tembusan']?>
				</div>
			</div>
		</div>

	</body>
	</html>
	<script>

window.print();

//setTimeout(function(){ this.close(); }, 500);

</script>