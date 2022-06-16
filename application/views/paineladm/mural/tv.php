<?php
$itensTv = array(
    'titulo' => 'teste'
);
?>

<div class="row clearfix">
    <?php
    foreach ($itensTv as $item) {
        ?>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <?php echo '$item->titulo'; ?>
                    </h2>
                </div>
                <div class="body">
                    <?php
                    echo anchor('publicacoes/salvar/' . '$item->id ', '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                    ?>
                    <?php
                    echo anchor('publicacoes/publicacoes/' . '$item->id', '
                    <i class = "material-icons">
                    search
                    </i> <span>Visualizar</span>', array('class' => 'btn btn-system m-t-15 btn-viewer'));
                    ?>
                    <br/>
                    <?php
                    echo anchor('publicacoes/publicacoes/' . '$item->id', '
                    <i class = "material-icons">
                    search
                    </i> <span>Capas</span>', array('class' => 'btn btn-system m-t-15 btn-viewer'));
                    ?>
                </div>
            </div>
        </div>
    <?php
}
?>
</div>