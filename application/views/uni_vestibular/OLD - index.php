<body style='padding: 0;'>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal"><img src="http://atenas.edu.br/site_atenas/assets/img/logo.png"></h5>

</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Informações e Resultados</h1>
</div>

<div class="container">
    <div class="card-deck mb-3 text-center" style="background: #f2f2f2;">
        <?php

        foreach ($dados['vestibular'] as $rows) {
            ?>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal"><?php echo $rows->cityCampus;?></h4>
                </div>
                <div class="card-body">

                    <?php
                    echo anchor('vestibular/resultado', 'Resultado Final', array('class' => "btn btn-lg btn-block btn-warning"));
                    echo anchor('http://www.atenas.edu.br/site_atenas/assets/uploads/EDITAL-2018.pdf', 'Edital', array('class' => "btn btn-lg btn-block btn-info"));

                    ?>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>