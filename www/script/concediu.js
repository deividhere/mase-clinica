const goodColor = "#91ea91";
const badColor = "#fe9d9d";

function beginDateChanged() {
    var beginDate = document.getElementById("dataIncepere");
    var endDate = document.getElementById("dataSfarsit");

    endDate.min = beginDate.value;
    endDate.value = beginDate.value;
    endDate.max = new Date("2100-01-01");
}

function endDateChanged() {
    var beginDate = document.getElementById("dataIncepere");
    var endDate = document.getElementById("dataSfarsit");

    error = document.getElementById("errDataSfarsit");

    const diffTime = Math.abs(new Date(endDate.value) - new Date(beginDate.value));
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays < 1) {
        error.style.color = badColor;
        error.innerHTML = "Concediul trebuie să fie de cel puțin două zile.";
        
        return false;
    }
    else {
        endDate.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function registerClicked() {
    var endDate = document.getElementById("checkDataSfarsit");

    if (!endDateChanged()) {
        endDate.scrollIntoView();
        endDate.classList.add('highlight');
        setTimeout(function() { 
            endDate.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    document.getElementById('concediuForm').submit();
}