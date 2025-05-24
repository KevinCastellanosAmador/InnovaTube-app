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

document.addEventListener("DOMContentLoaded", function () {
  // Login
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
          Swal.fire({
            icon: "success",
            title: res.mensaje,
            showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          }).then(() => {
            frm.reset();
            window.location = base_url + "moduloyt";
          });
        } else {
          Swal.fire({
            icon: "warning",
            title: res.mensaje,
            showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          });
        }
      }
    };
  });

  // formaulario de registro
  const frmr = document.querySelector("#registerForm");

  // Registro
  frmr.addEventListener("submit", function (e) {
    e.preventDefault();

    const captchaResponse = grecaptcha.getResponse();
    if (!captchaResponse) {
      Swal.fire({
        icon: "warning",
        title: "Por favor, completa el captcha.",
        showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
      });
      return;
    }

    const contraseña = document.getElementById("contraseña_r").value;
    const confirmacion = document.getElementById("contraseña_rc").value;
    if (contraseña !== confirmacion) {
      Swal.fire({
        icon: "warning",
        title: "Las contraseñas no coinciden",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      });
      return;
    }

    const data = new FormData(frmr);
    data.append("g-recaptcha-response", captchaResponse);

    const http = new XMLHttpRequest();
    const url = base_url + "principal/postUser";

    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo == "success") {
          Swal.fire({
            icon: "success",
            title: res.mensaje,
            showConfirmButton: false,
            ttimer: 2000,
            timerProgressBar: true,
          }).then(() => {
            frmr.reset();
            window.location = base_url + "moduloyt";
          });
        } else {
          Swal.fire({
            icon: res.tipo === "warning" ? "warning" : "error",
            title: res.mensaje,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
          });
          grecaptcha.reset();
        }
      }
    };
  });
});



document.getElementById("forgotPasswordLink").addEventListener("click", (e) => {
  e.preventDefault();
  document.querySelector(".login-form").style.display = "none";
  forgotForm.style.display = "block";
});

document.getElementById("backToLogin").addEventListener("click", (e) => {
  e.preventDefault();
  forgotForm.style.display = "none";
  document.querySelector(".login-form").style.display = "block";
});

const forgotForm = document.querySelector(".forgot-form");
const forgotPasswordLink = document.getElementById("forgotPasswordLink");
const backToLogin = document.getElementById("backToLogin");

forgotPasswordLink.addEventListener("click", (e) => {
    e.preventDefault();
    document.querySelector(".login-form").style.display = "none";
    forgotForm.style.display = "block";
});

backToLogin.addEventListener("click", (e) => {
    e.preventDefault();
    forgotForm.style.display = "none";
    document.querySelector(".login-form").style.display = "block";
});

document.getElementById("forgotForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const data = new FormData(this);
    const http = new XMLHttpRequest();
    const url = base_url + "principal/sendPassword";

    http.open("POST", url, true);
    http.send(data);

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Swal.fire({
                icon: res.tipo,
                text: res.mensaje,
                showConfirmButton: false,
                timer: 2500
            });

            if (res.tipo === "success") {
                document.getElementById("forgotForm").reset();
                forgotForm.style.display = "none";
                document.querySelector(".login-form").style.display = "block";
            }
        }
    };
});