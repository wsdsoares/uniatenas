<style>
  .btn-enviar-form-contato {
    padding: 10px;
    color: #FFF !important;
    border: 1px solid #f4630b !important;
    border-radius: 10px !important;
  }

  .btn-enviar-form-contato:hover {
    border: 1px solid #f4630b !important;
    color: #000 !important;
  }
</style>

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
              <iframe class="embed-responsive-item" src="<?php echo $campus->mapsFrame ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="well well-sm">
              <h3><strong>Nossas informações</strong></h3>
            </div>
            <div class="row iconesFa">
              <?php
              if (isset($campus->street)) {
              ?>
                <div class="form-group">
                  <span><i class="fa fa-map-marker-alt"></i> <?php echo $campus->street; ?></span>
                </div>
              <?php
              }
              if (isset($campus->phone) and $campus->phone != null) {
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

              if (isset($campus->email)) {
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
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <div class="row">
          <p class="col-xs-12" style="display: flex; height: 200px; justify-content: center; align-items: center;">
            <button type="button" class="btn btn-primary btn-lg" style="border-radius: 10px;" data-toggle="modal" data-target="#<?php echo ID_RANDOMICO_FORM_CONTATO; ?>">
              Preencher formulário contato
            </button>
        </div>
        <div id="<?php echo ID_RANDOMICO_FORM_CONTATO; ?>" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Formulário de Contato</h4>
              </div>
              <div class="modal-body">


                <?php
                $atributos = array('role' => 'form');
                echo form_open("site/contato/$uricampus", $atributos);
                ?>
                <input type="hidden" name="sitekey" id="sitekey" value="<?php echo SITE_KEY; ?>">
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <div class="form-group">
                  <span>Nome</span>
                  <?php
                  echo form_input(array('name' => 'eman', 'class' => 'form-control', 'placeholder' => "Nome"), set_value('eman'));
                  ?>

                </div>
                <div class="form-group">
                  <span>Email</span>
                  <?php
                  echo form_input(array('name' => 'liame', 'type' => 'email', 'class' => 'form-control', 'placeholder' => "E-mail"), set_value('liame'));
                  ?>

                </div>
                <div class="form-group">
                  <span>Telefone</span>
                  <?php
                  echo form_input(array('name' => 'enohp', 'class' => 'form-control', 'placeholder' => "Telefone"), set_value('enohp'));
                  ?>
                </div>
                <div class="form-group">
                  <span>Mensagem</span>
                  <?php

                  echo form_textarea(array('name' => 'megasnem', 'class' => 'form-control', 'placeholder' => "Mensagem", 'pattern' => "[a-zA-Z0-9]+"), set_value('megasnem'));
                  ?>
                </div>

                <input type="submit" class="btn btn-enviar-form-contato" name="enviarForm" value="Enviar">
                <input type="hidden" name="hidden-input" id="hidden-input" value="@AAAAAHN54Lw#&">

                <?php
                echo form_close();
                ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>"></script>
<script>
  grecaptcha.ready(function() {

    // Recuperar a chave "SITE_KEY"
    var sitekey = document.getElementById('sitekey').value;

    // Enviar a SITE_KEY, o tipo de página "homepage", para o Google e obter o token
    grecaptcha.execute(sitekey, {
      action: 'submit'
    }).then(function(token) {

      // Enviar o token retornado pelo Google para o formulário
      document.getElementById('g-recaptcha-response').value = token;
    });
  });
</script>