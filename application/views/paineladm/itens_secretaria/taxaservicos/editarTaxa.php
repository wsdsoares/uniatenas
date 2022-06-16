<?php
$idTAxa = $this->uri->segment(3);

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
                    <?php echo 'EDIÇÃO DE TAXAS E SERVIÇOS'; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open('secretaria/editarTaxa/'.$idTAxa) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome da taxa'), set_value('name',$taxas->name));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">
                                    <Valor>R$ Valor</Valor>
                                </label>
                                <?php
                                echo form_input(array('name' => 'value', 'type' => 'number', 'min' => '0', 'class' => 'form-control', 'placeholder' => 'R$ 00.00'), set_value('value',$taxas->value));
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
                    <div class="col-sm-4">
                        <div class="form-inline">
                            <div class="form-line">
                                <label>Campus</label>
                                <?php

                                echo '<pre>';
                                print_r($campustax);

                                echo '</pre>';
                                $optionLocal2[99] = 'Todos os campus';
                                $optionLocal = array();
                                foreach ($campus as $item){
                                    $optionLocal2[$item->id]=$item->city;
                                }


                                foreach ($campustax as $local) {
                                    $optionLocal[$local->id] = $local->city;
                                }

                                echo form_dropdown('campusid', $optionLocal, set_value('campusid'), array('class' => 'form-control')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <?php echo form_checkbox('firstfree', '1', set_checkbox('firstfree', '1')); ?>
                                    * A primeira via desse documento é gratis
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-inline">
                            <div class="form-line">
                                <?php
                                echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                                echo anchor('secretaria/taxaservicos', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                                echo form_hidden('user', $this->session->userdata('user_codusuario'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                echo form_close();
                ?>

            </div>
        </div>
    </div>
</div>
