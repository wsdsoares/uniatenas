<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Vídeos <small>Itens cadastrados</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Large modal -->                
                    <?php
                    echo anchor('painel/cadastrar_videos', 'Cadastrar Vídeos', array('class' => 'btn btn-primary'));
                    ?>

                    <div class="x_content">

                        <p>Add class <code>bulk_action</code></p>

                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th>
                                        <input type="checkbox" id="check-all" class="flat" >
                                    </th>
                                    <th class="column-title">Nº </th>
                                    <th class="column-title">Titulo</th>
                                    <th class="column-title">Miniatura </th>

                                    <th class="column-title">Data Registro </th>
                                    <th class="column-title no-link last">
                                        <span class="nobr">Ação</span>
                                    </th>

                                </tr>
                            </thead>

                            <?php
                            $dados = $this->painel->get_all_videos()->result();
                            ?>

                            <tbody>

                                <?php
                                foreach ($dados as $linha):

                                    /* ?>
                                      <tr class="even pointer">
                                      <td class="a-center ">
                                      <input type="checkbox" class="flat" name="table_records">
                                      </td>
                                      <td style="background: red"class=""><?php echo $linha->id ?></td>
                                      <td style="background: pink"class=""><?php echo $linha->titulo ?> </td>
                                      <td style="background: red"class="">
                                      <iframe src="https://www.youtube.com/embed/<?php echo $linha->url ?>" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                                      <td>
                                      <td style="background: pink"class="">
                                      <?php echo date('d/m/Y', strtotime($linha->data_cadastro)); ?>
                                      </td>

                                      </tr>


                                      <?php
                                     * */
                                    ?>
                                    <tr class="even pointer">
                                        <td class="a-center ">
                                            <input type="checkbox" class="flat" name="table_records">
                                        </td>
                                        <td><?php echo $linha->id ?></td>
                                        <td><?php echo $linha->titulo ?></td>
                                        <td><iframe src="https://www.youtube.com/embed/<?php echo $linha->url ?>" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></td>
                                        <td><?php echo date('d/m/Y', strtotime($linha->data_cadastro)); ?></td>
                                        <td>
                                            <?php 
                                                echo anchor('Painel/editar_videos/'.$linha->id,'<img src="'. base_url().'assets\img\painel\edit.png">')
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>  
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer content -->
    <footer>
        <div class="copyright-info">

            </p>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

</div>