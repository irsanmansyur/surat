<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();


        is_logged_in();
        is_user();
        $this->load->helper('tglindo');
        $this->load->model('User_model', 'user');
        $this->sess_id = $this->session->userdata('id');
    }

    public function index()
    {
        $this->form_validation->set_rules('kd_surat', 'Kode Surat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Beranda';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();


            $this->db->select("tb_berkas.*");
            $this->db->from("tb_berkas");
            $this->db->join("tb_struktural", "tb_struktural.jabatan_nm=tb_berkas.tuj_berkas");
            $this->db->where(
                [
                    // "tb_berkas.jenis_surat" => "1",
                    "status_berkas" => "0",
                    "tb_struktural.user_id" => $this->sess_id
                ]
            );
            $tbSuratMasuk = $this->db->get();

            $data['total_surat_masuk'] = $tbSuratMasuk->num_rows();

            $this->db->select("tb_berkas.*");
            $this->db->from("tb_berkas");
            $this->db->join("tb_struktural", "tb_struktural.jabatan_nm=tb_berkas.tuj_berkas");
            $this->db->where(
                ["tb_berkas.jenis_surat !=" => "1", "status_berkas" => "0", "sess_id" => $this->sess_id]
            );
            $tbSuratKeluar = $this->db->get();
            $data['total_surat_keluar'] = $tbSuratKeluar->num_rows();

            // $data['kirim_berkas'] = $this->user->countKirimBerkas();
            $this->db->select("tb_berkas.*");
            $this->db->from("tb_berkas");
            $this->db->join("tb_struktural", "tb_struktural.jabatan_nm=tb_berkas.tuj_berkas");
            $this->db->where(
                ["tb_berkas.jenis_surat !=" => "1", "file_upload !=" => "", "status_berkas" => "0", "sess_id" => $this->sess_id]
            );
            $data['kirim_berkas'] = $this->db->get()->num_rows();

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
            $sess_id = $this->session->userdata('id');
            $data = array(
                'jns_surat' => $this->input->post('jns_surat', true),
                'kd_surat' => $this->input->post('kd_surat', true),
                'no_surat' => $this->input->post('no_surat', true),
                'tuj_surat' => $this->input->post('tuj_surat', true),
                'tgl_surat' => $this->input->post('tgl_surat', true),
                'isi_surat' => $this->input->post('isi_surat', true),
                'sess_id' => $sess_id,
                'status' => 1
            );
            $this->db->insert('tb_surat', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('user/list_surat');
        }
    }

    public function add_berkas()
    {
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
            /*   $upload_file = $_FILES['ttd']['name'];
             $config['allowed_types'] = 'jpg|png|jpeg|xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt';
                $config['max_size']     = '100048';
                $config['upload_path'] = './assets/files/';
                $this->load->library('upload', $config);
                $this->upload->do_upload('ttd');
                   $ttd = $this->upload->data('file_name');

                   $config1['upload_path']          = './assets/berkas';
       $config1['allowed_types'] = 'xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt';
    $config1['max_size'] = 9048;
   
    $this->load->library('upload', $config1);
 
   $this->upload->do_upload('file');
         $ttd=$this->upload->data(); */




            /*    $file = $this->upload->data();
            $config['upload_path']          = './assets/files';
            $config8['allowed_types']        = 'gif|jpg|png|pdf';
        $config8['max_size']             = 10048;
        $config8['max_width']            = 10048;
        $config8['max_height']           = 10048;
 
        $this->load->library('upload',$config8);
        
            $this->upload->do_upload('ttd');
            $ttd=$this->upload->data(); */


            // if ($upload_file) {
            if ($_FILES['fileku']['name'] == "") {
                $sess_id = $this->session->userdata('id');
                $data = array(
                    'kd_berkas' => $this->input->post('kd_berkas', true),
                    'tuj_berkas' => $this->input->post('tuj_berkas', true),
                    'nama_berkas' => $this->input->post('nama_berkas', true),
                    'tgl_berkas' => $this->input->post('tgl_berkas', true),
                    'pesan' => $this->input->post('pesan', true),
                    'sess_id' => $sess_id,
                    'status_berkas' => 1,
                    'jenis_surat' => $this->input->post('jenis_surat'),
                    'perihal' => $this->input->post('perihal'),
                    'tembusan' => $this->input->post('tembusan'),
                    'sifat' => $this->input->post('sifat'),
                    'lampiran' => $this->input->post('lampiran'),
                    'id_template' => $this->input->post('template'),
                    //'ttd'=>$ttd['file_name'],
                    'nama_penerima' => $this->input->post('nama_penerima'),
                    'nip_penerima' => $this->input->post('nip_penerima'),
                    'jabatan' => $this->input->post('jabatan'),
                    'pangkat' => $this->input->post('pangkat')

                );
            } else {
                //$upload_file = $_FILES['file']['name'];


                $config['allowed_types'] = 'xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt';
                $config['max_size'] = 100048;
                $config['upload_path'] = './assets/files';
                // $config['max_width']            = 2048;
                // $config['max_height']           = 2048;

                $this->load->library('upload', $config);

                $this->upload->do_upload('fileku');
                $file = $this->upload->data();
                $sess_id = $this->session->userdata('id');
                $data = array(
                    'kd_berkas' => $this->input->post('kd_berkas', true),
                    'tuj_berkas' => $this->input->post('tuj_berkas', true),
                    'nama_berkas' => $this->input->post('nama_berkas', true),
                    'tgl_berkas' => $this->input->post('tgl_berkas', true),
                    'pesan' => $this->input->post('pesan', true),
                    'sess_id' => $sess_id,
                    'status_berkas' => 1,
                    'file_upload' => $file['file_name'],
                    'jenis_surat' => $this->input->post('jenis_surat'),
                    'perihal' => $this->input->post('perihal'),
                    'tembusan' => $this->input->post('tembusan'),
                    'sifat' => $this->input->post('sifat'),
                    'lampiran' => $this->input->post('lampiran'),
                    'id_template' => $this->input->post('template'),
                    //'ttd'=>$ttd['file_name'],
                    'nama_penerima' => $this->input->post('nama_penerima'),
                    'nip_penerima' => $this->input->post('nip_penerima'),
                    'jabatan' => $this->input->post('jabatan'),
                    'pangkat' => $this->input->post('pangkat')
                );

                // } else {
                // $this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder" role="alert">UPLOAD GAGAL !..  Ekstensi File Salah / Ukuran file tidak boleh dari 2 mb</div>');
                // redirect('user/index');
                // }

            }
            $this->db->insert('tb_berkas', $data);
            $this->session->set_flashdata('message', 'Simpan berkas');
            //redirect('user/list_berkas');
            //  } else {
            //$this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder" role="alert">UPLOAD GAGAL !..  File Upload harus disertakan </div>');
            //  redirect('user/index');
            //}
        }
    }

    public function profile()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'My Profile';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['surat'] = $this->db->get_where('tb_surat', ['sess_id' => $this->session->userdata('id')])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/profile', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/profile';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $old_image = $data['id']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Update Gagal</div>');
                    redirect('user/profile');
                }
            }
            $id = $this->input->post('id');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');

            $this->db->set('nama', $nama);
            $this->db->set('email', $email);
            $this->db->where('id', $id);
            $this->db->update('mst_user');

            $this->session->set_flashdata('message', 'Update data');
            redirect('user/profile');
        }
    }

    public function changePassword()
    {

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password1', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/profile', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if ($current_password == $new_password) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">GAGAL..... Password baru tidak boleh sama dengan password lama</div>');
                redirect('user/profile');
            } else {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $password_hash);
                $this->db->where('username', $this->session->userdata('username'));
                $this->db->update('mst_user');
                $this->session->set_flashdata('message', 'Ubah password');
                redirect('user/profile');
            }
        }
    }

    public function list_surat()
    {
        $this->form_validation->set_rules('id_tb_surat', 'ID Surat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Daftar Surat';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['surat'] = $this->db->get_where('tb_surat', ['sess_id' => $this->session->userdata('id')])->result_array();
            $data['jenis_surat'] = $this->db->get('mst_surat')->result_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/list_surat', $data);
            $this->load->view('templates/footer');
        } else {
            $id_tb_surat = $this->input->post('id_tb_surat', true);
            $jns_surat = $this->input->post('jns_surat', true);
            $no_surat = $this->input->post('no_surat', true);
            $tuj_surat = $this->input->post('tuj_surat', true);
            $tgl_surat = $this->input->post('tgl_surat', true);
            $isi_surat = $this->input->post('isi_surat', true);

            $this->db->set('jns_surat', $jns_surat);
            $this->db->set('no_surat', $no_surat);
            $this->db->set('tuj_surat', $tuj_surat);
            $this->db->set('tgl_surat', $tgl_surat);
            $this->db->set('isi_surat', $isi_surat);
            $this->db->where('id_tb_surat', $id_tb_surat);
            $this->db->update('tb_surat');
            $this->session->set_flashdata('message', 'Update surat');
            redirect('user/list_surat');
        }
    }

    public function get_surat()
    {
        echo json_encode($this->user->getEditSurat($_POST['id_tb_surat']));
    }

    public function kirim_surat()
    {
        $id_tb_surat = $this->input->post('id_tb_surat', true);
        $status = 0;
        $this->db->set('status', $status);
        $this->db->where('id_tb_surat', $id_tb_surat);
        $this->db->update('tb_surat');
        $this->session->set_flashdata('message', 'Kirim surat');
        redirect('user/list_surat');
    }

    public function del_surat($id_tb_surat)
    {
        $this->db->where('id_tb_surat', $id_tb_surat);
        $this->db->delete('tb_surat');
        $this->session->set_flashdata('message', 'Hapus surat');
        redirect('user/list_surat');
    }

    public function list_berkas()
    {
        $this->form_validation->set_rules('id_berkas', 'ID Berkas', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Daftar Berkas';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();

            $data['berkas'] = $this->db

                ->join('mst_divisi', 'tb_berkas.tuj_berkas=mst_divisi.id_divisi')
                ->get_where('tb_berkas', ['sess_id' => $this->session->userdata('id')])->result_array();

            // $data['berkas'] = $this->db->get_where('tb_berkas', ['sess_id' => $this->session->userdata('id')])->result_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/list_berkas', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_image = $_FILES['file']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'xls|xlsx|doc|docx|ppt|pptx|pdf|zip|rar|txt';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/files/';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('file')) {
                    $id_berkas = $this->input->post('id_berkas', true);
                    $data['berkas_link'] = $this->db->get_where('tb_berkas', ['id_berkas' => $id_berkas])->row_array();
                    $old_file = $data['berkas_link']['file_upload'];
                    if ($old_file != 'default.docx') {
                        unlink(FCPATH . 'assets/files/' . $old_file);
                    }
                    $new_file = $this->upload->data('file_name');
                    $this->db->set('file_upload', $new_file);
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Update Gagal !!.. Ekstensi atau ukuran file tidak sesuai</div>');
                    redirect('user/list_berkas');
                }
            }
            $id_berkas = $this->input->post('id_berkas', true);
            $tuj_berkas = $this->input->post('tuj_berkas', true);
            $nama_berkas = $this->input->post('nama_berkas', true);
            $tgl_berkas = $this->input->post('tgl_berkas', true);
            $pesan = $this->input->post('pesan', true);
            $this->db->set('tuj_berkas', $tuj_berkas);
            $this->db->set('nama_berkas', $nama_berkas);
            $this->db->set('tgl_berkas', $tgl_berkas);
            $this->db->set('pesan', $pesan);
            $this->db->where('id_berkas', $id_berkas);
            $this->db->update('tb_berkas');
            $this->session->set_flashdata('message', 'Ubah data');
            redirect('user/list_berkas');
        }
    }

    public function get_berkas()
    {
        echo json_encode($this->user->getEditBerkas($_POST['id_berkas']));
    }

    public function kirim_berkas()
    {
        $id_berkas = $this->input->post('id_berkas', true);
        $status_berkas = 0;
        $this->db->set('status_berkas', $status_berkas);
        $this->db->where('id_berkas', $id_berkas);
        $this->db->update('tb_berkas');
        $data = [
            'id_divisi' => $this->input->post('id_divisi'),
            'pesan' => 'Ada Berkas Baru Masuk',
            'id_berkas' => $this->input->post('id_berkas')


        ];
        $this->db->insert('tb_notif', $data);
        $this->session->set_flashdata('message', 'Kirim berkas');
        redirect('user/list_berkas');
    }

    public function download_file()
    {
        $id_berkas = $this->input->post('id_berkas', true);
        $data = $this->db->get_where('tb_berkas', ['id_berkas' => $id_berkas])->row_array();
        header("Content-Disposition: attachment; filename=" . $data['file_upload']);
        $fp = fopen("assets/files/" . $data['file_upload'], 'r');
        $content = fread($fp, filesize('assets/files/' . $data['file_upload']));
        fclose($fp);
        echo $content;
        exit;
    }

    public function del_berkas($id_berkas)
    {
        $_id = $this->db->get_where('tb_berkas', ['id_berkas' => $id_berkas])->row();
        $query = $this->db->delete('tb_berkas', ['id_berkas' => $id_berkas]);
        if ($query) {
            unlink("assets/files/" . $_id->file_upload);
        }
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('user/list_berkas');
    }


    public function surat_masuk()
    {
        $data['title'] = 'Surat Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['divisi_nm'] = $this->user->getDivisiName();
        $divisi_nm = $this->user->getDivisiName();
        $data['surat_masuk'] = $this->user->getSuratMasuk($divisi_nm);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/surat_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function berkas_masuk()
    {
        $data['title'] = 'Berkas Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $uri = $this->uri->segment(3);
        if (isset($uri)) {
            $this->db->where('id_notif', $this->uri->segment(4));
            $this->db->update('tb_notif', ['status_baca' => 1]);
            $data['divisi_nm'] = $this->user->getDivisiName();
            $divisi_nm = $this->user->getDivisiName();

            $data['berkas_masuk'] = $this->db

                ->join('mst_divisi', 'tb_berkas.tuj_berkas=mst_divisi.id_divisi')
                ->join('tb_struktural', 'tb_berkas.sess_id = tb_struktural.user_id')
                ->get_where('tb_berkas', ['id_berkas' => $uri])->result_array();
        } else {
            $data['divisi_nm'] = $this->user->getDivisiName();
            $divisi_nm = $this->user->getDivisiName();

            $data['berkas_masuk'] = $this->user->getBerkasMasuk($divisi_nm);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/berkas_masuk', $data);
        $this->load->view('templates/footer');
    }

    function cetak_surat()
    {
        $id = $this->uri->segment(3);
        $template = $this->uri->segment(4);
        $data['surat'] = $this->db

            ->join('mst_divisi', 'tb_berkas.tuj_berkas=mst_divisi.id_divisi')
            ->join('mst_jabatan', 'mst_divisi.id_divisi=mst_jabatan.id_divisi')
            ->get_where('tb_berkas', ['id_berkas' => $id])->row_array();
        //  $mpdf = new \Mpdf\Mpdf();
        //  $html = $this->load->view('template_surat/surat',$data,true);
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();
        if ($template == 1) {
            $this->load->view('template_surat/surat_2', $data);
        } else if ($template == 2) {

            $this->load->view('template_surat/surat', $data);
        } else if ($template == 3) {

            $this->load->view('template_surat/surat_3', $data);
        }
    }
    function report_chart()
    {
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['jenis'] = $this->db->get('mst_surat')->result();
        if (isset($_POST['cari'])) {
            # code...
            $id = $this->session->userdata('id');
            $data['count'] = $this->db

                ->group_by('tgl_berkas')
                ->where('sess_id', $id)
                ->where('status_berkas', 0)
                ->where('tgl_berkas BETWEEN"' . $_POST['periode_awal'] . '" and "' . $_POST['periode_akhir'] . '"')
                ->where('jenis_surat', $_POST['jenis'])
                ->select('count(*) as jumlah')
                ->get('tb_berkas')->result();
            $data['grafik'] = $this->db
                ->select('tgl_berkas')
                // ->group_by('tgl_berkas')
                ->where('status_berkas', 0)
                ->where('sess_id', $id)
                ->where('jenis_surat', $_POST['jenis'])
                ->where('tgl_berkas BETWEEN"' . $_POST['periode_awal'] . '" and "' . $_POST['periode_akhir'] . '"')
                ->get('tb_berkas')->result();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('grafik_batang', $data);
        $this->load->view('templates/footer');
    }


    function keluar_bulan()
    {
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['jenis'] = $this->db->get('mst_surat')->result();
        $id = $this->session->userdata('id');
        $bulan = $_POST['bulan'];
        $jenis = $this->input->post('jenis');
        $data['count'] = $this->db->query("select count(*) as jumlah from tb_berkas where month(tgl_berkas)='$bulan' and status_berkas=0 and sess_id='$id' and jenis_surat='$jenis' group by tgl_berkas")->result();
        $data['grafik'] = $this->db->query("select * from tb_berkas where month(tgl_berkas)='$bulan' and status_berkas=0 and sess_id='$id' and jenis_surat='$jenis' group by tgl_berkas")->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('grafik_batang', $data);
        $this->load->view('templates/footer');
    }
    function surat_masukperiode()
    {
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['jenis'] = $this->db->get('mst_surat')->result();
        if (isset($_POST['cari'])) {
            # code...
            $id = $this->session->userdata('id');
            $data['count'] = $this->db

                ->group_by('tgl_berkas')
                ->where('sess_id !=', $id)
                ->where('status_berkas', 0)
                ->where('tgl_berkas BETWEEN"' . $_POST['periode_awal'] . '" and "' . $_POST['periode_akhir'] . '"')
                ->where('jenis_surat', $_POST['jenis'])
                ->select('count(*) as jumlah')
                ->get('tb_berkas')->result();
            $data['grafik'] = $this->db
                ->select('tgl_berkas')
                // ->group_by('tgl_berkas')
                ->where('status_berkas', 0)
                ->where('sess_id !=', $id)
                ->where('jenis_surat', $_POST['jenis'])
                ->where('tgl_berkas BETWEEN"' . $_POST['periode_awal'] . '" and "' . $_POST['periode_akhir'] . '"')
                ->get('tb_berkas')->result();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('grafik_suratmasuk', $data);
        $this->load->view('templates/footer');
    }

    function masuk_bulan()
    {
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['jenis'] = $this->db->get('mst_surat')->result();
        $id = $this->session->userdata('id');
        $jenis = $this->input->post('jenis');
        $bulan = $_POST['bulan'];
        $data['count'] = $this->db->query("select count(*) as jumlah from tb_berkas where month(tgl_berkas)='$bulan' and status_berkas=0 and sess_id !='$id' and jenis_surat='$jenis' group by tgl_berkas")->result();
        $data['grafik'] = $this->db->query("select * from tb_berkas where month(tgl_berkas)='$bulan' and status_berkas=0 and sess_id !='$id' and jenis_surat='$jenis' group by tgl_berkas")->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('grafik_suratmasuk', $data);
        $this->load->view('templates/footer');
    }

    function grafik_line()
    {

        if (isset($_POST['cari'])) {
            $id = $this->session->userdata('id');

            $tahun = $_POST['tahun'];
            $data['count'] = $this->db->query("select count(*) as jumlah from tb_berkas where year(tgl_berkas)='$tahun' and status_berkas=0 and sess_id ='$id'  group by year(tgl_berkas)")->result();
            $data['grafik'] = $this->db->query("select * from tb_berkas where year(tgl_berkas)='$tahun' and status_berkas=0 and sess_id ='$id'  group by year(tgl_berkas)")->result();
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('grafik_line', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('grafik_line', $data);
            $this->load->view('templates/footer');
        }
    }

    function grafik_line_masuk()
    {

        if (isset($_POST['cari'])) {
            $id = $this->session->userdata('id');

            $tahun = $_POST['tahun'];
            $data['count'] = $this->db->query("select count(*) as jumlah from tb_berkas where year(tgl_berkas)='$tahun' and status_berkas=0 and sess_id !='$id'  group by year(tgl_berkas)")->result();
            $data['grafik'] = $this->db->query("select * from tb_berkas where year(tgl_berkas)='$tahun' and status_berkas=0 and sess_id !='$id'  group by year(tgl_berkas)")->result();
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('grafikline_masuk', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('grafikline_masuk', $data);
            $this->load->view('templates/footer');
        }
    }


    function chat_index()
    {

        $data['title'] = 'Chatting';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['divisi'] = $this->db->get('mst_divisi')->result();
        $div = $this->session->userdata('divisi');
        $notif = $id = $this->uri->segment(3);
        if (isset($notif)) {
            $update = $this->db->query("update tb_notif_chat set status_baca=1 where hash='$notif'");
            $data['chat'] = $this->db
                ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
                ->group_by('hash')
                ->order_by('id_chat', 'desc')
                ->get_where('tb_chat', ['tb_chat.hash' => $notif])->result();
        } else {
            $data['chat'] = $this->db
                ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
                ->group_by('hash')
                ->order_by('id_chat', 'desc')
                ->get_where('tb_chat', ['tb_chat.id_divisi' => $div])->result();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/pesan', $data);
        $this->load->view('templates/footer');
    }
    function save_chat()
    {
        //$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $divisi = $this->input->post('divisi');
        $isi = $this->input->post('isi');
        $hash = $this->input->post('hash');
        $data = [
            'id_divisi' => $divisi,
            'pesan' => $isi,
            'hash' => $this->input->post('hash')

        ];
        $notif = [
            'hash' => $this->input->post('hash'),
            'id_divisi' => $divisi,
            'pesan' => $isi

        ];
        $this->db->insert('tb_notif_chat', $notif);
        $this->db->insert('tb_chat', $data);
        if ($this->db->affected_rows() > 0) {
            $query = $this->db
                ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
                ->get_where('tb_chat', ['tb_chat.id_divisi' => $divisi, 'hash' => $hash])->result();

            echo json_encode($query);
        }
    }


    function detail_chat()
    {

        $hash = $this->input->post('hash_id');
        $query = $this->db
            ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
            ->get_where('tb_chat', ['hash' => $hash])->result();

        echo json_encode($query);
    }


    function get_chat()
    {
        //$data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $divisi = $this->input->post('divisi');
        $query = $this->db
            ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
            ->group_by('tb_chat.id_divisi')
            ->get_where('tb_chat', ['tb_chat.id_divisi' => $divisi])->result();
        foreach ($query as $tampil) {
            echo '<div class="chat_list"><div class="chat_people"><div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="chat_ib"><h5>' . $tampil->nama_divisi . ' <span class="chat_date">Dec 25</span></h5><p>' . $tampil->pesan . '</p></div></div></div>';
        }
    }

    function cek_divisi()
    {

        $kontak = $this->input->post('kontak');
        $sql = $this->db->get_where("mst_divisi", ['id_divisi' => $kontak])->row_array();
        echo json_encode($sql);
    }
}
