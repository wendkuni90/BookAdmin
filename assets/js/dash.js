let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");

closeBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    changeBtnIcon();
});

function changeBtnIcon() {
// Bascule entre les icônes bx-menu et bx-menu-alt-right
    if (sidebar.classList.contains("open")) {
        closeBtn.classList.remove("bx-menu");
        closeBtn.classList.add("bx-menu-alt-right");
    } else {
        closeBtn.classList.remove("bx-menu-alt-right");
        closeBtn.classList.add("bx-menu");
    }
}