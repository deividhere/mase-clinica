const goodColor = "#91ea91";
const badColor = "#fe9d9d";

function checkFirstPass() {
    var pass1 = document.getElementById('pass1');

    var message1 = document.getElementById('errPass1');
    
    if (pass1.value.length == 0) {
        pass1.style.backgroundColor = badColor;
        message1.style.color = badColor;
        message1.innerHTML = "The password field is empty!";
        return false;
    }
    else if (pass1.value.length < 8) {
        pass1.style.backgroundColor = badColor;
        message1.style.color = badColor;
        message1.innerHTML = "The password must be at least 8 characters long!";
        return false;
    }
    else {
        pass1.style.backgroundColor = goodColor;
        message1.style.color = goodColor;
        message1.innerHTML = "The password is valid.";
        return true;
    }
}

function checkSecondPass() {
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');

    var message2 = document.getElementById('errPass2');

    if (pass2.value.length == 0) {
        pass2.style.backgroundColor = badColor;
        message2.style.color = badColor;
        message2.innerHTML = "The password field is empty!";
        return false;
    }
    else if (pass2.value.length < 8) {
        pass2.style.backgroundColor = badColor;
        message2.style.color = badColor;
        message2.innerHTML = "The password must be at least 8 characters long!";
        return false;
    }

    if (pass1.value != pass2.value) {
        pass2.style.backgroundColor = badColor;
        message2.style.color = badColor;
        message2.innerHTML = "Passwords do not match!";

        return false;
    } else {
        pass2.style.backgroundColor = goodColor;
        message2.style.color = goodColor;
        message2.innerHTML = "Passwords Match.";

        return true;
    }
}

function checkFirstName() {
    var first = document.getElementById("firstname");

    var error = document.getElementById("errFirst");

    if (first.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "First name can't be empty.";
        
        return false;
    }
    else {
        first.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function checkLastName() {
    var last = document.getElementById("lastname");

    var error = document.getElementById("errLast");

    if (last.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Last name can't be empty.";

        return false;
    }
    else {
        last.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";
        
        return true;
    }
}

function checkEmail() {
    var email = document.getElementById("email");

    var error = document.getElementById("errMail");

    var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;

    if (regMail.test(email.value) == false || email.value.length == 0)
    {
        error.style.color = badColor;
        error.innerHTML = "E-mail address is not valid.";
        return false;
    }
    else
    {
        email.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "E-mail address is valid.";
        return true;
    }
}

function checkTerms() {
    var terms = document.getElementById("terms");

    var error = document.getElementById("errTerms");

    if (!terms.checked) {
        terms.classList.remove('highlight');
        error.style.color = badColor;
        error.innerHTML = "You must agree to the terms of service.";
        return false;
    }
    else {
        error.style.color = goodColor;
        error.innerHTML = "";
        return true;
    }
}

// the user hits the register button
function register_click() {
    var first = document.getElementById("firstname");
    var last = document.getElementById("lastname");
    var email = document.getElementById("email");
    var pass1 = document.getElementById("pass1");
    var pass2 = document.getElementById("pass2");
    var terms = document.getElementById("terms");
    var checkDiv = document.getElementById("checkDiv");

    // validate names
    if (!checkFirstName()) {
        first.scrollIntoView();
        first.classList.add('highlight');
        setTimeout(function() { 
            first.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    if (!checkLastName()) {
        last.scrollIntoView();
        last.classList.add('highlight');
        setTimeout(function() { 
            last.classList.remove('highlight'); }, 
            2000
        );

        return;
    }
    
    // validate e-mail address
    if (!checkEmail()) {
        email.scrollIntoView();
        email.classList.add('highlight');
        setTimeout(function() { 
            email.classList.remove('highlight'); }, 
            2000
        );

        return;
    }

    // validate password
    if (!checkFirstPass()) {
        pass1.scrollIntoView();
        pass1.classList.add('highlight');
        setTimeout(function() { 
            pass1.classList.remove('highlight'); }, 
            2000
        );

        return;
    }

    if (!checkSecondPass()) {
        pass2.scrollIntoView();
        pass2.classList.add('highlight');
        setTimeout(function() { 
            pass2.classList.remove('highlight'); }, 
            2000
        );

        return;
    }

    // check if terms and conditions are checked
    if (!checkTerms()) {
        checkDiv.scrollIntoView();
        checkDiv.classList.add('highlight');
        setTimeout(function() { 
            checkDiv.classList.remove('highlight'); }, 
            2000
        );

        return;
    }

    var account = document.querySelector('input[name="account"]:checked').value == 1 ? "Medic" : "Pacient" ;

    window.alert(
        "Account: " + account + " " + document.querySelector('input[name="account"]:checked').value + "\n" +
        "First name: " + first.value + "\n" +
        "Last name: " + last.value + "\n" +
        "Email: " + email.value + "\n" +
        "Pass1: " + pass1.value + "\n" +
        "Pass2: " + pass2.value + "\n" +
        "Terms: " + terms.value + "\n" +
        "Registration successful!"
    );
}