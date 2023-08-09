const formularios_ajax = document.querySelectorAll(".formularioAjax");

function enviarFormularioAjax(e) {
  e.preventDefault();

  let enviar = confirm("¿Quieres enviar el formulario?");

  if (enviar == true) {
    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let encabezados = new Headers();

    let config = {
      method: method,
      headers: encabezados,
      mode: "cors",
      cache: "no-cache",
      body: data
    };

    if (method == "POST") {
      encabezados.append("Content-Type", "application/x-www-form-urlencoded");
    }

    fetch(action, config)
      .then((response) => response.text())
      .then((data) => {
        let contenedor = document.querySelector(".form-rest");
        contenedor.innerHTML = data;
      })
      .catch((error) => console.log(error));
  } 
}

formularios_ajax.forEach((formulario) => {
  formulario.addEventListener("submit", enviarFormularioAjax);
});
