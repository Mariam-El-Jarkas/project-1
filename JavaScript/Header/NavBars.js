document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menuToggle");
  const mainNav = document.getElementById("mainNav");
  const dropdowns = document.querySelectorAll(".dropdown");

  // Check screen width and toggle menu accordingly
  function checkScreenWidth() {
    if (window.innerWidth <= 992) {
      menuToggle.style.display = "block";
    } else {
      menuToggle.style.display = "none";
      mainNav.classList.remove("active");
      menuToggle.classList.remove("active");
    }
  }

  // Initial check
  checkScreenWidth();

  // Check on resize
  window.addEventListener("resize", checkScreenWidth);

  // Toggle menu
  menuToggle.addEventListener("click", function () {
    this.classList.toggle("active");
    mainNav.classList.toggle("active");
    // // Toggle body overflow when menu is open
    // if (mainNav.classList.contains("active")) {
    //   document.body.style.overflow = "hidden";
    // } else {
    //   document.body.style.overflow = "";
    // }
  });

  // Mobile dropdown functionality
  dropdowns.forEach((dropdown) => {
    const link = dropdown.querySelector("a");

    link.addEventListener("click", function (e) {
      if (window.innerWidth <= 992) {
        e.preventDefault();
        dropdown.classList.toggle("active");
      }
    });
  });
  console.log("NavBars.js loaded");
});
