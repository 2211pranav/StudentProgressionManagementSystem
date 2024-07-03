

let btn = document.querySelector(".fa-bars");
let sidebar = document.querySelector(".sidebar");

btn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});
 // Toggle submenu
let arrows = document.querySelectorAll(".arrow");
for (let i = 0; i < arrows.length; i++) {
  arrows[i].addEventListener("click", (e) => {
    let arrowParent = e.target.parentElement.parentElement;
    arrowParent.classList.toggle("show");
  });
}







