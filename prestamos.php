<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos</title>
    <link rel="icon" href="img/logosena.png">
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- //Iconos -->
    <script src="https://kit.fontawesome.com/1acb315610.js" crossorigin="anonymous"></script>
</head>

<body class="container-fluid">
    <header id="main-header">

        <div class="row">
            <div class="col-lg-3 my-3 col-sm-6">
                <img class="sena" src="IMG/logosena.png" alt="SENA" title="SENA">
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="py-1">
                    <h1 class="tittle">Prestamos</h1>
                    <p class="p2">Centro Textil de Gestión Industrial</p>
                </div>
            </div>
            <div class="col-lg-3 my-3 col-sm-6">
                <img class="Mineducacion" src="IMG/Mineducacion.webp" alt="Min Educación" title="Min educación">
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 py-0">
                <div class="Menu" id="menuIcon">
                    <nav class="navbar navbar-expand-lg bg-body-tertiary">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul>
                                <!--popover-->
                                <button popovertarget="pop">
                                    <li> <a class="icon-menu" title="Perfil">
                                            <ion-icon class="icon" name="person-circle-outline"></ion-icon>
                                        </a>
                                    </li>
                                </button>

                                <div id="pop" popover>
                                    <h2>Editar perfil</h2>

                                    <form action="#" method="post" enctype="multipart/form-data">
                                        <div class="profilebtn">
                                            <img src="IMG/profile.png" alt="profile" id="profile">
                                            <input type="file" name="profile" id="img" accept="image/*">

                                        </div>
                                        <label for="img" id="cambiar"><i class="far fa-edit"></i>Cambiar
                                            foto</label>

                                        <div class="casillas">
                                            <input type="text" placeholder="Nuevo usuario">
                                        </div>
                                        <br>

                                        <div class="casillas">
                                            <input type="email" placeholder="Correo">
                                        </div>
                                        <br>

                                        <div class="casillas">
                                            <input type="password" placeholder="Nueva contraseña">
                                        </div>
                                        <br>

                                        <input id="Listo" type="submit" value="Listo">
                                    </form>
                                </div>


                                <li> <a class="icon-menu" href="index.html" title="Novedades">
                                        <ion-icon class="icon" name="alert-circle-outline"></ion-icon>
                                    </a>
                                </li>
                                <li> <a class="icon-menu" href="prestamos.html" title="Préstamos">
                                        <ion-icon class="icon" name="copy-outline"></ion-icon>
                                    </a>
                                </li>
                                <li> <a class="icon-menu" href="" title="Inventario">
                                        <ion-icon class="icon" name="storefront-outline"></ion-icon>
                                    </a>
                                </li>
                                <li> <a class="icon-menu" href="login.html" title="Cerrar sesión">
                                        <ion-icon class="icon" class="icon" name="log-out-outline"></ion-icon>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Botón para abrir el modal -->
            <button class="prestamo" id="openModal">
                <ion-icon name="add-circle-outline"></ion-icon> Realizar préstamos
            </button>

            <!-- Modal -->
            <div class="modal" id="modal">
                <div class="modal-content">
                    <span class="close-btn" id="closeModal">&times;</span>
                    <h2 id="form">Formulario de Préstamo</h2>
                    <br>
                    <label for="funcionario">Funcionario</label>
                    <input class="info" type="text"><br>
                    <label for="articulo">Articulo</label>
                    <select class="form-select" aria-label="Default select example">
                        <?php
                        include 'PHP/Conexion.php';
                        $querytype = "SHOW COLUMNS FROM prestamo LIKE 'Tipo_Insumo'";
                        $result2 = mysqli_query($conexion, $querytype);
                        $row2 = mysqli_fetch_assoc($result2);
                        $enum_values = str_replace("'", "", substr($row2['Type'], 5, -1));
                        $options = explode(",", $enum_values);
                        foreach ($options as $option) {
                            echo "<option value='$option'>$option</option>";
                        }
                        ?>
                    </select>
                    <button class="enviar">Enviar</button>
                </div>
            </div>
            <!-- carrusel -->
            <div class="carrusel">
                <div class="imagenes">

                </div>

                <div class="indicadores">
                    <span class="activo"></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!-- tablas -->
            <div class="table-container">
                <div class="table-sofi">
                    <div class="title-container">
                        <span class="title">Dispositivos</span>
                        <form>
                            <input placeholder="Consultar dispositivo" id="value" name="value" type="text">
                            <button><i class="fal fa-search"></i></button>
                        </form>
                    </div>
                    <header>
                        <span class="value">funcionario</span>
                        <span class="value">Articulo</span>
                        <span class="value">Ambiente</span>
                        <span class="value">Fecha de prestamo</span>
                        <span class="value">Fecha de devolucion</span>

                    </header>
                    <div id="devices" class="body scroll-mini-white">
                        <!-- //Aqui se insertaran las filas -->
                    </div>
                    <div class="footer">
                        <span id="devices-amount" class="amount"></span>
                        <div class="pagination">
                            <button><i class="fal fa-caret-left"></i></button>
                            <select name="page" id="pahe">
                            </select>
                            <button><i class="fal fa-caret-right"></i></button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="liveToastBtn">Consulte su paz y salvo</button>
            </div>

            <!-- ... -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img src="IMG/logosena.png" id="logonoti" class="rounded me-2" alt="...">
                        <strong class="me-auto">Estado de su paz y salvo</strong>
                        <small>11 mins ago</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        hola
                    </div>
                </div>
            </div>
        </div>
        <!--FOOTER-->
        <div class="container-fluid">
            <footer class="pie-pagina">
                <div class="group-1">
                    <div class="row" id="row-footer">
                        <div class="col-lg-3 col-sm-12">
                            <div class="box" id="logo">
                                <figure>
                                    <a href="#">
                                        <img src="IMG/Jomisoft.png" alt="">
                                    </a>
                                </figure>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="box">
                                <h2>sobre nosotros</h2>
                                <h5>
                                    pagina creada para el sena
                                </h5>
                                <h5>
                                    solo es una prueba
                                </h5>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="box">
                                <h2>siguenos</h2>
                                <div class="red-social">
                                    <a href="#" class="fa fa-facebook">
                                    </a><a href="#" class="fa fa-instagram">
                                    </a>
                                    <a href="#" class="fa fa-twitter">
                                    </a>
                                    <a href="" class="fa fa-youtube">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="group-2">
                    <small>&copy; 2021 <b>Holiiii</b> - Todos los dertechos reservados</small>
                </div>
            </footer>
            <!-- JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
            <script src="JS/script.js"> </script>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>

</html>