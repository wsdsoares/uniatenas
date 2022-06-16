<div class="container">

    <div class="dados_gerais">
        <div class="container">
            <h2 class="text-center"><?php echo $conteudoPag[0]->title; ?></h2>
            <div class="row">
                <div class="col-sm-12 ">
                    <?php echo $conteudoPag[0]->description; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h3 class="text-center">Nossos serviços</h3>
        <ul class="nav nav-tabs">
            <?php
            $i = 0;
            foreach ($conteudo as $item) {
                if ($i == 0) {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#<?php echo $item->id; ?>"><?php echo $item->title; ?></a></li>

                <?php
                $i++;
            }
            ?>
        </ul>

        <div class="tab-content">
            <?php
            $i = 0;
            foreach ($conteudo as $item) {
                if ($i == 0) {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <div id="<?php echo $item->id; ?>" class="tab-pane fade in <?php echo $active; ?>">

                    <div class="iniciacao_anais_monografia">
                        <div class="container">	
                            <div class="row">
                                <h3 class="text-center"><?php echo $item->title; ?></h3>

                                <div class="col-md-12">
                                   <?php echo $item->description; ?>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <?php
                $i++;
            }
            ?>


            <br>
        </div>
        
    </div>


</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.thumbnail').click(function () {
            $('.modal-body').empty();
            var title = $(this).parent('a').attr("title");
            $('.modal-title').html(title);
            $($(this).parents('div').html()).appendTo('.modal-body');
            $('#myModal').modal({show: true});
        });
    });

</script>
<style type="text/css">

    .modal-dialog {width:600px;}
    .thumbnail {margin-bottom:6px;}

</style>   
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



