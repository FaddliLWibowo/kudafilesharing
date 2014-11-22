<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ikifilesharingom extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->helper(array('form', 'url', 'string', 'file','security','date', 'download'));
        $this->load->model('m_user','',TRUE);
        $this->load->library(array('session', 'upload'));
	}
	
	function index() {
		$this->load->view('home');
	}
	
	function aksi_tambah_user() {
		$nama = $this->input->post('nama');
		$username = $this->input->post('user');
		$pass = $this->input->post('pass');
		$cek = $this->m_user->cek_user($username);
		
		if($cek == true) {
			$this->session->set_flashdata('ada', 'Username Sudah Terdaftar!');
			redirect('ikifilesharingom/index');
		} else {
			$this->m_user->tambah_user($nama, $username, $pass);
			$this->session->set_flashdata('success', 'Register Success!!');
			redirect('ikifilesharingom/index');
		}
	}
	
	function validasi_login_user() {
		$username = $this->input->post('user');
		$pass = $this->input->post('pass');
		
		$login = $this->m_user->get_login_user($username, $pass);
		
		if($login == true) {
			$this->session->set_userdata('id_user', $username);
			redirect('ikifilesharingom/panel_user');
		} else {
			$this->session->set_flashdata('failed', 'Kombinasi Username & Password Salah!');
			redirect('ikifilesharingom/index');
		}
	}
	
	function panel_user() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		} else {
			$username = $this->session->userdata('id_user');
			$user = $this->m_user->get_id_user($username);
			
			$data = array(
				'url' => base_url(),
				'user' => $user
			);
			
			$this->load->view('panel_user', $data);
		}
	}
	
	function logout() {
		$this->session->set_userdata('id_user', '');
		$this->session->sess_destroy();
		
		redirect('ikifilesharingom/index');
	}
	
	function file_saya() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		}
		
		$user = $this->session->userdata('id_user');
		$userdata = $this->m_user->get_user_by_username($user);
		$iduser = $userdata->iduser;
		$folder = $this->m_user->get_folder_user($user);
		$sfolder = $this->m_user->get_shared_folder($iduser);
		
		$data = array(
			'url' => base_url(),
			'folder' => $folder,
			'sfolder' => $sfolder
		);
		
		//$folder = $this->m_user->
		$this->load->view('file_saya', $data);
	}
	
	function tambah_folder() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		}
		
		$username = $this->session->userdata('id_user');
		
		$hak = $this->m_user->get_all_hak_akses();
		$user = $this->m_user->get_id_user($username);
		
		$data = array(
			'url' => base_url(),
			'hak' => $hak,
			'user' => $user
		);
		
		$this->load->view('tambah_folder', $data);
	}
	
	function aksi_tambah_folder() {
		$nama = $this->input->post('folder');
		$hak = $this->input->post('hak');
		$idu = $this->input->post('iduser');
		$namau = $this->input->post('namauser');
		
		$this->m_user->insert_folder($nama, $hak, $idu, $namau);
		$this->session->set_flashdata('success', 'Folder Berhasil Ditambahkan!');
		redirect('ikifilesharingom/file_saya');
	}
	
	function hapus_folder() {
		$idfolder = $this->uri->segment('3');
		$this->m_user->delete_folder($idfolder);
		
		$this->session->set_flashdata('delete', 'Folder Berhasil Dihapus!');
		redirect('ikifilesharingom/file_saya');
		//print_r(error_get_last());
	}
	
	function isi_folder() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		}
		
		$id = $this->uri->segment('3');
		$hak = $this->m_user->get_all_hak_akses();
		$folder = $this->m_user->get_nama_folder($id);
		$file = $this->m_user->get_file_folder($id);
		
		$data = array(
			'url' => base_url(),
			'hak' => $hak,
			'file' => $file,
			'folder' => $folder
		);
		
		$this->load->view('isi_folder', $data);
	}
	
	function isi_folder_shared() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		}
		
		$id = $this->uri->segment('3');
		$hak = $this->m_user->get_all_hak_akses();
		$folder = $this->m_user->get_nama_folder($id);
		$file = $this->m_user->get_file_folder($id);
		
		$data = array(
			'url' => base_url(),
			'hak' => $hak,
			'file' => $file,
			'folder' => $folder
		);
		
		$this->load->view('isi_folder_shared', $data);
	}
	
	function aksi_tambah_file() {
        $nama = $_FILES['fileku']['name'];
        $hak =  $this->input->post('hak');
		$ket = $this->input->post('keterangan');
		$namaf = $this->input->post('namafolder');
		$idf = $this->input->post('idfolder');
		$username = $this->session->userdata('id_user');
		$tanggal = date('Y-m-d');
		
        if($this->m_user->cek_file($nama) == false){
            redirect('');
        }
        
        $config['upload_path'] = "./public/FSData/$username/$namaf/";
        $config['allowed_types'] = '*';
		$config['max_size']	= '';
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = false;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('fileku')) {
            //redirect('ikifilesharingom/file_saya');
			echo $this->upload->display_errors();
        } else {
            $file = $this->upload->data();
            $nama = $file['file_name'];
            $size = $file['file_size'];
            $this->m_user->insert_file($nama,$size,$tanggal,$ket,$hak,$idf);
			$this->session->set_flashdata('success', 'File Berhasil Diupload!');
			redirect("ikifilesharingom/isi_folder/$idf");
        }
    }
	
	function download_file() {
		$user = $this->uri->segment('3');
		$folder = $this->uri->segment('4');
		$nama = $this->uri->segment('5');
		
		$data = file_get_contents(base_url()."public/FSData/$user/$folder/$nama"); // Read the file's contents
		$name = $nama;

		force_download($name, $data);
	}
	
	function aksi_hapus_file() {
		$id = $this->uri->segment('3');
		$idf = $this->uri->segment('4');
		$iduser = $this->uri->segment('5');
		$file = $this->uri->segment('6');
		
		//echo $file1;
		$this->m_user->delete_file($id,$idf,$iduser,$file);
		//print_r(error_get_last());
		$this->session->set_flashdata('delete', 'File Berhasil Dihapus!');
		redirect("ikifilesharingom/isi_folder/$idf");
	}
	/*
	function share_file() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		} 
		
		$idfile = $this->uri->segment('3');
		$username = $this->uri->segment('4');
		$namafolder = $this->uri->segment('5');
		
		$data = array(
			'idf' => $idfile,
			'user' => $username,
			'namaf' => $namafolder
		);
		
		$this->load->view('share_file', $data);
	}
	
	function aksi_share_file() {
		$username = $this->input->post('username');
		$idfile = $this->input->post('idfile');
		$user = $this->input->post('user');
		$namafolder = $this->input->post('namafolder');
		$file = $this->m_user->get_file_by_id($idfile);
		$user1 = $this->session->userdata('id_user');
		
		if($file->id_ha==1) {
			$this->m_user->insert_share_file($username, $idfile, $user, $namafolder);
			redirect('ikifilesharingom/file_saya');
			//print_r(error_get_last());
		} else {
			redirect('ikifilesharingom/file_saya');
		}
	}
	*/
	
	function share_folder() {
		if($this->session->userdata('id_user') == '') {
			redirect('ikifilesharingom/index');
		} 
		
		$idfolder = $this->uri->segment('3');
		$username = $this->session->userdata('id_user');
		
		$data = array(
			'idf' => $idfolder,
			'user' => $username
		);
		
		$this->load->view('share_folder', $data);
	}
	
	function aksi_share_folder() {
		$username = $this->input->post('username');
		$idfolder = $this->input->post('idfolder');
		$user = $this->input->post('user');
		$folder = $this->m_user->get_folder_by_id($idfolder);
		
		if($folder->id_ha==1) {
			$this->m_user->insert_share_folder($username, $idfolder, $user);
			$this->session->set_flashdata('share', 'Folder Berhasil Dibagikan!');
			redirect('ikifilesharingom/file_saya');
			//print_r(error_get_last());
		} else {
			redirect('ikifilesharingom/file_saya');
		}
	}
}

?>