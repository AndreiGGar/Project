const cookieBox = document.querySelector(".wrapper"),
    acceptBtn = cookieBox.querySelector("button");

acceptBtn.onclick = () => {
    document.cookie = "CookieBy=PhoenixComps; max-age=" + 60 * 60 * 24 * 30;
    if (document.cookie) {
        cookieBox.classList.add("hide");
    } else {
        alert("¡No se puede establecer la cookie! Por favor, desbloquee este sitio desde la configuración de cookies de su navegador.");
    }
}
let checkCookie = document.cookie.indexOf("CookieBy=PhoenixComps");
checkCookie != -1 ? cookieBox.classList.add("hide") : cookieBox.classList.remove("hide");