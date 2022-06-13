<?php include_once("header.php"); ?>
<!-- Chama o arquivo header.php-->


<!-- Início Sessão -->
<section ng-controller="destaque-controller">

    <!-- Início Carousel Destaque Produto -->
    <div class="container" id="destaque-produtos-container">

        <div id="destaque-produtos">

            <div class="row " ng-repeat="produto in produtos">

                <div class="col-sm-6 col-imagem text-end">
                    <a href="produto-{{produto.id_prod}}">
                        <img class="img-fluid p-3" src="img/produtos/{{produto.foto_principal}}" alt="{{produto.nome_prod_longo}}">
                    </a>
                </div>
                
                <div class="col-sm-6 col-descricao">
                    <h2 class="fs-6">{{produto.nome_prod_longo}}</h2>
                    <div class="box-valor align-text-top ">
                        <div class="text-noboleto text-arial-cinza">no boleto</div>
                        <div class="text-por text-arial-cinza">por</div>
                        <div class="text-reais text-roxo">R$</div>
                        <div class="text-valor text-roxo">{{produto.preco}}</div>
                        <div class="text-valor-centavos text-roxo">,{{produto.centavos}}</div>
                        <div class="text-parcelas text-arial-cinza">ou em até {{produto.parcelas}}x de R$ {{produto.parcela}}</div>
                        <div class="text-total text-arial-cinza ">total a prazo R$ {{produto.total}}</div>
                    </div>
                    <!-- <a href="#" class="btn btn-comprar text-roxo pb-sm-1"><i class="fa fa-shopping-cart"></i> Compre agora</a> -->
                </div>

            </div>

        </div>

        <button type="button" id="btn-destaque-prev"><i class="fa fa-angle-left"></i></button>
        <button type="button" id="btn-destaque-next"><i class="fa fa-angle-right"></i></button>

    </div>
    <!-- Final Carousel Destaque Produto -->


    <!-- Início produtos mais Buscados ? -->
    <div id="mais-buscados" class="container">

        <div class="row text-center title-default-roxo">
            <h2>Os mais Buscados</h2>
            <hr class="rounded border-warning ">
        </div>

        <div class="row">
            <div class="col-md-3" ng-repeat="produto in buscados">
                <div class="box-produto-info align-text-top p-4">
                    <a href="produto-{{produto.id_prod}}">
                        <!-- Busca o id do produto -->
                        <img img class="img-fluid p-3" src="img/produtos/{{produto.foto_principal}}" alt="{{produto.nome_prod_longo}}" class="produto-img">
                        <h3 class="fs-6 text-secondary">{{produto.nome_prod_longo}}</h3>
                        <div class="estrelas" data-score="{{produto.media}}"></div>
                        <div class="text-qtd-reviews text-arial-cinza">({{produto.total_reviews}})</div>
                        <div class="text-valor text-roxo">R$ {{produto.total}}</div>
                        <div class="text-parcelado text-arial-cinza">{{produto.parcelas}}x de R$ {{produto.parcela}} sem juros</div>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- Final produtos mais Buscados  -->
</section>
<!-- Final Sessão -->



<?php include_once("footer.php"); ?>

<!-- Chama o arquivo footer.php-->

<!-- Início Plug Jquery -->

<!-- Início do Angular -->
<script>
    angular.module("cart", []).controller("destaque-controller", function($scope, $http) {

        $scope.produtos = [];
        $scope.buscados = [];

        /* Início Carousel Destaque-Produtos */
        var initCarousel = function() {

            $("#destaque-produtos").owlCarousel({
                autoPlay: 5000,
                items: 1,
                singleItem: true
            });

            var owlDestaque = $("#destaque-produtos").data('owlCarousel');

            $("#btn-destaque-prev").on("click", function() {

                owlDestaque.prev();

            });

            $("#btn-destaque-next").on("click", function() {

                owlDestaque.next();
            });
        };
        /* Final Carousel Destaque-Produtos */


        /* Início GET produto */
        $http({
            method: 'GET',
            url: 'produtos'
        }).then(function successCallback(response) {

            $scope.produtos = response.data;

            setTimeout(initCarousel, 1000);

        }, function errorCallback(response) {


        });
        /* Final GET produto */


        /* Início Estrelas dos Produtos */
        var initEstrelas = function() {

            $(".estrelas").each(function() {

                $(this).raty({

                    starHalf: 'lib/raty/lib/images/star-half.png',
                    starOff: 'lib/raty/lib/images/star-off.png',
                    starOn: 'lib/raty/lib/images/star-on.png',
                    score: parseFloat($(this).data("score"))

                });
            });
        };
        /* Final Estrelas dos Produtos */


        /* Início GET produtos-mais-buscados */
        $http({
            method: 'GET',
            url: 'produtos-mais-buscados'
        }).then(function successCallback(response) {

            $scope.buscados = response.data;

            setTimeout(initEstrelas, 1000);

        }, function errorCallback(response) {

        });

        /* Final GET produtos-mais-buscados */

    });
</script>
<!-- Final Plug Jquery -->