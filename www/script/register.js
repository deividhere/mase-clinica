function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match";

        return true;
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!";
        return false;
    }
}

// validates text only
function Validate(txt) {
    txt.value = txt.value.replace(/[^a-zA-Z-'\n\r.]+/g, '');
}

// validate email
function email_validate(email)
{
    var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;

    if(regMail.test(email) == false)
    {
        document.getElementById("status").innerHTML = "<span id=\"status_span\" class=\"warning\">Email address is not valid yet.</span>";
    }
    else
    {
        document.getElementById("status").innerHTML	= "<span id=\"status_span\" class=\"valid\">The e-mail address is valid!</span>";	
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

    // validate first and last name
    Validate(first);
    Validate(last);

    // validate e-mail address
    email_validate(email);

    // if e-mail is valid, send form
    status_span = document.getElementById("status_span");
    
    // validate password
    // document.getElementById("fileForm").checkValidity();
    if (!inpObj.checkValidity()) {
        document.getElementById("demo").innerHTML = inpObj.validationMessage;
    }

    // check if terms and conditions are checked

    if (status_span.className === "valid") {
        // if everything is okay and email is valid
        // send form
        window.alert("nu esti prost");
    }
    else {
        // e-mail is not valid
        window.alert("esti prost");
    }
}