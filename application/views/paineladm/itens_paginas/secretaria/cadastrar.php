
<div class="block-header">
    <h2>BASIC FORM ELEMENTS</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Cadastro - 

                    <?php echo $page; ?>

                </h2>

            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('secretaria/cadastrar_calendarios_semestre');
                ?>
                <h2 class="card-inside-title">Conteúdos</h2>
                <div class="row clearfix">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php 
                                echo form_input(array('name'=>"titulo",'type'=>'text','class'=>'form-control','placeholder'=>'Título'),set_value('titulo'),'autofocus required');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p>
                            <b>Tipo</b>
                        </p>
                        <select class="form-control show-tick">
                            <option value="cursos">Cursos</option>
                            <option value="internato">Internato</option>
                        </select>
                    </div>
                    <div class="col-md-2">

                        <p>
                            <b>Semetre</b>
                        </p>
                        <select class="form-control show-tick">
                            <?php
                            foreach ($school_semester as $semester) {
                                ?>
                                <option value="<?php echo $semester->id; ?>"><?php echo $semester->stage . 'º - ' . $semester->year_semester; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-2">
                        <p>
                            <b>Situação</b>
                        </p>
                        <div class="demo-checkbox">
                            <input type="checkbox" id="basic_checkbox_2" class="filled-in" checked />
                            <label for="basic_checkbox_2">Ativo</label>     
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p>
                            <b>Campus</b>
                        </p>
                        <select class="form-control show-tick">
                            <?php
                            foreach ($campus as $local) {
                                ?>
                                <option value="<?php echo $local->id; ?>"><?php echo $local->name . ' - ' . $local->city . ' '; ?></option>
                                <?php
                            }
                            ?>
                        </select>


                    </div>


                </div>

                <div class="row clearfix">
                    <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
                    <button type="reset" class="btn btn-lg btn-danger m-t-15 m-r-15 waves-effect left">CANCELAR</button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>




