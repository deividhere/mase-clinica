function toggleNavbar() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

function showPass() {
    var pass1 = document.getElementById('passwordLogin');

    if (pass1.type === "password") {
        pass1.type = "text";
      } else {
        pass1.type = "password";
      }
}
