<?php

require 'inc/configuration.php';
require 'inc/Slim-2.x/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// GET route
$app->get(
    '/',
    function () {

        require_once("view/index.php");
    }
);

$app->get(
    '/cart',
    function () {

        require_once("view/cart.php");
    }
);

$app->get(
    '/smartphone',
    function () {

        require_once("view/smartphone.php");
    }
);


/* Início Formatando as casas decimais no banco de dados  */
$app->get('/produtos', function () {

    $sql = new Sql();

    /* Quantidade de Produto Listado no carousel puxado do banco de dados (3) */
    $data = $sql->select("SELECT * FROM tb_produtos where preco_promorcional >0 order by preco_promorcional desc limit 8;");

    foreach ($data as &$produto) {
        $preco = $produto['preco'];
        $centavos = explode(".", $preco);
        $produto['preco'] = number_format($preco, 0, ",", ".");
        $produto['centavos'] = end($centavos);
        $produto['parcelas'] = 10;
        $produto['parcela'] = number_format($preco / $produto['parcelas'], 2, ",", ".");
        $produto['total'] = number_format($preco, 2, ",", ".");
    }

    echo json_encode($data);
});
/* Final Formatando as casas decimais no banco de dados s  */


/* Início Produtos mais Buscados   */
$app->get('/produtos-mais-buscados', function () {

    $sql = new Sql();

    /* Quantidade de Produto Listado no carousel puxado do banco de dados (4) */
    $data = $sql->select("SELECT 
    tb_produtos.id_prod,
    tb_produtos.nome_prod_curto,
    tb_produtos.nome_prod_longo,
    tb_produtos.codigo_interno,
    tb_produtos.id_cat,
    tb_produtos.preco,
    tb_produtos.peso,
    tb_produtos.largura_centimetro,
    tb_produtos.altura_centimetro,
    tb_produtos.quantidade_estoque,
    tb_produtos.preco_promorcional,
    tb_produtos.foto_principal,
    tb_produtos.visivel,
    cast(avg(review) as dec(10,2)) as media, 
    count(id_prod) as total_reviews
    FROM tb_produtos 
    INNER JOIN tb_reviews USING(id_prod) 
    GROUP BY 
    tb_produtos.id_prod,
    tb_produtos.nome_prod_curto,
    tb_produtos.nome_prod_longo,
    tb_produtos.codigo_interno,
    tb_produtos.id_cat,
    tb_produtos.preco,
    tb_produtos.peso,
    tb_produtos.largura_centimetro,
    tb_produtos.altura_centimetro,
    tb_produtos.quantidade_estoque,
    tb_produtos.preco_promorcional,
    tb_produtos.foto_principal,
    tb_produtos.visivel
    LIMIT 4;    
    ");

    foreach ($data as &$produto) {
        $preco = $produto['preco'];
        $centavos = explode(".", $preco);
        $produto['preco'] = number_format($preco, 0, ",", ".");
        $produto['centavos'] = end($centavos);
        $produto['parcelas'] = 10;
        $produto['parcela'] = number_format($preco / $produto['parcelas'], 2, ",", ".");
        $produto['total'] = number_format($preco, 2, ",", ".");
    }

    echo json_encode($data);
});
/* Final Produtos mais Buscados */


/* Início Visualizar Produtos */
$app->get("/produto-:id_prod", function ($id_prod) {

    $sql = new Sql();

    $produtos = $sql->select("SELECT * FROM tb_produtos WHERE id_prod = $id_prod");

    $produto = $produtos[0];

    $preco = $produto['preco'];
    $centavos = explode(".", $preco);
    $produto['preco'] = number_format($preco, 0, ",", ".");
    $produto['centavos'] = end($centavos);
    $produto['parcelas'] = 10;
    $produto['parcela'] = number_format($preco / $produto['parcelas'], 2, ",", ".");
    $produto['total'] = number_format($preco, 2, ",", ".");

    require_once("view/shop-produto.php");
});
/* Final Visualizar Produtos */


/* Início Visualizar o Card */
$app->get(
    '/cart',
    function () {

        require_once("view/cart.php");
    }
);

$app->get('/carrinho-dados', function () {

    $sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('" . session_id() . "')");

    $carrinho = $result[0];

    $sql = new Sql();

    $carrinho['produtos'] = $sql->select("CALL sp_carrinhosprodutos_list(" . $carrinho['id_car'] . ")");

    $carrinho['total_car'] = number_format((float)$carrinho['total_car'], 2, ',', '.');
    $carrinho['subtotal_car'] = number_format((float)$carrinho['subtotal_car'], 2, ',', '.');
    $carrinho['frete_car'] = number_format((float)$carrinho['frete_car'], 2, ',', '.');

    echo json_encode($carrinho);
});

$app->get('/carrinhoAdd-:id_prod', function ($id_prod) {

    $sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('" . session_id() . "')");

    $carrinho = $result[0];

    $sql = new Sql();

    $sql->query("CALL sp_carrinhosprodutos_add(" . $carrinho['id_car'] . ", " . $id_prod . ")");

    header("Location: cart");
    exit;
});

$app->delete("/carrinhoRemoveAll-:id_prod", function ($id_prod) {

    $sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('" . session_id() . "')");

    $carrinho = $result[0];

    $sql = new Sql();

    $sql->query("CALL sp_carrinhosprodutostodos_rem(" . $carrinho['id_car'] . "," . $id_prod . ")");

    echo json_encode(array(
        "success" => true
    ));
});

$app->post('/carrinho-produto', function () {

    $data = json_decode(file_get_contents("php://input"), true);

    $sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('" . session_id() . "')");

    $carrinho = $result[0];

    $sql = new Sql();

    $sql->query("CALL sp_carrinhosprodutos_add(" . $carrinho['id_car'] . "," . $data['id_prod'] . ")");

    echo json_encode(array(
        "success" => true
    ));
});

$app->delete("/carrinho-produto", function () {

    $data = json_decode(file_get_contents("php://input"), true);

    $sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('" . session_id() . "')");

    $carrinho = $result[0];

    $sql = new Sql();

    $sql->query("CALL sp_carrinhosprodutos_rem(" . $carrinho['id_car'] . "," . $data['id_prod'] . ")");

    echo json_encode(array(
        "success" => true
    ));
});
/* Final Visualizar o Card */


/* Início Calcular o frete (Correios) */

$app->get("/calcular-frete-:cep", function ($cep) {

    require_once("inc/php-calcular-frete-correios-master/frete.php");

    $sql = new Sql();

    $result = $sql->select("CALL sp_carrinhos_get('" . session_id() . "')");

    $carrinho = $result[0];

    $sql = new Sql();

    $produtos = $sql->select("CALL sp_carrinhosprodutosfrete_list(" . $carrinho['id_car'] . ")");

    $peso = 0;
    $comprimento = 0;
    $altura = 0;
    $largura = 0;
    $valor = 0;

    foreach ($produtos as $produto) {
        $peso = +$produto['peso'];
        $comprimento = +$produto['comprimento'];
        $altura = +$produto['altura'];
        $largura = +$produto['largura'];
        $valor = +$produto['preco'];
    }

    $cep = trim(str_replace('-', '', $cep));

    //$frete = new Frete('01418100',     $cep,     $peso,     $comprimento,     $altura,     $largura,     $valor);

        $frete = new Frete(
        $cepDeOrigem = '01153000',
        $cepDeDestino = $cep,
        $peso,
        $comprimento,
        $altura,
        $largura,
        $valor
    );

    $sql = new Sql();

    $sql->query("UPDATE tb_carrinhos 
        SET 
            cep_car = '" . $cep . "',
            frete_car = " . $frete->getValor() . ",
            prazo_car = " . $frete->getPrazoEntrega() . "
        WHERE id_car = " . $carrinho['id_car']);

    echo json_encode(array(

        'valor_frete' => $frete->getValor(),
        'prazo' => $frete->getPrazoEntrega()
    ));
});

/* Final Calcular o frete (Correios) */


$app->run();
