<?php
if ($campus->id == 1) {
    ?>
    <!-- Start Page Header Section -->
    <section class="bg-page-header bg-page-portal-alunos">
        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="page-header">
                        <div class="page-title titulosImg">
                            <h3>
                                <?php echo 'Informações / Avisos'; ?>

                            </h3>

                            <h2 style="color: #000;">
                                <?php echo $campus->city; ?>

                            </h2>

                        </div>
                        <div class="page-header-content">
                            <ol class="breadcrumb">
                                <!--li>Campus - <?php echo $campus->city; ?></li-->
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
}
?>


<!-- Start Single Events Section -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="sidebar">
                    <div class="widget">
                        <h4 class="sidebar-widget-title">Informações Disponíveis - <?php echo $campus->city ?></h4>
                        <div class="widget-content">
                            <ul class="catagories">
                                <li>
                                    <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>"/>
                                    <span>Diuno</span>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>

            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    <div class="widget">
                        <h4 class="sidebar-widget-title">Informações Disponíveis - <?php echo $campus->city ?></h4>
                        <div class="widget-content">
                            <ul class="catagories">
                                <li>
                                    <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>"/>
                                    <span>Noturno</span>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</section>
<!-- End Single Events Section -->