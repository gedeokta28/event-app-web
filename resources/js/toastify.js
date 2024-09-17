import Toastify from "toastify-js";

window.Toastify = Toastify;

const showToast = (message, callback = () => {}) => {
    Toastify({
        text: message,
        duration: 16000,
        close: true,
        gravity: "bottom", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "#2C74B3",
            color: "#fff",
        },
        onClick: callback, // Callback after click
    }).showToast();
};

window._showToast = showToast;
