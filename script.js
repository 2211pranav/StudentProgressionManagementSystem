function myMenuFunction() {
    var i = document.getElementById("navMenu");

    if(i.className === "nav-menu") {
        i.className += " responsive";
    } else {
        i.className = "nav-menu";
    }
   }

   var a = document.getElementById("loginBtn");
   var b = document.getElementById("registerBtn");
   var x = document.getElementById("login");
   var y = document.getElementById("register");

   function login() {
       x.style.left = "4px";
       y.style.right = "-520px";
       a.className += " white-btn";
       b.className = "btn";
       x.style.opacity = 1;
       y.style.opacity = 0;
   }

   function register() {
       x.style.left = "-510px";
       y.style.right = "5px";
       a.className = "btn";
       b.className += " white-btn";
       x.style.opacity = 0;
       y.style.opacity = 1;
   }

   document.addEventListener('DOMContentLoaded', function() {
    const lowVisionIcons = document.querySelectorAll('.bx-low-vision');
    
    lowVisionIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('bx-lock-alt');
                this.classList.add('bx-lock-open-alt');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('bx-lock-open-alt');
                this.classList.add('bx-lock-alt');
            }
        });
    });
});

