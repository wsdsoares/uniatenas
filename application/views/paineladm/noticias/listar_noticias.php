<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">

      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="col-xs-6">
            <?php
            echo anchor("Painel_noticias/cadastrar_noticias/$campus->id", '<i class="material-icons">add_box</i> CADASTRAR Notícias', array('class' => 'btn btn-primary m-t-15 waves-effect'));
            ?>
          </div>
          <div class="col-xs-6">
            <?php
            echo anchor("Painel_noticias/lista_campus_noticias",'<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));
            ?>
          </div>
        </div>
      </div>


      <div class="body">
        <?php
        if ($msg = getMsg()){
            echo $msg;
        }
        ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>Código</th>
                <th>Capa</th>
                <th>Titulo</th>
                <th>Campus - Cidade</th>
                <th>Fotos</th>
                <th>Autor</th>
                <th>Modificado em</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>Código</th>
                <th>Capa</th>
                <th>Titulo</th>
                <th>Campus - Cidade</th>
                <th>Fotos</th>
                <th>Autor</th>
                <th>Modificado em</th>
              </tr>
            </tfoot>
            <tbody>
              <?php

                foreach ($lista as $noticia) {
                ?>
              <tr>
                <td class="center">
                  <?php
                    echo anchor("Painel_noticias/editar_noticia/$campus->id/$noticia->id", '<i class="material-icons">edit</i>');

                    echo anchor("site/ver_noticia/$campus->shurtName/$noticia->id", '<i class="material-icons">search</i>', array('title' => "Ver noticia", "target" => "_blank"));
                    echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $noticia->title . '" data-id="' . $noticia->id . '" >'
                        . '<i class="material-icons">delete</i>'
                        . '</a>';
                    ?>
                </td>
                <td><?php echo $noticia->id; ?></td>
                <td>
                  <?php
                    echo anchor(base_url(verifyImg($noticia->img_destaque)), '<img src="' . base_url(verifyImg($noticia->img_destaque)) . '" class="thumbnail">', array('target' => '_blank'));
                    ?>
                </td>
                <td>
                  <?php echo $noticia->title;?>
                </td>
                <td><?php echo $campus->city; ?></td>

                <td>
                  <?php echo anchor("Painel_noticias/cadastrarFotos/$campus->id/$noticia->id", '<i class = "material-icons">insert_photo</i> <span>Fotos</span>', array('class' => 'btn btn-info m-t-15 waves-effect'));?>
                  <?php echo anchor("Painel_noticias/verFotos/$campus->id/$noticia->id", '<i class = "material-icons">pageview</i> <span>Ver Fotos</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));?>
                </td>
                <td><?php echo $noticia->autor; ?></td>
                <td>
                  <?php
                    if ($noticia->datemodified != NULL) {
                        echo date('d/m/Y H:i:s', strtotime($noticia->datemodified));
                    } else {
                        echo '';
                    }
                    ?>
                </td>
              </tr>
              <?php
            }
            ?>
            </tbody>
          </table>
        </div>
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
  console.log(id);
  $(this).find('.nomeItem').text(nomeItem);
  $(this).find('#btnCerteza').attr('href',
    '<?php echo base_url("Painel_noticias/delete_noticas/$campus->id/"); ?>' + id);
});
</script>