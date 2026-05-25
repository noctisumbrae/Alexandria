const formularios = document.querySelectorAll("form");

formularios.forEach((formulario) => {
    formulario.addEventListener("submit", () => {
        const botao = formulario.querySelector("button");

        if (botao) {
            botao.disabled = true;
            botao.textContent = "Processando...";
        }
    });
});
