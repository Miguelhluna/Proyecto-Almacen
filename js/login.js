// Autor: Miguel Ángel Hernandez Luna
document.getElementById("btn_register").addEventListener("click", register); //Mostrar formulario de login
document.getElementById("btn_login").addEventListener("click", login); //Mostrar formulario de registro
document.addEventListener("DOMContentLoaded", widthPage); //Ejecutar función al cargar la página
window.addEventListener("resize", widthPage); //Ejecutar función al redimensionar la ventana

//Declaración de variables
var container_login_register = document.querySelector(".container_login_register"); //Contenedor de login y registro
var form_login = document.querySelector(".form_login"); //Formulario de login
var form_register = document.querySelector(".form_register"); //Formulario de registro
var box_behind_login = document.querySelector(".box_behind_login"); //Caja trasera de login
var box_behind_register = document.querySelector(".box_behind_register"); //Caja trasera de registro
function widthPage() {
  if (window.innerWidth > 850) {
    box_behind_login.style.display = "block"; //Mostrar caja trasera de login
    box_behind_register.style.display = "block"; //Mostrar caja trasera de registro
  } else {
    box_behind_register.style.display = "block"; //Ocultar caja trasera de login
    box_behind_register.style.opacity = "1"; //Ocultar caja trasera de registro
    box_behind_login.style.display = "none"; //Ocultar caja trasera de login
    form_login.style.display = "block"; //Ocultar caja trasera de login
    form_register.style.display = "none"; //Ocultar caja trasera de login
    container_login_register.style.left = "0px"; //Ocultar caja trasera de login
  }
}
function register() {
  if (window.innerWidth > 850) {
    form_register.style.display = "block"; //Mostrar formregistroulario de
    container_login_register.style.left = "410px"; //Mover contenedor a la derecha
    form_login.style.display = "none"; //Ocultar formulario de login
    box_behind_register.style.opacity = "0"; //Ocultar caja trasera de registro
    box_behind_login.style.opacity = "1"; //Mostrar caja trasera de login
  } else {
    form_register.style.display = "block"; //Mostrar formulario de registro
    container_login_register.style.left = "0px"; //Mover contenedor a la derecha
    form_login.style.display = "none"; //Ocultar formulario de login
    box_behind_register.style.display = "none"; //Ocultar caja trasera de registro
    box_behind_login.style.opacity = "1"; //Mostrar caja trasera de login
    box_behind_login.style.display = "block"; //Mostrar caja trasera de login
  }
}
function login() {
  if (window.innerWidth > 850) {
    container_login_register.style.left = "0px"; //Mover contenedor a la izquierda
    form_login.style.display = "block"; //Mostrar formulario de login
    container_login_register.style.left = "10px"; //Mover contenedor a la izquierda
    form_register.style.display = "none"; //Ocultar formulario de registro
    box_behind_register.style.opacity = "1"; //Mostrar caja trasera de registro
    box_behind_login.style.opacity = "0"; //Ocultar caja trasera de login
  } else {
    container_login_register.style.left = "0px"; //Mover contenedor a la izquierda
    form_login.style.display = "block"; //Mostrar formulario de login
    form_register.style.display = "none"; //Ocultar formulario de registro
    box_behind_register.style.display = "block"; //Mostrar caja trasera de registro
    box_behind_login.style.display = "none"; //Ocultar caja trasera de login
  }
}