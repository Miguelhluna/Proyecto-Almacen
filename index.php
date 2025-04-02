<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacenista</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="js/script.js"></script>
</head>

<body>

    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-lg-3 my-3 col-sm-6">
                    <img class="sena" src="IMG/logosena.png" alt="SENA" title="SENA">
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="py-1">
                        <h1 class="tittle">Almacén</h1>
                        <p class="p2">Centro Textil de Gestión Industrial</p>
                    </div>
                </div>
                <div class="col-lg-3 my-3 col-sm-6">
                    <img class="Mineducacion" src="IMG/Mineducacion.webp" alt="Min Educación" title="Min educación">
                </div>
            </div>
        </header>
    </div>

    <div class="container-fluid py-4 my-5">
        <div class="row">
            <div class="col-lg-2">
                <div class="Menu py-2 my-5" id="menuIcon">
                    <nav class="navbar navbar-expand-lg bg-body-tertiary">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul>
                                <!--Iconos de menu-->
                                <li> <a class="icon-menu" href="" title="Perfil">
                                        <ion-icon class="icon" name="person-circle-outline"></ion-icon>
                                    </a>
                                </li>
                                <li> <a class="icon-menu" href="" title="Novedades">
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

            <div class="col-lg-10 py-5 my-5">
                <div class="d-grid gap-2">
                    <button class="register" type="button" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop"><ion-icon name="add-circle-outline"></ion-icon>
                        Registrar novedad</button>
                </div>
                <!-- tablas -->
                <div class="table-container">
                    <div class="table-sofi">
                        <div class="title-container">
                            <span class="title">Novedades</span>
                            <form>
                                <input placeholder="Consultar Novedad" id="value" name="value" type="text">
                                <button><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Funcionario</th>
                                    <th>Tipo de Novedad</th>
                                    <th>Tipo de Articulo</th>
                                    <th>Descripción</th>
                                    <th>Fecha de Creación</th>
                                    <th>Estado de Novedad</th>
                                    <th>ID Prestamo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'PHP/Conexion.php';
                                $querynovedad = "SELECT * FROM novedades";
                                $resultado = mysqli_query($conexion, $querynovedad);
                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo 
                                    "<tr>
                                        <td class='value'>" . $fila['Id_Novedades'] . "</td>
                                        <td class='value'>" . $fila['id_usuario'] . "</td>
                                        <td class='value'>" . $fila['nombre'] . "</td>
                                        <td class='value'>" . $fila['Tipo_Novedad'] . "</td>
                                        <td class='value'>" . $fila['tipo_articulo'] . "</td>
                                        <td class='value'>" . $fila['Descripción'] . "</td>
                                        <td class='value'>" . $fila['Fecha_Creacion'] . "</td>
                                        <td class='value'>" . $fila['Estado_Novedad'] . "</td>
                                        <td class='value'>" . $fila['Prestamo_id_Prestamo'] . "</td>
                                    </tr>";
                                }
                                ?>                  
                            </tbody>
                        </table>
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
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar novedad</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-4">
                                    <form class="form_novedad " action="PHP/registro_novedad.php" method="post">
                                        <label for="tipo_novedad">Tipo de novedad</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <?php
                                            include 'PHP/Conexion.php';
                                            $querytype = "SHOW COLUMNS FROM novedades LIKE 'Tipo_Novedad'";
                                            $result2 = mysqli_query($conexion, $querytype);
                                            $row2 = mysqli_fetch_assoc($result2);
                                            $enum_values = str_replace("'", "", substr($row2['Type'], 5, -1));
                                            $options = explode(",", $enum_values);
                                            foreach ($options as $option) {
                                                echo "<option value='$option'>$option</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="tipo_articulo">Tipo de artículo</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <?php
                                            include 'PHP/Conexion.php';
                                            $querytype2 = "SHOW COLUMNS FROM novedades LIKE 'tipo_articulo'";
                                            $result = mysqli_query($conexion, $querytype2);
                                            $row = mysqli_fetch_assoc($result);
                                            $enum_values2 = str_replace("'", "", substr($row['Type'], 5, -1));
                                            $options2 = explode(",", $enum_values2);
                                            foreach ($options2 as $option2) {
                                                echo "<option value='$option2'>$option2</option>";
                                            }
                                            ?>
                                        </select>
                                        <div class="mb-1">
                                            <label for="exampleFormControlTextarea1"
                                                class="form-label">Descripción</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                name="descripcion"></textarea>
                                        </div>
                                        <label for="tipo_articulo">Estado de novedad</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <?php
                                            include 'PHP/Conexion.php';
                                            $querytype1 = "SHOW COLUMNS FROM novedades LIKE 'Estado_Novedad'";
                                            $result1 = mysqli_query($conexion, $querytype1);
                                            $row1 = mysqli_fetch_assoc($result1);
                                            $enum_values1 = str_replace("'", "", substr($row1['Type'], 5, -1));
                                            $options1 = explode(",", $enum_values1);
                                            foreach ($options1 as $option1) {
                                                echo "<option value='$option1'>$option1</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="id_equipo">ID Prestamo <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1"
                                            placeholder="ID Equipo" name="Equipos_id_equipo" required>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                                        name="save">Guardar</button>
                                    <button type="button" class="btn btn-danger">Cerrar</button>
                                </div>
                            </div>
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
                                            <ion-icon name="logo-facebook"></ion-icon>
                                        </a><a href="#" class="fa fa-instagram">
                                            <ion-icon name="logo-instagram"></ion-icon>
                                        </a>
                                        <a href="#" class="fa f-twitter">
                                            <ion-icon name="logo-twitter"></ion-icon>
                                        </a>
                                        <a href="" class="fa fa-youtube">
                                            <ion-icon name="logo-youtube"></ion-icon>
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
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="js/main.js"> </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

        <script src="JS/main.js"></script>
    </div>
</body>

</html>