function openNav() {
    var sidenav = document.getElementById("mySidenav");
    if (sidenav.style.width === "250px") {
        sidenav.style.width = "0";
    } else {
        sidenav.style.width = "250px";
    }
}

// carousel
$(document).ready(function () {
    $(".carousel").slick({
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        arrows: false,
    });
});
