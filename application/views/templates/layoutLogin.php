<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $titulo; ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/vendors/iconfonts/puse-icons-feather/feather.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/login/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <?php
              if ($msg = get_msg()) :
                echo '<p>' . $msg . '</p>';
              endif;
              ?>
              <?php echo form_open('painel/login', 'role="form"'); ?>
              <div class="form-group">
                <label class="label">Usuário</label>
                <div class="input-group">
                  <?php
                  //echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Usuário'), set_value('user'), 'autofocus required autocomplete="off"');
                  echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Usuário'), set_value('user'), 'autofocus required');
                  ?>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="label">Senha</label>
                <div class="input-group">

                  <?php
                  echo form_password(array('name' => 'passwd', 'class' => 'form-control', 'placeholder' => '*******'), set_value('passwd', ''), 'required autocomplete="off"');
                  ?>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <?php echo form_submit(array('class' => 'btn btn-primary btn-block', 'value' => 'Acessar')); ?>
              </div>
              <div class="form-group d-flex justify-content-between">
                <a href="http://177.69.195.6:8080/portalatenas/usuarios/nova_senha" class="text-small forgot-password text-black">Esqueci Minha Senha</a>
              </div>
              <?php echo form_close(); ?>
            </div>

            <p class="footer-text text-center"><?php echo date('Y') ?></p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo base_url(); ?>assets/login/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url(); ?>assets/login/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>assets/login/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>assets/login/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>assets/login/js/misc.js"></script>
  <script src="<?php echo base_url(); ?>assets/login/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>assets/login/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>