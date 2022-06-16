<div class="block-header">
    <h2>GESTÃO DE VAGAS</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart('TrabalheConosco/cadastrarVagas/') ?>
                <h2 class="card-inside-title">Detalhes da vaga</h2>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="name">Vaga</label>
                                <?php echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => "Título da vaga"), set_value('name')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title_short">Data início</label>
                                <?php echo form_input(array('name' => 'datestart', 'type' => 'date', 'class' => 'form-control'), set_value('datestart')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title_short">Data término</label>
                                <?php echo form_input(array('name' => 'dateend', 'type' => 'date', 'class' => 'form-control'), set_value('dateend')); ?>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload | Drag & Drop OR With Click & Choose -->

                </div>
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Area</label>
                                <select name="sectorareaid">
                                    <option value="0" selected="selected" class='form-control show-tick'>-- Selecione
                                        --
                                    </option>
                                    <?php
                                    $options = array();
                                    foreach ($resumeSectorArea as $teste) {
                                        echo '<option value="' . $teste->id . '" ' . set_select('sectorareaid', $teste->id) . '>' . $teste->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Campus</label>
                                <select name="campusid">
                                    <option value="0" selected="selected" class='form-control show-tick'>-- Selecione
                                        --
                                    </option>
                                    <?php
                                    $options = array();
                                    foreach ($localidades as $teste) {
                                        echo '<option value="' . $teste->id . '" ' . set_select('courses_id', $teste->id) . '>' . $teste->name . ' - ' . $teste->city . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('TrabalheConosco/vagasTrabalho/', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('usersid', $this->session->userdata('user'));
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
<!--#END# DateTime Picker -->
