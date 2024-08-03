const button = document.querySelector(
    '[data-collapse-toggle="navbar-dropdown"]'
);
const botonCategorias = document.querySelector(
    '[data-dropdown-toggle="dropdownCategorias"]'
);
const botonEdiciones = document.querySelector(
    '[data-dropdown-toggle="dropdownEdiciones"]'
);
const botonUser = document.querySelector('[data-dropdown-toggle="dropdownUser"]');

const menu = document.getElementById("navbar-dropdown");
const menuCategorias = document.getElementById("dropdownCategorias");
const menuEdiciones = document.getElementById("dropdownEdiciones");
const menuUser = document.getElementById("dropdownUser");

button.addEventListener("click", function () {
    menu.classList.toggle("hidden");
});

botonCategorias.addEventListener("click", function (event) {
    const buttonRect = botonCategorias.getBoundingClientRect();

    if (window.innerWidth < 768) {
        menuCategorias.style.top = `${buttonRect.bottom}px`;
        menuCategorias.style.left = "0";
        menuCategorias.style.width = "100%";
    } else {
        const navRect = document.querySelector("nav").getBoundingClientRect();
        const menuWidth = navRect.width * 0.1; // Ancho ajustado

        menuCategorias.style.top = `${buttonRect.bottom}px`;
        menuCategorias.style.left = `${buttonRect.left}px`; // Ajuste de posición a la izquierda del botón
        menuCategorias.style.width = `${menuWidth}px`;
    }

    menuCategorias.classList.toggle("hidden");
});

botonEdiciones.addEventListener("click", function (event) {
    const buttonRect = botonEdiciones.getBoundingClientRect();

    if (window.innerWidth < 768) {
        menuEdiciones.style.top = `${buttonRect.bottom}px`;
        menuEdiciones.style.left = "0";
        menuEdiciones.style.width = "100%";
    } else {
        const navRect = document.querySelector("nav").getBoundingClientRect();
        const menuWidth = navRect.width * 0.1; // Ancho ajustado

        menuEdiciones.style.top = `${buttonRect.bottom}px`;
        menuEdiciones.style.left = `${buttonRect.left}px`; // Ajuste de posición a la izquierda del botón
        menuEdiciones.style.width = `${menuWidth}px`;
    }

    menuEdiciones.classList.toggle("hidden");
});

botonUser.addEventListener("click", function(event) {
    const buttonRect = botonUser.getBoundingClientRect();

    if (window.innerWidth < 768) {
        menuUser.style.top = `${buttonRect.bottom}px`;
        menuUser.style.left = "0";
        menuUser.style.width = "100%";
    } else {
        const navRect = document.querySelector("nav").getBoundingClientRect();
        const menuWidth = navRect.width * 0.1; // Ancho ajustado

        menuUser.style.top = `${buttonRect.bottom}px`;
        menuUser.style.left = `${buttonRect.left}px`; // Ajuste de posición a la izquierda del botón
        menuUser.style.width = `${menuWidth}px`;
    }

    menuUser.classList.toggle("hidden");
});

document.addEventListener("click", function (event) {
    const isClickInsideMenuCategorias = menuCategorias.contains(event.target);
    const isClickOnButtonCategorias = event.target === botonCategorias;
    const isClickInsideEdiciones = menuEdiciones.contains(event.target);
    const isClickOnButtonEdiciones = event.target === botonEdiciones;
    const isClickInsideMenuUser = menuUser.contains(event.target);
    const isClickOnButtonUser = event.target === botonUser;

    if (!isClickInsideMenuCategorias && !isClickOnButtonCategorias) {
        menuCategorias.classList.add("hidden");
    }
    if (!isClickInsideEdiciones && !isClickOnButtonEdiciones) {
        menuEdiciones.classList.add("hidden");
    }
    if (!isClickInsideMenuUser && !isClickOnButtonUser) {
        menuUser.classList.add("hidden");
    }
});

function descargarPDF() {
    // Crea un enlace invisible
    var enlace = document.createElement("a");
    enlace.href = ""; // Reemplaza 'ruta/al/archivo.pdf' con la URL del archivo PDF
    enlace.download = "ReglamentoMitaiCup.pdf"; // Establece el nombre del archivo
    document.body.appendChild(enlace);
    enlace.click();
    document.body.removeChild(enlace);
}
