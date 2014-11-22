<?php

class m_server extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function get_login_admin($username, $pass) {
		$this->db->where('username', $username);
		$this->db->where('password', $pass);
		
		$query = $this->db->get('data_admin');
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function insert_hak_akses($nama) {
		$this->db->set('nama', $nama);
		$this->db->insert('data_hakakses');
	}
	
	function get_all_hak_akses() {
		$query = $this->db->get('data_hakakses');
		return $query->result();
	}
	
	function get_detail_hak_akses($id) {
		$this->db->from('data_hakakses');
		$this->db->where('id_ha', $id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function delete_hak_akses($id) {
		$this->db->where('id_ha', $id);
		$this->db->delete('data_hakakses');
	}
	
	function update_hak_akses($nama, $id) {
		$this->db->set('nama', $nama);
		$this->db->where('id_ha', $id);
		$this->db->update('data_hakakses');
	}
	
	function get_all_user() {
		$query = $this->db->get('data_user');
		return $query->result();
	}
	
	function get_user_by_id($id) {
		$this->db->where('iduser', $id);
		$query = $this->db->get('data_user');
		
		return $query->row();
	}
	
	function get_folder_user_by_id($id) {
		$this->db->from('data_user');
		$this->db->join('folder', 'folder.iduser = data_user.iduser');
		$this->db->where('data_user.iduser', $id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_file_user_by_id($id) {
		$this->db->from('data_user');
		$this->db->join('folder', 'folder.iduser = data_user.iduser');
		$this->db->join('data_file', 'data_file.id_folder = folder.id_folder');
		$this->db->where('data_user.iduser', $id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function delete_user($id) {
		$user = $this->get_user_by_id($id);
		$username = $user->username;
		$file = $this->get_file_user_by_id($id);
		$folder = $this->get_folder_user_by_id($id);
		$datauser = $this->get_all_user();
		$dir = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData';
		
		$this->rrmdir($dir."/$username/");
		
		foreach($datauser as $baris2) {
			$username1 = $datauser->username;
			
			foreach($folder as $baris1) {
				$idfolder = $folder->id_folder;
				$namafolder = $folder->nama_folder;
				
				$this->rrmdir($dir."/$username1/$namafolder");
				
				$this->db->where('id_folder', $idfolder);
				$this->db->delete('share_folder');
			}
		}
		
		foreach($file as $baris) {
			$idfile = $baris->id_file;
			
			$this->db->where('id_file', $idfile);
			$this->db->delete('data_file');
		}
		
		$this->db->where('iduser', $id);
		$this->db->delete('data_user');
		
		$this->db->where('iduser', $id);
		$this->db->delete('folder');
	}
	
	function rrmdir($dir) { 
		if (is_dir($dir)) { 
			$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") { 
					if (filetype($dir."/".$object) == "dir")
						rrmdir($dir."/".$object);
					else 
						unlink($dir."/".$object); 
				} 
			} 
			reset($objects); 
			rmdir($dir); 
		}
	} 
}	

?>