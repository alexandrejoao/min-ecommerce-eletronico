<!DOCTYPE >
<html lang="pt-br" ng-app="cart" >

<head>
    <meta charset="UTF-8">
    <title>Electro Online Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.1/css/fontawesome.min.css" >

    <link rel="stylesheet" href="lib/owl.carousel/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="lib/raty/lib/jquery.raty.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/shop15.css">

    <script src="lib/angularjs/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <header > 

        <!-- Início do MENU desktop -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadows-sm mb-3">
            <div class="container">
            
                <div class="col-md-4-mt5">
                    <a class="navbar-brand" href="#"><img class="img-fluid" src="png/logo.webp" alt="Logo-Marca"></a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="container collapse navbar-collapse ">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Loja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#">Smartphones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Iphone</a>
                        </li>
                    </ul>
                    <div class="justify-content-between ">
                        <ul class="navbar-nav d-flex  mt-3 ">
                            <li class="nav-item ">
                                <a href="#" class="nav-link">Cadastre-se</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Entrar</a>
                            </li>
                            <li class="nav-item">
                                <a href="cart" class="nav-link ">
                                    <i class="bi-cart" style="font-size:24px; line-height: 24px;"></i>
                                </a>
                                
                            </li>
                            <form class="d-flex ms-3 " role="search">
                                <input class="form-control me-2" type="search" placeholder="Search">
                                <button class="btn btn-secondary" type="submit">Search</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Final do MENU desktop -->

    </header>    
    
</html>
