<?php

class m_user extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function cek_user($username) {
		$this->db->where('username', $username);
		$ada = $this->db->get('data_user');
		
		if($ada->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function tambah_user($nama, $username, $pass) {
		$this->db->set('namauser', $nama);
		$this->db->set('username', $username);
		$this->db->set('password', $pass);
		$this->db->insert('data_user');
		
		$folder = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData';
		
		mkdir($folder. "/$username");
	}
	
	function get_id_user($username) {
		$this->db->where('username', $username);
		
		$query = $this->db->get('data_user');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	function get_user_by_id($id) {
		$this->db->where('iduser', $id);
		$query = $this->db->get('data_user');
		
		return $query->row();
	}
	
	function get_user_by_username($username) {
		$this->db->where('username', $username);
		$query = $this->db->get('data_user');
		
		return $query->row();
	}
	
	function get_login_user($username, $pass) {
		$this->db->where('username', $username);
		$this->db->where('password', $pass);
		
		$query = $this->db->get('data_user');
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_all_hak_akses() {
		$query = $this->db->get('data_hakakses');
		return $query->result();
	}
	
	function insert_folder($nama, $hak, $idu, $namau) {
		$this->db->set('nama_folder', $nama);
		$this->db->set('id_ha', $hak);
		$this->db->set('iduser', $idu);
		$this->db->insert('folder');
		
		$dir = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData/'.$namau;
		$buatfolder = $dir."/$nama";
		@mkdir($buatfolder);
	}
	
	function get_folder_user($user) {
		$username = $this->get_user_by_username($user);
		$iduser = $username->iduser;
		
		$this->db->select('*');
		$this->db->from('folder');
		$this->db->join('data_user', 'data_user.iduser = folder.iduser');
		$this->db->join('data_hakakses', 'data_hakakses.id_ha = folder.id_ha');
		$this->db->where('data_user.username', $user);
		$this->db->where('folder.nama_folder !=', 'share');
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_shared_folder($iduser) {
		$this->db->from('share_folder');
		$this->db->join('folder', 'folder.id_folder = share_folder.id_folder');
		$this->db->where('share_folder.iduser', $iduser);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_detail_folder($id) {
		$this->db->select('*');
		$this->db->from('folder');
		$this->db->where('nama_folder', $id);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	function get_nama_folder($id) {
		$this->db->select('*');
		$this->db->from('folder');
		$this->db->where('id_folder', $id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_folder_by_id($id) {
		$this->db->where('id_folder', $id);
		$query = $this->db->get('folder');
		
		return $query->row();
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

	function delete_folder($idfolder) {
		$dir = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData';
		$folder = $this->get_folder_by_id($idfolder);
		$namafolder = $folder->nama_folder;
		$username = $this->session->userdata('id_user');
		$sfolder = $this->get_folder_shared($idfolder);
		
		$data = array(
			'sfolder1' => $sfolder
		);
		
		$this->rrmdir($dir."/$username/$namafolder");
		
		foreach($sfolder as $baris) {
			$username1 = $baris->username;
			$this->rrmdir($dir."/$username1/$namafolder");
		}
		
		$this->db->where('id_folder', $idfolder);
		$this->db->delete('folder');
		
		$this->db->where('id_folder', $idfolder);
		$this->db->delete('data_file');
		
		$this->db->where('id_folder', $idfolder);
		$this->db->delete('share_folder');
	}
	
	function get_folder_shared($idfolder) {
		$this->db->from('share_folder');
		$this->db->join('data_user', 'data_user.iduser = share_folder.iduser');
		$this->db->where('id_folder', $idfolder);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_file_folder($id) {
		/*
		$this->db->where('id_folder', $id);
		$this->db->join('data_hakakses', 'data_hakakses.id_ha = data_file.id_ha');
		$this->db->order_by('nama_file', 'asc');
		$query = $this->db->get('data_file');
		*/
		
		$query = $this->db->query("SELECT * FROM data_file AS df
							INNER JOIN data_hakakses AS dh ON dh.id_ha = df.id_ha
							INNER JOIN folder AS f ON f.id_folder = df.id_folder
							INNER JOIN data_user AS du ON du.iduser = f.iduser
							WHERE df.id_folder = '$id'");
		
		
		return $query->result();
	}
	
	function get_file_folder_shared($id) {
		$query = $this->db->query("SELECT * FROM data_file AS df
							INNER JOIN data_hakakses AS dh ON dh.id_ha = df.id_ha
							INNER JOIN folder AS f ON f.id_folder = df.id_folder
							INNER JOIN data_user AS du ON du.iduser = f.iduser
							INNER JOIN share AS sh ON sh.id_file = df.id_file
							WHERE df.id_folder = '$id'");
		
		
		return $query->result();
	}
	
	function get_file_by_id($id) {
		$this->db->where('id_file', $id);
		$query = $this->db->get('data_file');
		
		return $query->row();
	}
	
	function cek_file($nama) {
        $this->db->where('nama_file',$nama);
        $query = $this->db->get('data_file');
        if($query->num_rows() > 0) return false; else return true;
    }
	
	function insert_file($nama,$size,$tanggal,$ket,$hak,$idf) {
		$this->db->set('nama_file', $nama);
		$this->db->set('size', $size);
		$this->db->set('tanggal_upload', $tanggal);
		$this->db->set('keterangan', $ket);
		$this->db->set('id_ha', $hak);
		$this->db->set('id_folder', $idf);
		$this->db->insert('data_file');
	}
	
	function delete_file($id,$idfolder,$iduser,$file) {
		$this->db->where('id_file', $id);
		$this->db->delete('data_file');
		
		$user = $this->get_user_by_id($iduser);
		$folder = $this->get_folder_by_id($idfolder);
		$file1 = str_replace("%20", " ", $file);
		
		//unlink($_SERVER['DOCUMENT_ROOT']."/filesharingfix/public/FSData/$user->username/$folder->nama_folder/$file");
		unlink("./public/FSData/$user->username/$folder->nama_folder/$file1");
	}
	
	/*
	function cek_folder_share($iduser) {
		$this->db->where('iduser', $iduser);
		$this->db->where('nama_folder', 'share');
		$query = $this->db->get('folder');
		
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function insert_share_file($username, $idfile, $user, $namafolder) {
		$userdata = $this->get_user_by_username($username);
		$iduser = $userdata->iduser;
		$cek = $this->cek_folder_share($iduser);
		$file = $this->get_file_by_id($idfile);
		$namafile = $file->nama_file;
		
		if($cek == false) {
			$this->db->set('id_file', $idfile);
			$this->db->set('iduser', $iduser);
			$this->db->insert('share');
			
			$this->db->set('nama_folder', 'share');
			$this->db->set('id_ha', 1);
			$this->db->set('iduser', $iduser);
			$this->db->insert('folder');
			
			$folder = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData';
			mkdir($folder."/$username/share");
			copy($folder."/$user/$namafolder/$namafile", $folder."/$username/share/$namafile");
		} else {
			$this->db->set('id_file', $idfile);
			$this->db->set('iduser', $iduser);
			$this->db->insert('share');
			
			$folder = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData';
			copy($folder."/$user/$namafolder/$namafile", $folder."/$username/share/$namafile");
		}
	}
	*/
	
	function cek_shared_folder($idfolder, $user) {
		$this->db->where('id_folder', $idfolder);
		$this->db->where('iduser', $user);
		$query = $this->db->get('share_folder');
		
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function recurse_copy($src,$dst) { 
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if ( is_dir($src . '/' . $file) ) { 
					$this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
				} 
				else { 
					copy($src . '/' . $file,$dst . '/' . $file); 
				} 
			} 
		} 
		closedir($dir); 
	} 
	
	function insert_share_folder($username, $idfolder, $user) {
		$userdata = $this->get_user_by_username($username);
		$iduser = $userdata->iduser;
		$cek = $this->cek_shared_folder($idfolder, $iduser);
		$folder = $this->get_folder_by_id($idfolder);
		$namafolder = $folder->nama_folder;
		
		if($cek == false) {
			$this->db->set('id_folder', $idfolder);
			$this->db->set('iduser', $iduser);
			$this->db->insert('share_folder');
			
			$folder = $_SERVER['DOCUMENT_ROOT'].'/filesharingfix/public/FSData';
			$this->recurse_copy($folder."/$user/$namafolder", $folder."/$username/$namafolder");
		}
	}
}

?>