<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class kowengawurog extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->helper(array('form', 'url', 'string', 'file','security','date'));
        $this->load->model('m_server','',TRUE);
        $this->load->library(array('session', 'upload'));
	}
	
	function index() {
		$this->load->view('kowengawurog/login');
	}
	
	function validasi_login_admin() {
		$username = $this->input->post('user');
		$pass = $this->input->post('pass');
		
		$cek = $this->m_server->get_login_admin($username, $pass);
		
		if($cek == true) {
			$this->session->set_userdata('id_admin', $username);
			redirect('kowengawurog/cpanel');
		} else {
			redirect('kowengawurog/index');
		}
	}
	
	function logout() {
		$this->session->set_userdata('id_admin', '');
		$this->session->sess_destroy();
		redirect('kowengawurog/index');
	}
	
	function cpanel() {
		if($this->session->userdata('id_admin') == '') {
			redirect('kowengawurog/index');
		} else {
			$this->load->view('kowengawurog/panel_admin');
		}
	}
	
	function get_hak_akses() {
		if($this->session->userdata('id_admin') == '') {
			redirect('kowengawurog/index');
		}
		
		$hak = $this->m_server->get_all_hak_akses();
		//$data['hak'] = $this->m_server->get_all_hak_akses();
		$data = array(
			'url' => base_url(),
			'hak' => $hak
		);
		
		$this->load->view('kowengawurog/hak_akses', $data);
	}
	
	function tambah_hak_akses() {
		if($this->session->userdata('id_admin') == '') {
			redirect('kowengawurog/index');
		}
		
		$this->load->view('kowengawurog/tambah_hak_akses');
	}
	
	function aksi_tambah_hak_akses() {
		$nama = $this->input->post('hak');
		
		$this->m_server->insert_hak_akses($nama);
		$this->session->set_flashdata('success', 'Hak Akses Berhasil Ditambahkan!');
		redirect('kowengawurog/get_hak_akses');
	}
	
	function hapus_hak_akses() {
		$id = $this->uri->segment('3');
		
		$this->m_server->delete_hak_akses($id);
		$this->session->set_flashdata('delete', 'Hak Akses Berhasil Dihapus!');
		redirect('kowengawurog/get_hak_akses');
	}
	
	function edit_hak_akses() {
		if($this->session->userdata('id_admin') == '') {
			redirect('kowengawurog/index');
		}
		
		$id = $this->uri->segment('3');
		
		$hak = $this->m_server->get_detail_hak_akses($id);
		
		$data = array(
			'url' => base_url(),
			'hak' => $hak
		);
		
		$this->load->view('kowengawurog/edit_hak_akses', $data);
	}
	
	function aksi_edit_hak_akses() {
		$nama = $this->input->post('hak');
		$id = $this->input->post('id');
		
		$this->m_server->update_hak_akses($nama, $id);
		$this->session->set_flashdata('update', 'Hak Akses Berhasil Diperbarui!');
		redirect('kowengawurog/get_hak_akses');
	}
	
	function get_user() {
		if($this->session->userdata('id_admin') == '') {
			redirect('kowengawurog/index');
		}
		
		$user = $this->m_server->get_all_user();
		
		$data = array(
			'url' => base_url(),
			'user' => $user
		);
		
		$this->load->view('kowengawurog/user', $data);
	}
	
	function hapus_user() {
		$id = $this->uri->segment('3');
		
		$this->m_server->delete_user($id);
		$this->session->set_flashdata('deleteuser', 'Username Berhasil Dihapus!');
		redirect('kowengawurog/get_user');
	}
}

?>