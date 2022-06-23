<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()){
            echo $msg;
        }
        ?>
        <?php echo form_open("Painel_geral/editar_dados_integracao_whatsapp/$campus->id/$dadosIntegracaoWhatsapp->id") ?>

        <h2 class="card-inside-title">Informações/ Itens e Configurações de informações exibidas no botão do Whatsapp da
          página inicial </h2>
        <div class="row clearfix">
          <div class="col-md-3">
            <label for="title">Titulo Breve do Botão</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'titulo_botao', 'class' => 'form-control', 'placeholder' => 'Titulo do botão', 'maxlength'=>25), set_value('titulo_botao',$dadosIntegracaoWhatsapp->titulo_botao));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <label for="title">Número do Whatsapp <small> (Recebedor das mensagens)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">phone</i>
              </span>

              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'numero_whatsapp', 'class' => 'form-control', 'placeholder' => 'Número do telefone. Ex.: 5538999999999'), set_value('numero_whatsapp',$dadosIntegracaoWhatsapp->numero_whatsapp));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-5">
            <label for="title">Tempo do efeito <small> (movimento do botão)<br />(Número em segundos)<br />Padrão
                40</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">access_alarm</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'tempo_interacao_segundos', 'class' => 'form-control', 'placeholder' => 'Tempo em SEGUNDOS', 'type'=>'number'), set_value('tempo_interacao_segundos',$dadosIntegracaoWhatsapp->tempo_interacao_segundos));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-12">
            <label for="title">Texto padrão da mensagem <br /><br /><i>(Mensagem padrão que será exibida)</i> <br />
              Ex.: Olá, estou entrando em contato pois estou interessado em um de seus cursos. Poderia me dar mais
              informacções?</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'texto_padrao_mensagem', 'class' => 'form-control', 'placeholder' => 'Texto da mensagem inicial'), set_value('texto_padrao_mensagem',$dadosIntegracaoWhatsapp->texto_padrao_mensagem));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                    $optionSituation = array(
                        '1' => 'Visível - Ativo',
                        '0' => 'Oculto - Inativo'
                    );
                    echo form_dropdown('status', $optionSituation, set_value('status',$dadosIntegracaoWhatsapp->status), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_geral/lista_dados_integracao_whatsapp/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

              ?>
          </div>
        </div>

        <?php
        echo form_close();
        ?>
      </div>
    </div>
  </div>
</div>