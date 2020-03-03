<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        is_admin();
        $this->load->helper('tglindo');
        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[mst_user.username]', array(
            'is_unique' => 'Username sudah ada'
        ));
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', array(
            'matches' => 'Password tidak sama',
            'min_length' => 'password min 3 karakter'
        ));
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Dashboard';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['kode_pegawai'] = $this->admin->getKodePegawai();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $data['mst_jabatan'] = $this->db->get('mst_jabatan')->result_array();
            $data['user_perbulan'] = $this->admin->countUserPerbulan();
            $data['count_user'] = $this->admin->countJmlUser();
            $data['user_aktif'] = $this->admin->countUserAktif();
            $data['user_tak_aktif'] = $this->admin->countUserTakAktif();
            $data['list_user'] = $this->db->get('mst_user')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama' => $this->input->post('nama', true),
                'email' => $this->input->post('email', true),
                'username' => $this->input->post('username', true),
                'level' => $this->input->post('level', true),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'date_created' => date('Y/m/d'),
                'image' => 'default.jpg',
                'is_active' => 1,
                'nip' => $this->input->post('nip')
            );
            $this->db->insert('mst_user', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('admin/index');
        }
    }

    public function add_struktur()
    {

        $this->form_validation->set_rules('kode_pegawai', 'Kode Pegawai', 'required|trim|is_unique[tb_struktural.kode_pegawai]', array(
            'is_unique' => 'Simpan Gagal !!.. Kode Pegawai sudah ada'
        ));
        $this->form_validation->set_rules('id', 'User ID', 'required|trim|is_unique[tb_struktural.user_id]', array(
            'is_unique' => 'Simpan Gagal !!.. User ID sudah ada'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Dashboard';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['kode_pegawai'] = $this->admin->getKodePegawai();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $data['mst_jabatan'] = $this->db->get('mst_jabatan')->result_array();
            $data['user_perbulan'] = $this->admin->countUserPerbulan();
            $data['count_user'] = $this->admin->countJmlUser();
            $data['user_aktif'] = $this->admin->countUserAktif();
            $data['user_tak_aktif'] = $this->admin->countUserTakAktif();
            $data['list_user'] = $this->db->get('mst_user')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'user_id' => $this->input->post('id', true),
                'kode_pegawai' => $this->input->post('kode_pegawai', true),
                'nama_pegawai' => $this->input->post('nama_pegawai', true),
                'divisi_nm' => $this->input->post('divisi_nm', true),
                'jabatan_nm' => $this->input->post('jabatan_nm', true),
            );
            $this->db->insert('tb_struktural', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('admin/mst_pegawai');
        }
    }

    public function profile()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'My Profile';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_struktur'] = $this->db->get('tb_struktural')->result_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $data['mst_jabatan'] = $this->db->get('mst_jabatan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/profile', $data);
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
                    redirect('admin/profile');
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
            redirect('admin/profile');
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
            $data['list_user'] = $this->db->get('mst_user')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/profile', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if ($current_password == $new_password) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">GAGAL..... Password baru tidak boleh sama dengan password lama</div>');
                redirect('admin/profile');
            } else {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $password_hash);
                $this->db->where('username', $this->session->userdata('username'));
                $this->db->update('mst_user');
                $this->session->set_flashdata('message', 'Ubah password');
                redirect('admin/profile');
            }
        }
    }

    public function get_edit()
    {
        echo json_encode($this->admin->getUserEdit($_POST['id']));
    }

    public function edit_user()
    {
        $id = $this->input->post('id', true);
        $is_active = $this->input->post('is_active', true);
        $level = $this->input->post('level', true);
        $nip = $this->input->post('nip');

        $this->db->set('is_active', $is_active);
        $this->db->set('level', $level);
        $this->db->set('nip', $nip);
        $this->db->where('id', $id);
        $this->db->update('mst_user');
        $this->session->set_flashdata('message', 'Update user');
        redirect('admin/index');
    }

    public function del_user($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mst_user');
        $this->session->set_flashdata('message', 'Hapus user');
        redirect('admin/index');
    }

    public function mst_pegawai()
    {
        $this->form_validation->set_rules('id_struktur', 'ID Struktural', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Data Pegawai';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $data['mst_jabatan'] = $this->db->get('mst_jabatan')->result_array();
            $data['list_struktur'] = $this->db
                ->join('mst_jabatan', 'tb_struktural.jabatan_nm=mst_jabatan.id_jabatan')
                ->join('mst_divisi', 'tb_struktural.divisi_nm=mst_divisi.id_divisi')
                ->get('tb_struktural')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/pegawai/mst_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $id_struktur = $this->input->post('id_struktur', true);
            $divisi_nm = $this->input->post('divisi_nm', true);
            $jabatan_nm = $this->input->post('jabatan_nm', true);
            $this->db->set('divisi_nm', $divisi_nm);
            $this->db->set('jabatan_nm', $jabatan_nm);
            $this->db->where('id_struktur', $id_struktur);
            $this->db->update('tb_struktural');
            $this->session->set_flashdata('message', 'Update Struktural');
            redirect('admin/mst_pegawai');
        }
    }

    public function get_struktur()
    {
        echo json_encode($this->admin->getEditStruktur($_POST['id_struktur']));
    }

    public function del_pegawai($id_struktur)
    {
        $this->db->where('id_struktur', $id_struktur);
        $this->db->delete('tb_struktural');
        $this->session->set_flashdata('message', 'Hapus pegawai');
        redirect('admin/mst_pegawai');
    }

    public function mst_jabatan()
    {
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Master Divisi dan Jabatan';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $data['mst_jabatan'] = $this->db
                ->join('mst_divisi', 'mst_jabatan.id_divisi=mst_divisi.id_divisi')
                ->get('mst_jabatan')->result_array();
            $data['divisi'] = $this->db->get('mst_divisi')->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/pegawai/mst_jabatan', $data);

            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama_jabatan' => $this->input->post('nama_jabatan', true),
                'id_divisi' => $this->input->post('divisi')
            );
            $this->db->insert('mst_jabatan', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('admin/mst_jabatan');
        }
    }


    public function get_jabatan()
    {
        echo json_encode($this->admin->getEditJabatan($_POST['id_jabatan']));
    }

    public function edit_jabatan()
    {
        $id_jabatan = $this->input->post('id_jabatan', true);
        //  $nama_jabatan = $this->input->post('nama_jabatan', true);
        $data = [
            'nama_jabatan' => $this->input->post('nama_jabatan', true),
            'id_divisi' => $this->input->post('divisi')

        ];
        // $this->db->set('nama_jabatan', $nama_jabatan);
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->update('mst_jabatan', $data);
        $this->session->set_flashdata('message', 'Update jabatan');
        redirect('admin/mst_jabatan');
    }

    public function del_jabatan($id_jabatan)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->delete('mst_jabatan');
        $this->session->set_flashdata('message', 'Hapus jabatan');
        redirect('admin/mst_jabatan');
    }

    public function mst_divisi()
    {
        $this->form_validation->set_rules('nama_divisi', 'Nama Divisi', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Master Divisi dan Jabatan';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['mst_divisi'] = $this->db->get('mst_divisi')->result_array();
            $data['mst_jabatan'] = $this->db->get('mst_jabatan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/pegawai/mst_jabatan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'nama_divisi' => $this->input->post('nama_divisi', true),
            );
            $this->db->insert('mst_divisi', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('admin/mst_jabatan');
        }
    }
    public function get_divisi()
    {
        echo json_encode($this->admin->getEditDivisi($_POST['id_divisi']));
    }

    public function edit_divisi()
    {
        $id_divisi = $this->input->post('id_divisi', true);
        $nama_divisi = $this->input->post('nama_divisi', true);
        $this->db->set('nama_divisi', $nama_divisi);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->update('mst_divisi');
        $this->session->set_flashdata('message', 'Update divisi');
        redirect('admin/mst_jabatan');
    }

    public function del_divisi($id_divisi)
    {
        $this->db->where('id_divisi', $id_divisi);
        $this->db->delete('mst_divisi');
        $this->session->set_flashdata('message', 'Hapus divisi');
        redirect('admin/mst_jabatan');
    }

    public function mst_surat()
    {
        $this->form_validation->set_rules('kode_surat', 'Kode Surat', 'required|trim|is_unique[mst_surat.kode_surat]', array(
            'is_unique' => 'Simpan Gagal !!.. Kode Surat sudah ada'
        ));
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required|trim|is_unique[mst_surat.jenis_surat]', array(
            'is_unique' => 'Simpan Gagal !!.. Jenis Surat sudah ada'
        ));

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Master Surat';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['kat_surat'] = $this->db->get('mst_kat_surat')->result_array();
            $data['mst_surat'] = $this->db->get('mst_surat')->result_array();
            $data['kode_surat'] = $this->admin->getKodeSurat();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/surat/mst_surat', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'kode_surat' => $this->input->post('kode_surat', true),
                'kategori_surat' => $this->input->post('kategori_surat', true),
                'jenis_surat' => $this->input->post('jenis_surat', true),
            );
            $this->db->insert('mst_surat', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('admin/mst_surat');
        }
    }

    public function add_kategori_surat()
    {
        $this->form_validation->set_rules('kategori', 'Nama Kategori', 'required|trim|is_unique[mst_kat_surat.kategori]', array(
            'is_unique' => 'Simpan Gagal !!.. Kategori surat sudah ada'
        ));

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Master Surat';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['kat_surat'] = $this->db->get('mst_kat_surat')->result_array();
            $data['mst_surat'] = $this->db->get('mst_surat')->result_array();
            $data['kode_surat'] = $this->admin->getKodeSurat();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/surat/mst_surat', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'kategori' => $this->input->post('kategori', true),
            );
            $this->db->insert('mst_kat_surat', $data);
            $this->session->set_flashdata('message', 'Simpan kategori');
            redirect('admin/mst_surat');
        }
    }

    public function get_surat()
    {
        echo json_encode($this->admin->getEditSurat($_POST['id_surat']));
    }

    public function edit_surat()
    {
        $id_surat = $this->input->post('id_surat', true);
        $kategori_surat = $this->input->post('kategori_surat', true);
        $jenis_surat = $this->input->post('jenis_surat', true);
        $this->db->set('kategori_surat', $kategori_surat);
        $this->db->set('jenis_surat', $jenis_surat);
        $this->db->where('id_surat', $id_surat);
        $this->db->update('mst_surat');
        $this->session->set_flashdata('message', 'Ubah data');
        redirect('admin/mst_surat');
    }

    public function del_surat($id_surat)
    {
        $this->db->where('id_surat', $id_surat);
        $this->db->delete('mst_surat');
        $this->session->set_flashdata('message', 'Hapus surat');
        redirect('admin/mst_surat');
    }

    public function list_surat()
    {
        $data['title'] = 'Daftar Surat';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['surat'] = $this->admin->getAllSurat();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/data/list_surat', $data);
        $this->load->view('templates/footer');
    }

    public function get_esurat()
    {
        echo json_encode($this->admin->getEditEsurat($_POST['id_tb_surat']));
    }

    public function list_berkas()
    {

        $data['title'] = 'Daftar Berkas';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['berkas'] = $this->admin->getAllBerkas();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/data/list_berkas', $data);
        $this->load->view('templates/footer');
    }

    public function get_berkas()
    {
        echo json_encode($this->admin->getEditBerkas($_POST['id_berkas']));
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
    function cek_jabatan()
    {

        $divisi = $this->input->post('divisi');
        $query = $this->db->get_where('mst_jabatan', ['id_divisi' => $divisi])->result();
        foreach ($query as $tampil) {
            echo "<option value='" . $tampil->id_jabatan . "'>" . $tampil->nama_jabatan . "</option>";
        }
    }





    function chat_index()
    {



        $data['title'] = 'Chatting';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['divisi'] = $this->db->get('mst_divisi')->result();
        $divisi = $this->session->userdata('divisi');
        $notif = $id = $this->uri->segment(3);
        if (isset($notif)) {
            $update = $this->db->query("update tb_notif_chat set status_baca=1 where hash='$notif'");
            $data['chat'] = $this->db
                ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
                ->group_by('hash')
                ->order_by('id_chat', 'desc')
                ->get_where('tb_chat', ['hash' => $notif])->result();
        } else {
            $data['chat'] = $this->db
                ->join('mst_divisi', 'tb_chat.id_divisi=mst_divisi.id_divisi')
                ->group_by('hash')
                ->order_by('id_chat', 'desc')
                ->get('tb_chat')->result();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/pesan', $data);
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
                ->get_where('tb_chat', ['hash' => $hash])->result();

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
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/grafik_batang', $data);
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
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/grafik_batang', $data);
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
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/grafik_suratmasuk', $data);
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
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/grafik_suratmasuk', $data);
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
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/grafik_line', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/grafik_line', $data);
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
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/grafikline_masuk', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('admin/grafikline_masuk', $data);
            $this->load->view('templates/footer');
        }
    }

    function cek_divisi()
    {

        $kontak = $this->input->post('kontak');
        $sql = $this->db->get_where("mst_divisi", ['id_divisi' => $kontak])->row_array();
        echo json_encode($sql);
    }
}
