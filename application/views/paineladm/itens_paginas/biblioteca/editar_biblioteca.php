<div class="block-header">
    <h2></h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Edição - Página - Biblioteca
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('Painel/editarBiblioteca/' . $dados['info_Biblioteca']->id);
                ?>
                <h1 for="title"><?php echo($dados['info_Biblioteca']->title); ?></h1>

                <div class="col-sm-12">
                    <?php
                    echo form_textarea('description', to_html(set_value('description', toHtml($dados['info_Biblioteca']->description))));
                    ?>
                </div>
                <script type="text/javascript">
                    // replace: substitui o formato padrão do textarea (descricao)
                    // e aplica as configurações do CKEDitor através do arquivo config.js
                    var editor = CKEDITOR.replace('description', {customConfig: 'config.js'});
                </script>


                <div class="row clearfix">
                    <div class="col-md-12">
                        <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
                        <button type="reset" class="btn btn-lg btn-danger m-t-15 m-r-15 waves-effect left">CANCELAR
                        </button>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>