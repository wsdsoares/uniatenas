<s?php $conteudosPagina=$dados['conteudosPagina'] !="" ? $dados['conteudosPagina'] : '' ; echo '<pre>' ;
  print_r($conteudosPagina); echo '</pre>' ; ?>
  <div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
  </div>
  <!-- Input -->
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            <?php
            echo $page;
            ?>
          </h2>
        </div>
        <div class="body">
          <?php
          if ($msg = getMsg()):
            echo $msg;
          endif;
          ?>
          <?php
          echo form_open_multipart("Painel_espacos_eventos/cadastrar_item_pagina_eventos/$campus->id/$pagina->id") ?>
          <h2 class="card-inside-title">Informações</h2>
          <div class="row clearfix">
            <div class="col-sm-6">
              <div class="form-group">
                <div class="form-line">
                  <label for="title">Título *</label>
                  <?php
                  $titulo = isset($conteudosPagina->title) ? $conteudosPagina->title : '';
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title', $titulo));
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <label for="title">Link do Vídeo <small> (Para que o vídeo seja exibido, o mesmo deverá estar, a priori,
                  hospedado no youtube) <br> Exemplo: https://www.youtube.com/watch?v=<strong
                    style="background-color:red">emlEe5O5-Sc</strong><br />
                  Deve ser informado o código do vídeo: <span style="color:red"> emlEe5O5-Sc </span>
                </small>
              </label>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">input</i>
                </span>
                <div class="form-line">
                  <?php
                  $linkRedir = isset($conteudosPagina->link_redir) ? $conteudosPagina->link_redir : '';
                  echo form_input(array('name' => 'link_redir', 'class' => 'form-control', 'placeholder' => 'Link Completo do video'), set_value('link_redir', $linkRedir));
                  ?>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="separacao-forms"></div>
          </div>
          <div class="row clearfix">

            <div class="col-sm-12">
              <label for="title">Descrição do item do financeiro
                <small> (Explicação e inforamções pertinentes ao item do financeiro)</small>
              </label>
              <?php
              $descricao = isset($conteudosPagina->description) ? $conteudosPagina->description : '';
              echo form_textarea('description', to_html(set_value('description', $descricao)));
              ?>
            </div>
            <script type="text/javascript">
            // replace: substitui o formato padrão do textarea (descricao)
            // e aplica as configurações do CKEDitor através do arquivo config.js
            var editor = CKEDITOR.replace('description', {
              customConfig: 'config.js'
            });
            </script>
          </div>
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
                  $status = isset($conteudosPagina->status) ? $conteudosPagina->status : '0';
                  echo form_dropdown('status', $optionSituation, set_value('status', $status), array('class' => 'form-control show-tick'));
                  ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-sm-6">
              <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
              echo anchor("Painel_espacos_eventos/lista_informacoes_espacos_eventos/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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
  </div>