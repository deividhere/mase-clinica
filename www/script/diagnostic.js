const goodColor = "#91ea91";
const badColor = "#fe9d9d";

function fetchMedicines() {
    // Simulating an API call to fetch medicines in stock
    // allMedicines = [
    //     { id: 1, name: 'Medicine A', stock: 10, pharmacy: 'Pharmacy 1' },
    //     { id: 2, name: 'Medicine B', stock: 5, pharmacy: 'Pharmacy 2' },
    //     { id: 3, name: 'Medicine C', stock: 3, pharmacy: 'Pharmacy 3' }
    // ];
    allMedicines = JSON.parse(document.getElementById("sqlResult").textContent);
    addMedicineRow(false);
}

function getSelectedMedicines() {
    return Array.from(document.querySelectorAll('select.medicine-select'))
        .map(select => parseInt(select.value));
}

function reNumberSelects() {
    // Selects
    var selects = document.querySelectorAll('select.medicine-select');

    var i = 0;

    selects.forEach (select => {
        select.id = "medicineNumber" + i;
        select.name = "medicineNumber" + i;
        i++;
    });

    // Quantities
    var quantities = document.querySelectorAll('input.medicine-quantity');

    i = 0;

    quantities.forEach (quantity => {
        quantity.id = "medicineQuantity" + i;
        quantity.name = "medicineQuantity" + i;
        i++;
    });


}

function updateSelectOptions() {
    const selectedMedicines = getSelectedMedicines();
    const selects = document.querySelectorAll('select.medicine-select');

    selects.forEach(select => {
        const currentValue = parseInt(select.value);
        while (select.options.length > 0) {
            select.remove(0);
        }

        allMedicines.forEach(medicine => {
            if (!selectedMedicines.includes(medicine.id) || medicine.id === currentValue) {
                const option = document.createElement('option');
                option.value = medicine.id;
                option.textContent = `${medicine.name} - ${medicine.stock} ${medicine.pharmacy}`;
                if (medicine.id === currentValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            }
        });
    });
}

function addMedicineRow(isDeletable = true) {
    const selectedMedicines = getSelectedMedicines();
    const availableMedicines = allMedicines.filter(medicine => !selectedMedicines.includes(medicine.id));

    if (availableMedicines.length === 0) {
        alert('Nu mai sunt alte medicamente disponibile.');
        return;
    }

    const container = document.getElementById('retetaContainer');
    const row = document.createElement('div');
    row.className = 'row mb-2 gx-2 w-100 mx-auto';
    row.id = 'medicineList';

    const col_6 = document.createElement('div');
    col_6.className = 'col-6';

    const select = document.createElement('select');
    select.className = 'form-select medicine-select';
    select.required = true;

    availableMedicines.forEach(medicine => {
        const option = document.createElement('option');
        option.value = medicine.id;
        option.textContent = `${medicine.name} - ${medicine.stock} ${medicine.pharmacy}`;
        select.appendChild(option);
    });

    col_6.appendChild(select);

    const col_4 = document.createElement('div');
    if (isDeletable) {
        col_4.className = 'col-3';
    }
    else {
        col_4.className = 'col';
    }

    const quantityInput = document.createElement('input');
    quantityInput.type = 'number';
    quantityInput.min = 1;
    quantityInput.required = true;
    quantityInput.className = 'form-control medicine-quantity';
    quantityInput.placeholder = 'Cantitate';

    col_4.appendChild(quantityInput);

    row.appendChild(col_6);
    row.appendChild(col_4);

    if (isDeletable) {
        const col = document.createElement('div');
        col.className = 'col';

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-outline-danger';
        deleteButton.textContent = 'Șterge';
        deleteButton.onclick = () => {
            document.getElementById("medicineNumber").value--;
            row.remove();
            updateSelectOptions();
            reNumberSelects();
        };

        col.appendChild(deleteButton);
        row.appendChild(col);
    }

    container.appendChild(row);

    select.addEventListener('change', updateSelectOptions);

    container.appendChild(row);
    updateSelectOptions();
    reNumberSelects();

    document.getElementById("medicineNumber").value++;
}

document.getElementById('addMedicineButton').addEventListener('click', () => {
    var error = document.getElementById("errReteta");

    const rows = document.getElementById('retetaContainer').children;

    for (var i = 0; i < rows.length; i++) {
        var element = rows[i];

        const quantityInput = element.querySelector('input[type="number"]');
        if (quantityInput != null) {
            if (!quantityInput.value) {
                error.style.color = badColor;
                error.innerHTML = "Trebuie să completați cantitatea rândului precedent înainte să adăugați alt medicament.";
                
                return false;
            }
        }
        else {
            return false
        }
    }

    error.style.color = goodColor;
    error.innerHTML = "";

    addMedicineRow();
});

function checkQuantities() {
    var error = document.getElementById("errReteta");

    var rows = document.getElementById('retetaContainer').children;
    
    for (var i = 0; i < rows.length; i++) {
        var element = rows[i];

        const quantityInput = element.querySelector('input[type="number"]');
        if (quantityInput != null) {
            if (!quantityInput.value) {
                error.style.color = badColor;
                error.innerHTML = "Completați toate cantitățile înainte de adăugarea diagnosticului.";
                
                return false;
            }
        }
        else {
            return false
        }
    }

    error.style.color = goodColor;
    error.innerHTML = "";

    return true;
}

function checkDiagnostic() {
    var diagnostic = document.getElementById("diagnostic");

    var error = document.getElementById("errDiagnostic");

    if (diagnostic.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Diagnostic\" nu poate fi gol.";
        
        return false;
    }
    else {
        diagnostic.classList.remove('highlight');
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

function checkRecomandari() {
    var recomandari = document.getElementById("recomandari");

    var error = document.getElementById("errRecomandari");

    if (recomandari.value.length == 0) {
        error.style.color = badColor;
        error.innerHTML = "Câmpul \"Recomandari\" nu poate fi gol.";
        
        return false;
    }
    else {
        recomandari.classList.remove('highlight');
        error.style.color = goodColor;
        error.innerHTML = "";

        return true;
    }
}

function registerClicked() {
    var diagnostic = document.getElementById("denumire");
    var descriere = document.getElementById("descriere");
    var recomandari = document.getElementById("recomandari");
    var reteta = document.getElementById("retetaContainer");

    if (!checkDiagnostic()) {
        diagnostic.scrollIntoView();
        diagnostic.classList.add('highlight');
        setTimeout(function() { 
            diagnostic.classList.remove('highlight'); 
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

    if (!checkRecomandari()) {
        recomandari.scrollIntoView();
        recomandari.classList.add('highlight');
        setTimeout(function() { 
            recomandari.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    
    if (!checkQuantities()) {
        reteta.scrollIntoView();
        reteta.classList.add('highlight');
        setTimeout(function() { 
            reteta.classList.remove('highlight'); 
            }, 2000
        );

        return;
    }

    // alert("Totul ok: " + document.getElementById('medicineNumber').value);
    document.getElementById('diagnosticForm').submit();
}
