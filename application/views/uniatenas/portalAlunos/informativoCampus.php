<style>
    #blog-section {
        margin-top: 40px;
        margin-bottom: 80px;
    }

    .content-title {
        padding: 5px;
        background-color: #fff;
    }

    .content-title h3 a {
        color: #34495E;
        text-decoration: none;
        transition: 0.5s;
    }

    .content-title h3 a:hover {
        color: #F39C12;
    }

    .content-footer {
        background-color: #16A085;
        padding: 10px;
        position: relative;
    }

    .content-footer span a {
        color: #fff;
        display: inline-block;
        padding: 6px 5px;
        text-decoration: none;
        transition: 0.5s;
    }

    .content-footer span a:hover {
        color: #F39C12;
    }

    aside {
        margin-top: 30px;
        -webkit-box-shadow: 1px 4px 16px 3px rgba(199, 197, 199, 1);
        -moz-box-shadow: 1px 4px 16px 3px rgba(199, 197, 199, 1);
        box-shadow: 1px 4px 16px 3px rgba(199, 197, 199, 1);
    }

    aside .content-footer > img {
        width: 33px;
        height: 33px;
        border-radius: 100%;
        margin-right: 10px;
        border: 2px solid #fff;
    }

    .user-ditels {
        width: 300px;
        top: -100px;
        height: 100px;
        padding-bottom: 99px;
        position: absolute;
        border: solid 2px #fff;
        background-color: #34495E;
        right: 25px;
        display: none;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .user-ditels {
            right: 5px;
        }

    }

    .user-small-img {
        cursor: pointer;
    }

    .content-footer:hover .user-ditels {
        display: block;
    }


    .content-footer .user-ditels .user-img {
        width: 100px;
        height: 100px;
        float: left;
    }

    .user-full-ditels h3 {
        color: #fff;
        display: block;
        margin: 0px;
        padding-top: 10px;
        padding-right: 28px;
        text-align: right;
    }

    .user-full-ditels p {
        color: #fff;
        display: block;
        margin: 0px;
        padding-right: 20px;
        padding-top: 5px;
        text-align: right;
    }

    .social-icon {
        background-color: #fff;
        margin-top: 10px;
        padding-right: 20px;
        text-align: right;
    }

    .social-icon > a {
        font-size: 20px;
        text-decoration: none;
        padding: 5px;
    }

    .social-icon a:nth-of-type(1) {
        color: #4E71A8;
    }

    .social-icon a:nth-of-type(2) {
        color: #3FA1DA;
    }

    .social-icon a:nth-of-type(3) {
        color: #E3411F;
    }

    .social-icon a:nth-of-type(4) {
        color: #CA3737;
    }

    .social-icon a:nth-of-type(5) {
        color: #3A3A3A;
    }


    /*recent-post-col////////////////////*/
    .widget-sidebar {
        background-color: #fff;
        padding: 20px;
        margin-top: 30px;
    }

    .title-widget-sidebar {
        font-size: 14pt;
        border-bottom: 2px solid #e5ebef;
        margin-bottom: 15px;
        padding-bottom: 10px;
        margin-top: 0px;
    }

    .title-widget-sidebar:after {
        border-bottom: 2px solid #f1c40f;
        width: 150px;
        display: block;
        position: absolute;
        content: '';
        padding-bottom: 10px;
    }

    .recent-post {
        width: 100%;
        height: 80px;
        list-style-type: none;
    }

    .post-img img {
        width: 100px;
        height: 70px;
        float: left;
        margin-right: 15px;
        border: 5px solid #16A085;
        transition: 0.5s;
    }

    .recent-post a {
        text-decoration: none;
        color: #34495E;
        transition: 0.5s;
    }

    .post-img, .recent-post a:hover {
        color: #F39C12;
    }

    .post-img img:hover {
        border: 5px solid #F39C12;
    }

    button.accordion {
        background-color: #16A085;
        color: #fff;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    button.accordion.active, button.accordion:hover {
        background-color: #F39C12;
        color: #fff;
    }

    button.accordion:after {
        content: '\002B';
        color: #fff;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    button.accordion.active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }
</style>


<div class="container">
    <div class="section-header text-center">
        <h3>Informações / Avisos <?php echo $campus->name; ?></h3>

        <h4>
            <?php echo $campus->city; ?>
        </h4>
    </div>
</div>


    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <aside>
                            <img src="<?php echo base_url('assets/images/portais/news/banner-principal-alunos.png');?>"
                                 class="img-responsive">
                            <div class="content-title">
                                <div class="text-center">
                                    <h3><a href="#">Clique aqui</a></h3>
                                </div>
                            </div>
                            <div class="content-footer">
                                <img class="user-small-img"
                                     src="https://lh3.googleusercontent.com/-uwagl9sPHag/WM7WQa00ynI/AAAAAAAADtA/hio87ZnTpakcchDXNrKc_wlkHEcpH6vMwCJoC/w140-h148-p-rw/profile-pic.jpg">
                                <span style="font-size: 16px;color: #fff;">Informações</span>

                                <div class="user-ditels">
                                    <div class="user-img">
                                        <img src="https://lh3.googleusercontent.com/-uwagl9sPHag/WM7WQa00ynI/AAAAAAAADtA/hio87ZnTpakcchDXNrKc_wlkHEcpH6vMwCJoC/w140-h148-p-rw/profile-pic.jpg"
                                                class="img-responsive"></div>
                                    <span class="user-full-ditels">
                                    <h3>Comunicado.</h3>
                                    <p>Portal do aluno</p>
                                    </span>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar">#LINKS UTEIS</h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="<?php echo base_url('assets/images/portais/reemisao_boleto.png');?>"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Reemissão Boleto Vencido</h5></a>
                                <p>
                                    <small><i class="fa fa-pager" data-original-title="" title=""></i>
                                        Boletos - Campus <?php echo $campus->name; ?>
                                    </small>
                                </p>
                            </li>
                            <hr>

                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="<?php echo base_url('assets/images/portais/calendario_academico.png');?>"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Calendários Acadêmico</h5></a>
                                <p>
                                    <small><i class="fa fa-pager" data-original-title="" title=""></i>
                                         Campus <?php echo $campus->name; ?>
                                    </small>
                                </p>
                            </li>
                            <hr>

                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="<?php echo base_url('assets/images/portais/declaracao_vinculo.png');?>"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Declaração de Vínculo</h5></a>
                                <p>
                                    <small><i class="fa fa-pager" data-original-title="" title=""></i>
                                        Campus <?php echo $campus->name; ?>
                                    </small>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar">Acesso rápido</h2>
                    <div class="last-post">
                        <button class="accordion">21/4/2016</button>
                        <div class="panel">
                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="https://lh3.googleusercontent.com/-13DR8P0-AN4/WM1ZIz1lRNI/AAAAAAAADeo/XMfJ7CM-pQg9qfRuCgSnphzqhaj3SQg6QCJoC/w424-h318-n-rw/thumbnail4.jpg"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Excepteur sint occaecat cupi non proident laborum.</h5></a>
                                <p>
                                    <small><i class="fa fa-calendar" data-original-title="" title=""></i> 30 Juni 2014
                                    </small>
                                </p>
                            </li>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <hr>
                    <div class="last-post">
                        <button class="accordion">5/7/2016</button>
                        <div class="panel">
                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="https://lh3.googleusercontent.com/-QlnwuVgbxus/WM1ZI1FKQiI/AAAAAAAADeo/nGSd1ExnnfIfIBF27xs8-EdBdfglqFPZgCJoC/w424-h318-n-rw/thumbnail2.jpg"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Excepteur sint occaecat cupi non proident laborum.</h5></a>
                                <p>
                                    <small><i class="fa fa-calendar" data-original-title="" title=""></i> 30 Juni 2014
                                    </small>
                                </p>
                            </li>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <hr>
                    <div class="last-post">
                        <button class="accordion">15/9/2016</button>
                        <div class="panel">
                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="https://lh3.googleusercontent.com/-wRHL_FOH1AU/WM1ZIxQZ3DI/AAAAAAAADeo/lwJr8xndbW4MHI-lOB7CQ-14FJB5f5SWACJoC/w424-h318-n-rw/thumbnail5.jpg"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Excepteur sint occaecat cupi non proident laborum.</h5></a>
                                <p>
                                    <small><i class="fa fa-calendar" data-original-title="" title=""></i> 30 Juni 2014
                                    </small>
                                </p>
                            </li>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <hr>
                    <div class="last-post">
                        <button class="accordion">2/3/2017</button>
                        <div class="panel">
                            <li class="recent-post">
                                <div class="post-img">
                                    <img src="https://lh3.googleusercontent.com/-QlnwuVgbxus/WM1ZI1FKQiI/AAAAAAAADeo/nGSd1ExnnfIfIBF27xs8-EdBdfglqFPZgCJoC/w424-h318-n-rw/thumbnail2.jpg"
                                         class="img-responsive">
                                </div>
                                <a href="#"><h5>Excepteur sint occaecat cupi non proident laborum.</h5></a>
                                <p>
                                    <small><i class="fa fa-calendar" data-original-title="" title=""></i> 30 Juni 2014
                                    </small>
                                </p>
                            </li>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


