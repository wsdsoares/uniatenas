<!-- Start Page Header Section -->
<section class="bg-page-header bg-page-campus">'
    <div class="page-header-overlay">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <div class="page-title">
                        <h2>
                            <?php echo strtoupper('INFRAESTRUTURA FÍSICA E ACADÊMICA'); ?>
                        </h2>
                    </div>
                    <div class="page-header-content">
                        <ol class="breadcrumb">
                            <li>UniAtenas</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Page Header Section -->

<!-- Start Single Services Section -->
<section class="bg-single-services">
    <div class="container">
        <div class="row">
            <div class="single-services">
                <div class="row">
                    <div class="col-md-4">
                        <div class="single-left-services-list">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php
                                $classe = '';
                                foreach ($pages_content as $iitem):
                                    if ($iitem->order == 'serviceA'):
                                        $classe = 'active';
                                    else:
                                        $classe = '';
                                    endif;
                                    ?>

                                    <li role="presentation" class="<?php echo $classe; ?>">
                                        <a href="#<?php echo $iitem->order; ?>" 
                                           aria-controls="<?php echo $iitem->order; ?>" 
                                           role="tab" 
                                           data-toggle="tab">
                                            <i class="fa fa-angle-double-right"
                                               aria-hidden="true"></i> <?php echo $iitem->title_short; ?>
                                        </a>
                                    </li>

                                    <?php
                                endforeach;
                                ?>
                            </ul>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content">
                            <?php
                                                                                    
                            foreach ($pages_content as $textos):
                                if ($textos->order == 'serviceA'):
                                    $classe = 'active';
                                else:
                                    $classe = '';
                                endif;
                                ?>
                                <div role="tabpanel" class="tab-pane <?php echo $classe; ?>" id="<?php echo $textos->order;?>">
                                    <div class="single-services-content">
                                        <div>
                                            <h3><?php echo $textos->title; ?></h3>
                                            
                                            <img src="<?php echo base_url() .$textos->img_destaque; ?>"alt="single-services-img-4" class="img-responsive" />
                                        </div>
                                        <div>
                                            <p><?php echo $textos->description; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</section>
<!-- End Single Services Section -->



