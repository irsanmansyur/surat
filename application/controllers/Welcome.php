<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function notifikasi(){
$divisi=$this->session->userdata('divisi');
		$data=$this->db
		->select('count(*) as notif,nama_berkas')
		->join('tb_berkas','tb_notif.id_berkas=tb_berkas.id_berkas')
		//->group_by('tb_notif.id_berkas,tb_notif.id_divisi')
		->get_where('tb_notif',['status_baca'=>0,'tb_notif.id_divisi'=>$divisi])->result();
		//foreach ($ as $key => $value) {
			# code...
		//}

		echo json_encode($data);
		
		
	}
}
