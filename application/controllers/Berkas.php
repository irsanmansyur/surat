<?php
/**
 * 
 */
class Berkas extends CI_Controller
{
	
	function __construct()
	{
		 parent::__construct();


        is_logged_in();
        is_user();
        $this->load->helper('tglindo');
        $this->load->model('User_model', 'user');
	}


	function add_berkas(){
$sess_id = $this->session->userdata('id');
		  $this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'required|trim');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Beranda';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['kirim_surat'] = $this->user->countKirimSurat();
            $data['total_surat'] = $this->user->countTotalSurat();
            $data['kirim_berkas'] = $this->user->countKirimBerkas();
            $data['total_berkas'] = $this->user->countTotalBerkas();
            $data['kd_surat'] = $this->user->getKdSurat();
            $data['kd_berkas'] = $this->user->getKdBerkas();
            $data['jenis_surat'] = $this->db->get('mst_surat')->result_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/footer');
        } else {
 $config['allowed_types']='xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt|jpg|png|gif|jpeg';
        $config['max_size']=100048;
         $config['upload_path']='./assets/files';
       // $config['max_width']            = 2048;
       // $config['max_height']           = 2048;
 
        $this->load->library('upload', $config);
 
     $this->upload->do_upload('fileku');
      $file=$this->upload->data();


      //ttd
    //  $config1['allowed_types']='jpeg|jpg|png';
       // $config1['max_size']=100048;
         //$config1['upload_path']='./assets/files';
       // $config['max_width']            = 3048;
       // $config['max_height']           = 2048;
 
        //$this->load->library('upload', $config1);
 
     $this->upload->do_upload('ttd');
      $ttd=$this->upload->data();
                    
                    $data = array(
                        'kd_berkas' => $this->input->post('kd_berkas', true),
                        'tuj_berkas' => $this->input->post('tuj_berkas', true),
                        'nama_berkas' => $this->input->post('nama_berkas', true),
                        'tgl_berkas' => $this->input->post('tgl_berkas', true),
                        'pesan' => $this->input->post('pesan', true),
                        'sess_id' => $sess_id,
                        'status_berkas' => 1,
                        'file_upload' => $file['file_name'],
                         'jenis_surat'=>$this->input->post('jenis_surat'),
                        'perihal'=>$this->input->post('perihal'),
                        'tembusan'=>$this->input->post('tembusan'),
                         'sifat'=>$this->input->post('sifat'),
                        'lampiran'=>$this->input->post('lampiran'),
                         'id_template'=>$this->input->post('template'),
                         'ttd'=>$ttd['file_name'],
                          'nama_penerima'=>$this->input->post('nama_penerima'),
                        'nip_penerima'=>$this->input->post('nip_penerima'),
                        'jabatan'=>$this->input->post('jabatan'),
                        'pangkat'=>$this->input->post('pangkat')
                    );

 $this->db->insert('tb_berkas', $data);
                    $this->session->set_flashdata('message', 'Simpan berkas');
                    redirect('user/list_berkas');


        }
	}
}








?>