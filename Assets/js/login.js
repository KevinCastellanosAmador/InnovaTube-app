window.addEventListener("load", () => {
  const preloader = document.getElementById("preloader");
  const container = document.querySelector(".container");

  preloader.style.display = "none";
  container.style.display = "flex";
});

document.addEventListener("DOMContentLoaded", () => {
  const formSide = document.querySelector(".form-side");
  const loginBox = document.getElementById("loginBox");
  const showRegister = document.getElementById("showRegister");
  const showLogin = document.getElementById("showLogin");
  const loginForm = document.querySelector(".login-form");
  const registerForm = document.querySelector(".register-form");

  function isMobile() {
    return window.innerWidth <= 768;
  }

  function updateFormsView() {
    if (isMobile()) {
      // Mostrar solo login por defecto
      loginForm.style.display = "block";
      registerForm.style.display = "none";
    } else {
      // Resetear estilos en pantallas grandes
      loginForm.style.display = "";
      registerForm.style.display = "";
    }
  }

  showRegister.addEventListener("click", (e) => {
    e.preventDefault();
    if (isMobile()) {
      loginForm.style.display = "none";
      registerForm.style.display = "block";
    } else {
      formSide.classList.add("show-register");
      loginBox.classList.add("show-register");
    }
  });

  showLogin.addEventListener("click", (e) => {
    e.preventDefault();
    if (isMobile()) {
      loginForm.style.display = "block";
      registerForm.style.display = "none";
    } else {
      formSide.classList.remove("show-register");
      loginBox.classList.remove("show-register");
    }
  });

  // Ejecutar al cargar
  updateFormsView();

  // También cuando se redimensione la pantalla
  window.addEventListener("resize", updateFormsView);
});

//validacion del login
const frm = document.querySelector("#loginForm");
const usuario_l = document.querySelector("#usuario_l");
const contraseña_l = document.querySelector("#contraseña_l");

document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();

    const data = new FormData(frm);
    const http = new XMLHttpRequest();
    const url = base_url + "principal/validateUser";

    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo == "success") {
          window.location = base_url + "errors";
        }
      }
    };
  });
});
