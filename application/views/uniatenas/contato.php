<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
$uricampus = $this->uri->segment(3);
?>

<section id="contact">
  <div class="container">

    <div class="section-header">
      <h4>Contato do <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h4>
    </div>

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="row">
          <div class="col-xs-9">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="<?php echo $campus->mapsFrame ?>" frameborder="0"
                style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="well well-sm">
              <h3><strong>Nossas informações</strong></h3>
            </div>
            <div class="row iconesFa">
              <?php 
                if(isset($campus->street)){
              ?>
              <div class="form-group">
                <span><i class="fa fa-map-marker-alt"></i> <?php echo $campus->street; ?></span>
              </div>
              <?php 
                }
                if(isset($campus->phone) and $campus->phone != null){
                ?>
              <div class="form-group">
                <span><i class="fas fa-phone-volume"></i>
                  <?php
                      echo $campus->phone;
                      ?>
                </span>
              </div>
              <?php
              }
            
            if(isset($campus->email)){
            ?>
              <div class="form-group">
                <span><i class="fas fa-envelope"></i>
                  <?php echo $campus->email; ?>
                  <?php
                                  if ($campus->id == 1) {
                                      ?>
                  <br>
                  <span><i class="fas fa-envelope"></i>
                    <?php
                                        echo "ouvidoria@atenas.edu.br";
                                        ?>
                  </span>
                  <?php
                        }

                        ?>
              </div>
              <?php
            }
            ?>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12">
        <?php
          if ($msg = getMsg()){
            echo $msg;
          }
          ?>

        <?php
          echo form_open("Site/contato/$uricampus");
          ?>
        <div class="form-group">
          <span>Nome</span>
          <?php
            echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => "Nome"), set_value('name'));
            ?>

        </div>
        <div class="form-group">
          <span>Email</span>
          <?php
            echo form_input(array('name' => 'email', 'type' => 'email', 'class' => 'form-control', 'placeholder' => "E-mail"), set_value('email'));
            ?>

        </div>
        <div class="form-group">
          <span>Telefone</span>
          <?php
          echo form_input(array('name' => 'phone', 'class' => 'form-control', 'placeholder' => "Telefone"), set_value('phone'));
          ?>
        </div>
        <div class="form-group">
          <span>Mensagem</span>
          <?php
          echo form_textarea(array('name' => 'message', 'class' => 'form-control', 'placeholder' => "Mensagem"), set_value('message'));
          ?>
        </div>
        <?php $key = "6Lc1NxEmAAAAAHN54LwwjpRzBWsM3dPEyXh22xJI";?>
        <div class="g-recaptcha" data-sitekey="<?php echo $key?>"></div>
        <input type="submit" class="btn btn-default" name="enviarForm" value="Enviar"
          onclick="return validaFormularioRecaptcha()">
        <?php
        echo form_close();
        ?>
      </div>
    </div>

  </div>
</section>
<script type="text/javascript">
function validaFormularioRecaptcha() {
  if (grecaptcha.getResponse() == "") {
      return false;
  }
}
</script>