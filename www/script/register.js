const goodColor = "#91ea91";
const badColor = "#fe9d9d";

const regExp = /^\d+$/;

function pacientClicked() {
    divCNP = document.getElementById("divCNP");
    divSex = document.getElementById("divSex");
    divTelefon = document.getElementById("divTelefon");
    divDataNastere = document.getElementById("divDataNastere");
    divAsigurare = document.getElementById("divAsigurare");

    divSpecializare = document.getElementById("divSpecializare");
    divTelefonCabinet = document.getElementById("divTelefonCabinet");

    // check if "pacient" is actually clicked
    if (document.querySelector('input[name="account"]:checked').value == 0) {
        // show patient fields 
        divCNP.style.display = "block";
        divSex.style.display = "block";
        divTelefon.style.display = "block";
        divDataNastere.style.display = "block";
        divAsigurare.style.display = "block";

        // hide medic fields
        divSpecializare.style.display = "none";
        divTelefonCabinet.style.display = "none";
    }
}

function medicClicked() {
    divCNP = document.getElementById("divCNP");
    divSex = document.getElementById("divSex");
    divTelefon = document.getElementById("divTelefon");
    divDataNastere = document.getElementById("divDataNastere");
    divAsigurare = document.getElementById("divAsigurare");

    divSpecializare = document.getElementById("divSpecializare");
    divTelefonCabinet = document.getElementById("divTelefonCabinet");

    // check if "medic" is actually clicked
    if (document.querySelector('input[name="account"]:checked').value == 1) {
        // hide patient fields 
        divCNP.style.display = "none";
        divSex.style.display = "none";
        divTelefon.style.display = "none";
        divDataNastere.style.display = "none";
        divAsigurare.style.display = "none";

        // show medic fields
        divSpecializare.style.display = "block";
        divTelefonCabinet.style.display = "block";
    }
}

function checkFirstPass() {
    var pass1 = document.getElementById('pass1');

    var message1 = document.getElementById('errPass1');
    
    if (pass1.value.length == 0) {
        pass1.style.backgroundColor = badColor;
        message1.style.color = badColor;
        message1.innerHTML = "Câmpul pentru parolă este gol!";
        return false;
    }
    else if (pass1.value.length < 8) {
        pass1.style.backgroundColor = badColor;
        message1.style.color = badColor;
        message1.innerHTML = "Parola trebuie să aibă cel puțin 8 caractere!";
        return false;
    }
    else {
        pass1.style.backgroundColor = goodColor;
        message1.style.color = goodColor;
        message1.innerHTML = "Parola este validă.";
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
        message2.innerHTML = "Câmpul pentru parolă este gol!";
        return false;
    }
    else if (pass2.value.length < 8) {
        pass2.style.backgroundColor = badColor;
        message2.style.color = badColor;
        message2.innerHTML = "Parola trebuie să aibă cel puțin 8 caractere!";
        return false;
    }

    if (pass1.value != pass2.value) {
        pass2.style.backgroundColor = badColor;
        message2.style.color = badColor;
        message2.innerHTML = "Parolele nu sunt la fel!";

        return false;
    } else {
        pass2.style.backgroundColor = goodColor;
        message2.style.color = goodColor;
        message2.innerHTML = "Parolele sunt la fel.";

        return true;
    }
}

function showPass() {
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');

    if (pass1.type === "password") {
        pass1.type = "text";
        pass2.type = "text";
      } else {
        pass1.type = "password";
        pass2.type = "password";
      }
}

function checkFirstName() {
    var first = document.getElementById("firstname");

    var error = document.getElementById("errFirst");

    if (first.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Prenume\" nu poate fi gol.";
        
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
        error.innerHTML = "Câmpul \"Nume\" nu poate fi gol.";

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
        error.innerHTML = "Adresa de e-mail nu este validă.";
        return false;
    }
    else
    {
        email.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "Adresa de e-mail este validă.";
        return true;
    }
}

function checkTerms() {
    var terms = document.getElementById("terms");

    var error = document.getElementById("errTerms");

    if (!terms.checked) {
        terms.classList.remove('highlight');
        error.style.color = badColor;
        error.innerHTML = "Trebuie să fii de acord cu termenii serviciului.";
        return false;
    }
    else {
        error.style.color = goodColor;
        error.innerHTML = "";
        return true;
    }
}

