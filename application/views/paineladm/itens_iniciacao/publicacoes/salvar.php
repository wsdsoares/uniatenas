<?php
$year = date('Y');
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
                    <?php echo 'REGISTRO - ' . strtoupper($revistas_titulo); ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart('publicacoes/salvar/' . $revistas_id) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title'));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Curso</label>
                                <select name="courses_id" style="margin-top:20px;">
                                    <option value="0" selected="selected" class='form-control show-tick'>-- Selecione --</option>
                                    <?php
                                    $options = array();
                                    foreach ($cursos as $teste) {
                                        echo '<option value="' . $teste->id . '" ' . set_select('courses_id', $teste->id) . '>' . $teste->name . '</option>';
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
                                echo form_input(array('name' => 'year', 'type' => 'number', 'min' => '1990', 'max' => $year, 'class' => 'form-control'), set_value('year'));
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
                            echo form_input(array('name' => 'volume', 'type' => 'number', 'min' => '1', 'max' => '99', 'class' => 'form-control'), set_value('volume'));
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-line">
                            <label for="title">Nº</label>
                            <?php
                            echo form_input(array('name' => 'number_vol', 'type' => 'number', 'min' => '1', 'max' => '11', 'class' => 'form-control'), set_value('number_vol'));
                            ?>
                        </div>
                    </div>
                </div>

                <!-- File Upload | Drag & Drop OR With Click & Choose -->
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
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                        echo anchor('publicacoes/publicacoes/'.$revistas_id, 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('users_id', $this->session->userdata('user'));
                        echo form_hidden('revistas_id', $revistas_id);
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
