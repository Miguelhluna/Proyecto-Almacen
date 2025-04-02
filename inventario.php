<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacenista</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <div class="menu container-fluid">
        <ul>
            <li class="fas fa-home"><a href="index.ph">Inicio</a></li>
            <li><a href="news.asp">News</a></li>
            <li><a href="contact.asp">Contact</a></li>
            <li><a href="about.asp">About</a></li>
        </ul>

    </div>




    <div class="container">
        <div class="row">
            <div class="tabla col-lg-12 my-5">
                <button class="register btn btn-outline-success btn-md px-5" type="button"><ion-icon
                        name="add-circle-outline"></ion-icon>Registrar de materiales
                </button>

                <div class="formulario1">
                    <h2>Registrar equipos</h2>
                    <label for="id_equipo">Id</label>
                    <input  type="" id="id_equipo" name="id_eqiipo">

                    <label for="descripcion">Descripcion</label>
                   <textarea name="descripcion" id=""></textarea>

                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado">

                    <label for="novedad">Novedad</label>
                    <input type="text" id="novedad" name="novedad">
                    <input id="registrar" type="submit" value="Registrar" >
                </div>
                <!-- tabla -->

                <div class="d-grid gap-1">
                    <div class="table table-striped table-hover">
                        <div class="border_table">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Tipo articulo</th>
                                        <th scope="col">Disponible</th>
                                        <th scope="col">Fecha de registro</th>
                                        <th scope="col">Novedades</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>15341523</td>
                                        <td>Marcador sharpie</td>
                                        <td>Consumible</td>
                                        <td>50</td>
                                        <td>04/02/2025 7:32 am</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabla col-lg-12my-5">

                <button class="register btn btn-outline-success btn-md px-5" type="button"><ion-icon
                        name="add-circle-outline"></ion-icon>
                    Registrar de materiales
                </button>




                <div class="d-grid gap-1">
                    <div class="table table-striped table-hover">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Tipo articulo</th>
                                    <th scope="col">Disponible</th>
                                    <th scope="col">Fecha de registro</th>
                                    <th scope="col">Novedades</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>15341523</td>
                                    <td>Marcador sharpie</td>
                                    <td>Consumible</td>
                                    <td>50</td>
                                    <td>04/02/2025 7:32 am</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar materiales</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-1">
                    <form class="form_novedad" action="index.php" method="post">
                        <label for="id"> ID </label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion">
                        <label for="tipo_novedad" class="article">Tipo de artículo</label>
                        <select class="form-select" aria-label="Default select example">
                            <?php
                            include 'PHP/Conexion.php';
                            $querytype = "SHOW COLUMNS FROM materiales LIKE 'Tipo_Material'";
                            $result2 = mysqli_query($conexion, $querytype);
                            $row2 = mysqli_fetch_assoc($result2);
                            $enum_values = str_replace("'", "", substr($row2['Type'], 5, -1));
                            $options = explode(",", $enum_values);
                            foreach ($options as $option) {
                                echo "<option value='$option'>$option</option>";
                            }
                            ?>
                        </select>
                        <div class="mb-1">
                            <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="descripcion"></textarea>
                        </div>
                    </form>
                    <div class="form-check form-switch align-items-center">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Reportar novedad</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" name="save">Guardar</button>
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
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="JS/main.js"></script>
    </div>
</body>

</html>