function checkCNP() {
    var CNP = document.getElementById("cnp");

    var error = document.getElementById("errCNP");

    if (!regExp.test(CNP.value)) {
        error.style.color = badColor;
        error.innerHTML = "CNP-ul trebuie să conțină doar cifre.";

        return false;
    }
    else if (CNP.value.length < 13) {
        error.style.color = badColor;
        error.innerHTML = "CNP-ul este prea scurt.";

        return false;
    }
    else if (CNP.value.length > 13) {
        error.style.color = badColor;
        error.innerHTML = "CNP-ul este prea lung.";

        return false;
    }
    else if (!CNP.value.startsWith('1') && 
                !CNP.value.startsWith('2') && 
                !CNP.value.startsWith('5') && 
                !CNP.value.startsWith('6')) {
        error.style.color = badColor;
        error.innerHTML = "CNP-ul începe cu o cifră invalidă.";

        return false;
    }
    else {
        var year = '';

        if (CNP.value.startsWith('1') || CNP.value.startsWith('2')) {
            year = '19';
        }
        else if (CNP.value.startsWith('5') || CNP.value.startsWith('6')) {
            year = '20';
        }
        else {
            error.style.color = badColor;
            error.innerHTML = "CNP-ul începe cu o cifră invalidă.";

            return false;
        }

        year = year + CNP.value.substring(1,3);
        var month = CNP.value.substring(3,5);
        var day = CNP.value.substring(5,7);

        var date = month + "/" + day + "/" + year;

        if (!isDateValid(date)) {
            error.style.color = badColor;
            error.innerHTML = "CNP-ul conține o dată de naștere incorectă.";

            return false;
        }
        else {
            // change other fields accordingly
            var masculin = document.getElementById("masculin");
            var feminin = document.getElementById("feminin");

            if (CNP.value.startsWith('1') || CNP.value.startsWith('5')) {
                masculin.checked = true;
            }
            else if (CNP.value.startsWith('2') || CNP.value.startsWith('6')) {
                feminin.checked = true;
            }
            else {
                return false;
            }

            var date = year + "-" + month + "-" + day;
            dataNastere.value = date;
        }

        CNP.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";
        
        return true;
    }
}

function isDateValid(dateStr) {
    return !isNaN(new Date(dateStr));
}

function checkTelefon() {
    var telefon = document.getElementById("telefon");

    var error = document.getElementById("errTelefon");

    if (!regExp.test(telefon.value)) {
        error.style.color = badColor;
        error.innerHTML = "Numărul de telefon trebuie să conțină doar cifre.";

        return false;
    }
    else {
        telefon.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";
        
        return true;
    }
}

function checkSpecializare() {
    var specializare = document.getElementById("specializare");

    var error = document.getElementById("errSpecializare");

    if (specializare.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Specializare\" nu poate fi gol.";

        return false;
    }
    else {
        specializare.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";
        
        return true;
    }
}

function checkTelefonCabinet() {
    var telefonCabinet = document.getElementById("telefonCabinet");

    var error = document.getElementById("errTelefonCabinet");

    if (!regExp.test(telefonCabinet.value)) {
        error.style.color = badColor;
        error.innerHTML = "Numărul de telefon de cabinet trebuie să conțină doar cifre.";

        return false;
    }
    else {
        telefonCabinet.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";
        
        return true;
    }
}

// the user hits the register button
function registerClicked() {
    var first = document.getElementById("firstname");
    var last = document.getElementById("lastname");
    var email = document.getElementById("email");
    var pass1 = document.getElementById("pass1");
    var pass2 = document.getElementById("pass2");
    var terms = document.getElementById("terms");
    var checkDiv = document.getElementById("checkDiv");
    var CNP = document.getElementById("cnp");
    var telefon = document.getElementById("telefon");
    var specializare = document.getElementById("specializare");
    var telefonCabinet = document.getElementById("telefonCabinet");

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

    var account = document.querySelector('input[name="account"]:checked').value;

    // account == 0 -> pacient
    // account == 1 -> medic

    // if pacient
    if (account == 0) {
        // check CNP
        if (!checkCNP()) {
            CNP.scrollIntoView();
            CNP.classList.add('highlight');
            setTimeout(function() { 
                CNP.classList.remove('highlight'); }, 
                2000
            );

            return;
        }

        // check telefon
        if (!checkTelefon()) {
            telefon.scrollIntoView();
            telefon.classList.add('highlight');
            setTimeout(function() { 
                telefon.classList.remove('highlight'); }, 
                2000
            );

            return;
        }
    }
    // else medic
    else {
        // check specializare
        if (!checkSpecializare()) {
            specializare.scrollIntoView();
            specializare.classList.add('highlight');
            setTimeout(function() { 
                specializare.classList.remove('highlight'); }, 
                2000
            );

            return;
        }
        
        // check telefon cabinet
        if (!checkTelefonCabinet()) {
            telefonCabinet.scrollIntoView();
            telefonCabinet.classList.add('highlight');
            setTimeout(function() { 
                telefonCabinet.classList.remove('highlight'); }, 
                2000
            );

            return;
        }
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

    // var account = document.querySelector('input[name="account"]:checked').value == 1 ? "Medic" : "Pacient" ;
    // 
    // window.alert(
    //     "Account: " + account + " " + document.querySelector('input[name="account"]:checked').value + "\n" +
    //     "First name: " + first.value + "\n" +
    //     "Last name: " + last.value + "\n" +
    //     "Email: " + email.value + "\n" +
    //     "Pass1: " + pass1.value + "\n" +
    //     "Pass2: " + pass2.value + "\n" +
    //     "Terms: " + terms.value + "\n" +
    //     "Registration successful!"
    // );

    document.getElementById('fileForm').submit();
}