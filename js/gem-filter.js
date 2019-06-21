'use strict';

const gemFilter = document.querySelector('#gem-filter');
// const dateInput = document.querySelector('#js-date');
// const textInput = document.querySelector('#js-text');
// const typeSelector = document.querySelector('#js-type');
// const statusSelector = document.querySelector('#js-status');

const fields = {
    dateInput: document.querySelector('#js-date'),
    textInput: document.querySelector('#js-text'),
    typeSelector: document.querySelector('#js-type'),
    statusSelector: document.querySelector('#js-status')
};

function hideAllFields (fields) {
    for (let field in fields) {
        fields[field].style.display = 'none';
    }
}

function showField(field) {
    fields[field].style.display = 'initial';
}

const initialVisible = 'textInput';

for (let field in fields) {
    if (field != initialVisible) {
        fields[field].style.display = 'none';
    }
}

gemFilter.addEventListener('change', function () {
    switch (gemFilter.value) {
        case 'elf'  :
        case 'dwarf' :
        case 'master-dwarf' :
            hideAllFields(fields);
            showField('textInput');
            break;
        case 'assign-before' :
        case 'assign-after' :
        case 'confirmed-before' :
        case 'confirmed-after':
            hideAllFields(fields);
            showField('dateInput');
            break;
        case 'type' :
            hideAllFields(fields);
            showField('typeSelector');
            break;
        case 'status' :
            hideAllFields(fields);
            showField('statusSelector');
            break;
    }
});