<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>File Sharing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url() ?>public/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
	
	<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
	
    <link href="<?php echo base_url() ?>public/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">File Sharing</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="<?php echo base_url() ?>ikifilesharingom/panel_user">Home</a></li>
			  <li class="active"><a href="<?php echo base_url() ?>ikifilesharingom/logout">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Upload File</h3>
	  </div>
	  <div class="modal-body">
		<?php
			$form = array(
				'name' => 'form_upload',
				'method' => 'post',
				'class' => 'form-signin'
			);
		?>
		<?php //echo form_open_multipart('ikifilesharingom/aksi_tambah_file', $form); ?>
		<!-- <form action="proses_login.php" method="POST" class="form-signin"> -->
			<input type="file" name="fileku" required="required" /><br/>
			<select name="hak">
				<?php
					foreach($hak as $row) {
						$idha = $row->id_ha;
						$namahak = $row->nama;
				?>
						<option value="<?php echo $idha; ?>"><?php echo $namahak; ?></option>
				<?php
					}
				?>
			</select>
			<br/>
			<textarea name="keterangan" required="required" placeholder="Keterangan" ></textarea>
			<?php
				foreach($folder as $folderku) {
					$idfolder = $folderku->id_folder;
					$namafolder = $folderku->nama_folder;
				}
			?>
			<input type="hidden" value="<?php echo $namafolder ?>" name="namafolder" />
			<input type="hidden" value="<?php echo $idfolder ?>" name="idfolder" />
			<button class="btn btn-large btn-primary" data-loading-text="Loading..." type="submit">Upload</button>
		<?php //echo form_close(); ?>
	  </div>
	</div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <!-- Example row of columns -->
      <div class="hero-unit">
		<h3>File Saya</h3><br/><br/>
			<!-- <a href="#myModal" data-toggle="modal"><img src="<?php //echo base_url() ?>public/images/upload.png" width="40" height="40" title="Tambah Folder" />Upload</a><br/><br/> -->
			<table class="table table-striped" >
				<tr>
					<td><b>Nama File</b></td>
					<td><b>Size</b></td>
					<td><b>Tanggal</b></td>
					<td><b>Keterangan</b></td>
					<td><b>Hak Akses</b></td>
					<td><b>Aksi</b></td>
				</tr>
				<?php
					foreach($file as $barisfile) {
						$idfile = $barisfile->id_file;
						$namafile = $barisfile->nama_file;
						$size = $barisfile->size;
						$ukuran = $size / 1000;
						$tanggal = $barisfile->tanggal_upload;
						$ket = $barisfile->keterangan;
						$idhak = $barisfile->id_ha;
						$namahak = $barisfile->nama;
						$idfolder = $barisfile->id_folder;
						$namaf = $barisfile->nama_folder;
						$iduser = $barisfile->iduser;
						$username = $barisfile->username;
				?>
						<tr>
							<td><?php echo $namafile ?></td>
							<td><?php echo $ukuran ?> Mb</td>
							<td><?php echo $tanggal ?></td>
							<td><?php echo $ket ?></td>
							<td><?php echo $namahak ?></td>
							<td>
								<a href="<?php echo $url ?>ikifilesharingom/download_file/<?php echo $username ?>/<?php echo $namaf; ?>/<?php echo $namafile ?>" title="Download" ><img src="<?php echo $url ?>public/images/download.png" width="40" height="40" /></a>
							</td>
						</tr>
				<?php
					}
				?>
			</table>
	  </div>


      <footer>
        <p>Copyright &copy; ERA 2014</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url() ?>public/js/jquery.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-button.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-collapse.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrap-typeahead.js"></script>

  </body>
</html>
