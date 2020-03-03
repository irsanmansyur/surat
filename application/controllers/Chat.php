<?php
/**
 * 
 */
class Chat extends CI_Controller
{
	
	//function __construct(argument)
	//{
	//	# code...
	//}

	function index(){


		 
          $data['title'] = 'Chatting';
               $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
               $data['divisi']=$this->db->get('mst_divisi')->result();
  $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('user/pesan', $data);
        $this->load->view('templates/footer');

    }
    function save_chat(){
$divisi=$this->input->post('divisi');
$isi=$this->input->post('isi');
$data=[
'id_divisi'=>$divisi,
'pesan'=>$isi

];
$this->db->insert('tb_chat',$data);
if ($this->db->affected_rows() >0) {
    $query=$this->db
    ->join('mst_divisi','tb_chat.id_divisi=mst_divisi.id_divisi')
    ->get_where('tb_chat',['tb_chat.id_divisi'=>$divisi])->result();
   
    echo json_encode($query);

}
        
        }


        function get_chat(){

        	$divisi=$this->input->post('divisi');
        	$query=$this->db
        	->join('mst_divisi','tb_chat.id_divisi=mst_divisi.id_divisi')
        	->group_by('tb_chat.id_divisi')
        	->get_where('tb_chat',['tb_chat.id_divisi'=>$divisi])->result();
        	foreach ($query as $tampil) {
        		echo '<div class="chat_list"><div class="chat_people"><div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="chat_ib"><h5>'.$tampil->nama_divisi.' <span class="chat_date">Dec 25</span></h5><p>'.$tampil->pesan.'</p></div></div></div>';
        	}
        }
	
}










?>