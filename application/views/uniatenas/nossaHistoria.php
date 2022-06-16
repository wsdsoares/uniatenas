<section>
    <div class="container">
        <div class="row">
            <div class="why-chose-option">
                <div class="section-header text-center">
                    <h3><?php echo $pages_content[0]->title. ' - ' . $campus->name . ' - ' . $campus->city; ?></h3>
                    <span class="double-border"></span>
                    <div class="text-justify">
                        <p><?php echo $pages_content[0]->description; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-6">
                        <div class="why-chose-box">
                            <div class="why-chose-items">
                                <img src="<?php echo base_url('assets/images/icons/mission.png') ?>"/>
                                <div class="nossahistoria-itens why-chose-content">
                                    <h4>
                                        <a href="#"><?php echo $pages_content[1]->title; ?></a>
                                    </h4>
                                    <div class="text-justify">
                                        <p><?php echo $pages_content[1]->description; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="why-chose-box">
                                    <div class="why-chose-items">
                                        <img src="<?php echo base_url('assets/images/icons/vision.png') ?>"/>
                                        <div class="nossahistoria-itenst why-chose-content">
                                            <h4>
                                                <a href="#"><?php echo $pages_content[2]->title; ?></a>
                                            </h4>
                                            <div class="text-justify">
                                                <p><?php echo $pages_content[2]->description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="why-chose-box">
                                    <div class="why-chose-items">
                                        <img src="<?php echo base_url('assets/images/icons/values.png') ?>"/>
                                        <div class="why-chose-content">
                                            <h4>
                                                <a href="#"><?php echo $pages_content[3]->title; ?></a>
                                            </h4>
                                            <div class="text-justify">
                                                <p><?php echo $pages_content[3]->description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
