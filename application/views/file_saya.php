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
		<h3 id="myModalLabel">Login</h3>
	  </div>
	  <div class="modal-body">
		<?php
			$form = array(
				'name' => 'form_login_user',
				'method' => 'post',
				'class' => 'form-signin'
			);
		?>
		<?php echo form_open('ikifilesharingom/validasi_login_user', $form); ?>
		<!-- <form action="proses_login.php" method="POST" class="form-signin"> -->
			<input type="text" name="user" class="input-block-level" placeholder="Username" required="required">
			<input type="password" name="pass" class="input-block-level" placeholder="Password" required="required">
			<button class="btn btn-large btn-primary" data-loading-text="Loading..." type="submit">Sign in</button>
		<?php echo form_close(); ?>
	  </div>
	</div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <!-- Example row of columns -->
	  <?php
			if($this->session->flashdata('success') != '') {
	  ?>
			    <center>
				<div class="row-fluid">
					<div class="span4 offset4 alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button><?php echo $this->session->flashdata('success') ?>
					</div>
				</div>
				</center>
	  <?php
			}
	  ?>
	  
	  <?php
			if($this->session->flashdata('delete') != '') {
	  ?>
			    <center>
				<div class="row-fluid">
					<div class="span4 offset4 alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button><?php echo $this->session->flashdata('delete') ?>
					</div>
				</div>
				</center>
	  <?php
			}
	  ?>
	  
	  <?php
			if($this->session->flashdata('share') != '') {
	  ?>
			    <center>
				<div class="row-fluid">
					<div class="span4 offset4 alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button><?php echo $this->session->flashdata('share') ?>
					</div>
				</div>
				</center>
	  <?php
			}
	  ?>
      <div class="hero-unit">
		<h3>File Saya</h3><br/><br/>
			<a href="<?php echo base_url(); ?>ikifilesharingom/tambah_folder"><img src="<?php echo base_url() ?>public/images/add.png" title="Tambah Folder" />Tambah Folder</a><br/><br/>
			<table class="table table-striped" >
				<tr>
					<td><b>Nama Folder</b></td>
					<td><b>Hak Akses</b></td>
					<td><b>Aksi</b></td>
				</tr>
					<?php
						foreach($folder as $row) {
							$idha = $row->id_ha;
							$namaha = $row->nama;
							$namaf = $row->nama_folder;
							$idf = $row->id_folder;
					?>
							<tr>
								<td><a href="<?php echo base_url() ?>ikifilesharingom/isi_folder/<?php echo $idf ?>" title=""><?php echo $namaf; ?></a></td>
								<td><?php echo $namaha; ?></td>
								<td>
									<a href="<?php echo $url ?>ikifilesharingom/share_folder/<?php echo $idf ?>" title="Share" ><img src="<?php echo $url ?>public/images/share.png" width="40" height="40" /></a>
									<a href="<?php echo base_url() ?>ikifilesharingom/hapus_folder/<?php echo $idf ?>" title="Delete" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus?');" ><img src="<?php echo base_url() ?>public/images/delete.png" width="40" height="40" /></a>
								</td>
							</tr>
					<?php
						}
					?>
				
			</table>
			<br/>
			<h4>Shared Folder</h4>
			<table class="table table-striped" >
				<tr>
					<td><b>Nama Folder</b></td>
				</tr>
					<?php
						foreach($sfolder as $row1) {
							$namaf = $row1->nama_folder;
							$idf = $row1->id_folder;
					?>
							<tr>
								<td><a href="<?php echo base_url() ?>ikifilesharingom/isi_folder_shared/<?php echo $idf ?>" title=""><?php echo $namaf; ?></a></td>
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
