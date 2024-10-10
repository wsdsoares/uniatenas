<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'Cadastro dos Reitores/ Diretores e Coordenadores de curso'; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open('Painel_Instituicao/cadastrar_dirigentes') ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Nome</label>
                                <?php
                                echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Nome'), set_value('nome'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Email</label>
                                <?php
                                echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email'), set_value('email'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Curso</label>
                                <select name="cargo" style="margin-top:20px;">
                                    <option value="0" selected="selected" class='form-control show-tick'>-- Selecione --</option>
                                    <option value="Coordenador de Curso" class='form-control show-tick'> Coordenador de Curso</option>
                                    <option value="Reitor/ Diretor Geral" class='form-control show-tick'> Reitor/ Diretor Geral</option>
                                    <option value="Diretora Administrativa e Financeira/ Diretora Administrativa e Financeira"
                                        class='form-control show-tick'> Pro-Reitora/ Diretora Administrativa e Financeira</option>
                                    <option value="Pró-Reitor Acadêmico/ Diretor Acadêmico" class='form-control show-tick'> Pro-Reitor/
                                        Diretor Acadêmico</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php

                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                        echo anchor('painel/dirigentes/', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('users_id', $this->session->userdata('codusuario'));
                        //echo form_hidden('campus_id', 1);
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