const goodColor = "#91ea91";
const badColor = "#fe9d9d";

function checkDenumire() {
    var denumire = document.getElementById("denumire");

    var error = document.getElementById("errDenumire");

    if (denumire.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Denumire\" nu poate fi gol.";
        
        return false;
    }
    else {
        denumire.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function checkDescriere() {
    var descriere = document.getElementById("descriere");

    var error = document.getElementById("errDescriere");

    if (descriere.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Descriere\" nu poate fi gol.";
        
        return false;
    }
    else {
        descriere.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function checkProspect() {
    var prospect = document.getElementById("prospect");

    var error = document.getElementById("errProspect");

    if (prospect.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Prospect\" nu poate fi gol.";
        
        return false;
    }
    else {
        prospect.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function checkPret() {
    var pret = document.getElementById("pret");

    var reg = /^\d+\.\d{2}$/;

    var error = document.getElementById("errPret");

    if (reg.test(pret.value) == false || pret.value.length == 0 || pret.value.length > 5) {
        error.style.color = badColor;
        error.innerHTML = "Prețul este incorect.";
        
        return false;
    }
    else {
        pret.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function checkNumeFarmacie() {
    var nume_farmacie = document.getElementById("nume_farmacie");

    var error = document.getElementById("errNumeFarmacie");

    if (nume_farmacie.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Nume farmacie\" nu poate fi gol.";
        
        return false;
    }
    else {
        nume_farmacie.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function checkStoc() {
    var stoc = document.getElementById("stoc");

    var error = document.getElementById("errStoc");

    const regExp = /^\d+$/;

    if (!regExp.test(stoc.value)) {
        error.style.color = badColor;
        error.innerHTML = "Stocul esta invalid.";
        
        return false;
    }
    else {
        stoc.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function registerClicked() {
    var denumire = document.getElementById("denumire");
    var descriere = document.getElementById("descriere");
    var prospect = document.getElementById("prospect");
    var pret = document.getElementById("pret");
    var nume_farmacie = document.getElementById("nume_farmacie");
    var stoc = document.getElementById("stoc");

    if (!checkDenumire()) {
        denumire.scrollIntoView();
        denumire.classList.add('highlight');
        setTimeout(function() { 
            denumire.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    if (!checkDescriere()) {
        descriere.scrollIntoView();
        descriere.classList.add('highlight');
        setTimeout(function() { 
            descriere.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    if (!checkProspect()) {
        prospect.scrollIntoView();
        prospect.classList.add('highlight');
        setTimeout(function() { 
            prospect.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    if (!checkPret()) {
        pret.scrollIntoView();
        pret.classList.add('highlight');
        setTimeout(function() { 
            pret.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    if (!checkNumeFarmacie()) {
        nume_farmacie.scrollIntoView();
        nume_farmacie.classList.add('highlight');
        setTimeout(function() { 
            nume_farmacie.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    if (!checkStoc()) {
        stoc.scrollIntoView();
        stoc.classList.add('highlight');
        setTimeout(function() { 
            stoc.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    document.getElementById('medicamentForm').submit();
}
