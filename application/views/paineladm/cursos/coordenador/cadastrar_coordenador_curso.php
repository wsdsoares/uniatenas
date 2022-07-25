<?php
$coordenadorName = !empty($coordenador->nome) ? $coordenador->nome : '';
$coordenadorEmail = !empty($coordenador->email) ? $coordenador->email : '';
$coordenadorCargo = !empty($coordenador->cargo) ? $coordenador->cargo : '';
$coordenadorStatus = !empty($coordenador->status) ? $coordenador->status : '';
$coordenadorTelefone = !empty($coordenador->telefone) ? $coordenador->telefone : '';
?>
<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>

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
        <?php echo form_open("Painel_graduacao/cadastrar_coordenador_curso/$cursoPorCampus/$campus->id/$modalidade") ?>

        <h2 class="card-inside-title">Informações do Dirigentes</h2>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Email</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">people</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Nome completo'), set_value('nome',$coordenadorName));
                ?>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="title">Email</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mail</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email'), set_value('email',$coordenadorEmail));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Telefone(s)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">phone</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'telefone', 'class' => 'form-control', 'placeholder' => 'Ex.: 38 9.9999-7799/ 38 9878-7878'), set_value('telefone',$coordenadorTelefone));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="title">Cargo</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">assignment_ind</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Ex.: Coordenador de Curso'), set_value('cargo',$coordenadorCargo));
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
                    echo form_dropdown('status', $optionSituation, set_value('status',$coordenadorStatus), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <style>

        </style>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_graduacao/lista_cursos/$campus->id/$modalidade", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
            
            ?>
          </div>
          <div class="col-sm-6">
            <?php
              if (!empty($coordenadorName)){
                echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $coordenadorName . '" data-id="' . $coordenador->id . '" class="btn btn-danger">'
                  . '<i class="material-icons">delete_sweep</i> Deletar'
                  . '</a>';
             }
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

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Você tem certeza?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Você tem certeza que deseja realizar essa ação de deletar o item abaixo?</p>
        <p>Essa ação é <span class="text-danger" style="font-weight: bold">IRREVERSÍVEL</span> e todos os dados
          ligados a esse item serão removidos <span class="text-danger"
            style="font-weight: bold">PERMANENTEMENTE</span>.
        </p>
        <p>O item selecionado é: <span class="text-info nomeItem" style="font-weight: bold"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <a id="btnCerteza" class="btn btn-danger" href="">Sim, tenho certeza!</a>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/elementsPainel/footers/footerDelete'); ?>

<script type="text/javascript">
$('#modalDelete').on('show.bs.modal', function(e) {
  var nomeItem = $(e.relatedTarget).attr('data-nome');
  var id = $(e.relatedTarget).attr('data-id');

  $(this).find('.nomeItem').text(nomeItem);
  $(this).find('#btnCerteza').attr('href',
    '<?php echo base_url("Painel_graduacao/deletar_coordenador_curso/$campus->id/$modalidade/"); ?>' + id);

});
</script>