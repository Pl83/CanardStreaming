function openNav() {
    document.querySelector("#mySidenav").classList.add("side-active");
    document.querySelector(".menu-overlay").classList.add("menu-overlay-active");
}

document.querySelector('.menu-overlay').addEventListener('click', function(){
    closeNav()
})
function closeNav() {
    document.querySelector("#mySidenav").classList.remove("side-active");
    document.querySelector(".menu-overlay").classList.remove("menu-overlay-active");
}