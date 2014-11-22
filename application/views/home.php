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
              <li class="active">
				<a href="#">Home</a>
			  </li>
			  <li>
				<a href="#myModal" data-toggle="modal" class="navbar-link">Sign In</a>
			  </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Login Member</h3>
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
			if($this->session->flashdata('failed') != '') {
	  ?>
			    <center>
				<div class="row-fluid">
					<div class="span4 offset4 alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><?php echo $this->session->flashdata('failed') ?>
					</div>
				</div>
				</center>
	  <?php
			}
	  ?>
	  
	  <?php
			if($this->session->flashdata('ada') != '') {
	  ?>
			    <center>
				<div class="row-fluid">
					<div class="span4 offset4 alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><?php echo $this->session->flashdata('ada') ?>
					</div>
				</div>
				</center>
	  <?php
			}
	  ?>
	  <br/><br/><br/>
      <div class="container-fluid">
		  <div class="row-fluid">
			<div class="span6">
			  <!--Sidebar content-->
			  <div class="hero-unit">
				<img src="<?php echo base_url() ?>public/images/kudafilesharing.png" />
			  </div>
			</div>
			<div class="span6">
			  <!--Body content-->
			  <div class="hero-unit">
				<h3>Daftar Member</h3>
				<br/>
				<?php
					$form = array(
						'name' => 'form_tambah_user',
						'method' => 'post',
						'class' => 'form-signin'
					);
				?>
				<?php echo form_open('ikifilesharingom/aksi_tambah_user', $form); ?>
				<!--<form action="proses_login.php" method="POST" class="form-signin"> -->
					<input type="text" name="nama" class="input-block-level" placeholder="Full Name" required="required">
					<input type="text" name="user" class="input-block-level" placeholder="Username" required="required">
					<input type="password" name="pass" class="input-block-level" placeholder="Password" required="required">
					<button class="btn btn-large btn-success" name="submit" data-loading-text="Loading..." type="submit">Sign Up</button>
				<?php echo form_close(); ?>
			  </div>
			</div>
		  </div>
	  </div>

      <!-- Example row of columns -->
      

      <hr>

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
