<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Report extends CI_Controller
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
    }
    function surat_keluar()
    {
        $this->load->library("form_validation");
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();


        $this->db->select("mst_surat.*, COUNT(tb_berkas.id_berkas) AS jumlah, tb_berkas.tgl_berkas");
        $this->db->from("mst_surat");
        $this->db->join("tb_berkas", "tb_berkas.id_berkas=mst_surat.berkas_id");
        $this->db->where("kategori_surat", "Surat Keluar");

        $this->form_validation->set_rules("periode_awal", "Tgl awal", "required");
        $this->form_validation->set_rules("periode_akhir", "Tgl Akhir", "required");

        if ($this->form_validation->run()) {
            $this->db->where('mst_surat.jenis_surat', $this->input->post('jenis'));
            $this->db->where('tgl_berkas >=', $this->input->post("periode_awal"));
            $this->db->where('tgl_berkas <=', $this->input->post("periode_akhir"));
        }

        if (isset($_POST['cari_bulan'])) {
            $this->form_validation->reset_validation();
            $this->db->where('mst_surat.jenis_surat', $this->input->post('jenis'));
            $this->db->where("month(tgl_berkas)", $this->input->post("bulan"));
        }

        $this->db->group_by("tb_berkas.tgl_berkas");
        $surat  = $this->db->get()->result();
        $data['surat'] = json_encode($surat);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/Report/surat_keluar', $data);
        $this->load->view('templates/footer');
    }
    function surat_masuk()
    {
        $this->load->library("form_validation");
        $data['title'] = 'Report Surat Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();


        $this->db->select("mst_surat.*, COUNT(tb_berkas.id_berkas) AS jumlah, tb_berkas.tgl_berkas");
        $this->db->from("mst_surat");
        $this->db->join("tb_berkas", "tb_berkas.id_berkas=mst_surat.berkas_id");
        $this->db->where("kategori_surat", "Surat Masuk");

        $this->form_validation->set_rules("periode_awal", "Tgl awal", "required");
        $this->form_validation->set_rules("periode_akhir", "Tgl Akhir", "required");

        if ($this->form_validation->run()) {
            $this->db->where('mst_surat.jenis_surat', $this->input->post('jenis'));
            $this->db->where('tgl_berkas >=', $this->input->post("periode_awal"));
            $this->db->where('tgl_berkas <=', $this->input->post("periode_akhir"));
        }

        if (isset($_POST['cari_bulan'])) {
            $this->db->where('mst_surat.jenis_surat', $this->input->post('jenis'));
            $this->db->where("month(tgl_berkas)", $this->input->post("bulan"));
        }

        $this->db->group_by("tb_berkas.tgl_berkas");
        $surat  = $this->db->get()->result();
        $data['surat'] = json_encode($surat);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('admin/Report/surat_masuk', $data);
        $this->load->view('templates/footer');
    }
    function grafik_line_surat_masuk()
    {
        $data['title'] = 'Report Grafik Line Surat Masuk';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();


        $this->db->select("mst_surat.*, COUNT(tb_berkas.id_berkas) AS jumlah, month(tb_berkas.tgl_berkas) AS month");
        $this->db->from("mst_surat");
        $this->db->join("tb_berkas", "tb_berkas.id_berkas=mst_surat.berkas_id");
        $this->db->where("kategori_surat", "Surat Masuk");

        if (isset($_POST['cari'])) {
            $this->db->where("year(tgl_berkas)", $this->input->post("tahun"));
        }
        $this->db->group_by("month(tb_berkas.tgl_berkas)");
        $surat  = $this->db->get()->result();

        $data['surat'] = json_encode($surat);


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin');
        $this->load->view('templates/navbar');
        $this->load->view('admin/report/grafik_line_surat_masuk');
        $this->load->view('templates/footer');
    }
    function grafik_line_surat_keluar()
    {
        $data['title'] = 'Report Grafik Line Surat Keluar';
        $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();


        $this->db->select("mst_surat.*, COUNT(tb_berkas.id_berkas) AS jumlah, month(tb_berkas.tgl_berkas) AS month");
        $this->db->from("mst_surat");
        $this->db->join("tb_berkas", "tb_berkas.id_berkas=mst_surat.berkas_id");
        $this->db->where("kategori_surat", "Surat Keluar");

        if (isset($_POST['cari'])) {
            $this->db->where("year(tgl_berkas)", $this->input->post("tahun"));
        }
        $this->db->group_by("month(tb_berkas.tgl_berkas)");
        $surat  = $this->db->get()->result();

        $data['surat'] = json_encode($surat);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin');
        $this->load->view('templates/navbar');
        $this->load->view('admin/report/grafik_line_surat_keluar');
        $this->load->view('templates/footer');
    }
}
