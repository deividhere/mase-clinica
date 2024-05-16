function toggleNavbar() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

function showPass() {
    var pass1 = document.getElementById('password');

    if (pass1.type === "password") {
        pass1.type = "text";
        pass2.type = "text";
      } else {
        pass1.type = "password";
        pass2.type = "password";
      }
}
