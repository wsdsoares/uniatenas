<?php
$year = date('Y');
$id = $this->uri->segment(3);
$idPage = $this->uri->segment(4);
$this->session->userdata('user_codusuario');
?>	
<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'REGISTRO DE ' . strtoupper($revistas_titulo); ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart('publicacoes/editarMagazine/'.$id.'/' . $idPage) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title', $revista->title));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Curso</label>
                                <select name="courses_id">

                                    <option value="<?php echo $revista->courses_id ?>" selected="selected" class='form-control show-tick'><?php echo $revista->courses; ?></option>
                                    <?php
                                    foreach ($cursos as $teste) {
                                        if ($teste->id == $revista->courses_id) {
                                            $display = "style='display:none;'";
                                            echo '<option value="' . $teste->id . '" ' . set_select('courses_id', $teste->id) . ' ' . $display . '>' . $teste->name . '</option>';
                                        } else {

                                            echo '<option value="' . $teste->id . '" ' . set_select('courses_id', $teste->id) . '>' . $teste->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">

                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Ano</label>
                                <?php
                                echo form_input(array('name' => 'year', 'type' => 'number', 'min' => '1990', 'max' => $year, 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('year', $revista->year));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-2">
                        <div class="form-line">
                            <label for="title">Volume</label>
                            <?php
                            echo form_input(array('name' => 'volume', 'type' => 'number', 'min' => '1', 'max' => '99', 'class' => 'form-control'), set_value('volume', $revista->volume));
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-line">
                            <label for="title">Nº</label>
                            <?php
                            echo form_input(array('name' => 'number_vol', 'type' => 'number', 'min' => '1', 'max' => '11', 'class' => 'form-control'), set_value('number_vol', $revista->number_vol));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Arquivo</label>
                                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Upload | Drag & Drop OR With Click & Choose -->



                <div class="row clearfix">
                    <div class="col-md-4">
                        <p>
                            <b>Arquivo - Atual</b>
                        </p>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">picture_as_pdf</i>
                            </span>
                            <div class="form-line">
                                <?php echo anchor($revista->files,'Visualizar', array("target"=>'blank')); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('publicacoes/publicacoes/'.$revistas_id, 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('revistas_id', $revistas_id);
                        echo form_hidden('users_id', $this->session->userdata('user'));
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
