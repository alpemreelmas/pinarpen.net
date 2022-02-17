document.querySelector(".open-nav").addEventListener("click", () => {
    document.querySelector("nav").classList.toggle("d-flex");
    document.querySelector(".open-nav").classList.toggle("d-none");
    document.querySelector("main").classList.toggle("d-none");
})
document.querySelector(".close-nav").addEventListener("click", () => {
    document.querySelector("nav").classList.toggle("d-flex");
    document.querySelector(".open-nav").classList.toggle("d-none");
    document.querySelector("main").classList.toggle("d-none");
})