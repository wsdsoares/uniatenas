
<div class="block-header">
    <h2></h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Edição - Cartilha - Horas Complementares
                </h2>

            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('secretaria/editarCartilha/'.$files->id);
                ?>
                <h2 class="card-inside-title">Conteúdos</h2>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => "name", 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Nome'), set_value('name', $files->name), 'autofocus required');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>
                            <b>Campus</b>
                        </p>
                        <select name="campusid" class="form-control show-tick">
                            <option value="<?php echo $files->campusid ?>" selected="selected" class='form-control show-tick'><?php echo $files->nameCampus.' - '.$files->city; ?></option>
                            <?php
                            foreach ($campus as $local) {

                                if ($local->id == $files->campusid) {
                                    $display = "style='display:none;'";
                                    echo '<option value="' . $local->id . '" ' . set_select('campusid', $local->id) . ' ' . $display . '>' . $local->name . ' - ' . $local->city . '</option>';
                                    ?>
                                    <?php
                                } else {
                                    ?> 
                                    <option value="<?php echo $local->id; ?>"><?php echo $local->name . ' - ' . $local->city . ' '; ?></option>
                                    <?php
                                }
                                ?>
                                
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
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

                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-4">
                        <p>
                            <b>Arquivo - Atual</b>
                        </p>
                        <div class="form-group">

                            <span class="input-group">
                                <i class="material-icons">insert_drive_file</i>

                                <?php echo anchor($files->files, 'Visualizar', array("target" => 'blank')); ?>
                        </div>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-md-12">
                        <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
                        <button type="reset" class="btn btn-lg btn-danger m-t-15 m-r-15 waves-effect left">CANCELAR</button>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>