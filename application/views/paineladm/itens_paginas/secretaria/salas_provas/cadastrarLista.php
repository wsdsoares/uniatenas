<?php
echo '<pre>';
print_r($dados);
echo '</pre>';
?>
<div class="block-header">
    <h2></h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Cadastro -  Listas de Provas - Curso <strong><?php echo $curso->name; ?></strong>
                </h2>

            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('secretaria/cadastrarLista/' . $curso->id);
                ?>



                <div class="row clearfix">
                </div>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => "name", 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Lista Prova Medicina'), set_value('name'), 'autofocus required');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>
                            <b>Ciclo</b>
                        </p>
                        <select name="cycle" class="form-control show-tick">
                            <option value="0">-- Selecione --</option>
                            <option value="1">1º Ciclo</option>
                            <option value="2">2º Ciclo</option>
                            <option value="3">3º Ciclo</option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <p>
                            <b>Tipo Alunos</b>
                        </p>
                        <span>
                            <?php
                            echo form_checkbox('typelist', 'regular');
                            ?>
                            <label for="ig_checkbox">Regulares</label>
                        </span>
                        <span class="input-group">
                            <?php
                            echo form_checkbox('typelist', 'dependencia');
                            ?>
                            <label for="ig_checkbox">Dependência</label>
                        </span>


                    </div>
                </div>
                <div class="row clearfix">

                    <div class="col-md-3">
                        <b>Data início</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">date_range</i>
                            </span>
                            <div class="form-line">
                                <?php
                                echo form_input(array('name' => "datestart", 'type' => 'date', 'class' => 'form-control'), set_value('datestart'), 'required');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <b>Data fim</b>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">date_range</i>
                            </span>
                            <?php
                            echo form_input(array('name' => "dateend", 'type' => 'date', 'class' => 'form-control'), set_value('dateend'), 'required');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">


                    <!--div class="col-md-2">
                        <span> Situação</span>
                        <div class="row">
                            <div class="col-md-3" style="">
                                <label for="">Ativo</label>     
                            </div>
                            <div class="col-md-9">
                                <input type="checkbox" id="basic_checkbox_2" class="filled-in" checked />
    
                            </div>
                        </div>
    
                    </div-->


                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <?php echo form_hidden('coursesid', $curso->id) ?>
                        <?php echo form_hidden('campusid', $campus->id) ?>
                        <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
                        <?php
                                echo anchor('secretaria/salasProvas', '
                            <i class = "material-icons">
                            assignment_return
                            </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
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




