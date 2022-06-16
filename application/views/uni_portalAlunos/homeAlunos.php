<!-- Start Page Header Section -->
<section class="bg-page-header bg-page">'
    <div class="page-header-overlay">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <div class="page-title">
                        <h2>
                            Escolha o <i>Portal</i> que deseja acessar
                        </h2>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-upcoming-events">
    <div class="container">
        <div class="row">
            <div class="upcoming-events">
                <div class="row">
                    <?php
                    foreach ($localidades as $local) {
                        ?>
                        <div class="col-md-4">
                            <div class="event-items">
                                <div class="event-img">
                                    <a href="<?php echo base_url().'PortalAlunos/portal/'.$local->id?>"><img
                                            src="<?php echo base_url().$local->iconeCamus;?>"
                                            alt="upcoming-events-img-1" class="img-responsive" /></a>
                                </div>
                                <div class="events-content text-center">
                                    <?php //echo anchor('PortalAlunos/portal/'.$local->id,$local->city,array('class'=>'btn btn-default')); ?>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<br>