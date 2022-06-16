
<style>
    .rating-block {
        border: 1px solid #EFEFEF;
        padding: 15px 15px 20px 15px;
        border-radius: 3px;
    }

    .bold {
        font-weight: 700;
    }

    .padding-bottom-7 {
        padding-bottom: 7px;
    }

    .descriptionFinanciamentos{
        background: #F0FFF0;
    }

    .corFundoFinanciamentos1 {
        background-color: #dbead5;
    }

    .corFundoFinanciamentos2{
        background-color: #edffe5;
    }

    .review-block {
        border: 1px solid #EFEFEF;
        padding: 15px;
        border-radius: 3px;
        margin-bottom: 15px;
    }

    .review-block-title {
        text-align: center;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .review-block-description {
        font-size: 13px;
    }

    .review-block-description .text-right{
        margin-top: 10px
</style>
<div class="container">

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <div class="rating-block descriptionFinanciamentos">
                <h4><?php echo $conteudoPag[0]->title_short; ?></h4>
                <h2 class="bold padding-bottom-7"><?php echo $conteudoPag[0]->description; ?></h2>
            </div>
        </div>
        <?php

        for ($i = 1; $i < count($dados['conteudoPag']); $i++) {
            if( $i  % 2 == 0){
                $classe = "corFundoFinanciamentos1";
            }else{
                $classe = "corFundoFinanciamentos2";
            }
            ?>
            <div class="col-sm-12">
                <hr/>
                <div class="review-block <?php echo $classe;?>">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="review-block-title"><?php echo $dados['conteudoPag'][$i]->title; ?></div>
                            <div class="review-block-description">
                                <?php
                                $max = 150;
                                $str = $dados['conteudoPag'][$i]->description;
                                to_html(substr_replace($str, (strlen($str) > $max ? '...' : ''), $max));

                                echo $texto = mb_substr($str, 0, mb_strrpos(mb_substr($str, 0, $max), ' '), 'UTF-8') . '...';
                                ?>
                                <div class="text-right">
                                    <a href="" class="btn btn-success"><i class="fa fa-plus"></i> Informações</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</div>