'use strict';

let signSettings = {};

window.addEventListener('load', function () {
    let signSettingRequest = new XMLHttpRequest();
    signSettingRequest.open('GET', 'http://gemenity:81/sign-setting.php');

    signSettingRequest.addEventListener('readystatechange', function () {
        if (signSettingRequest.readyState === 4) {
            if (signSettingRequest.status === 200) {
                signSettings = JSON.parse(signSettingRequest.responseText);
                console.log(signSettings);
            } else console.warn('Ошибка запроса!');
        }
    });

    signSettingRequest.send();
});

function calculateRating (data, stash) {
    let servedElves = [];
    let tempGemGiving = {};

    data.forEach((elf) => {
        tempGemGiving[elf.login] = 0;
    });

    stash.forEach(function (gemInStash) {
        let elvesToRating = {};
        if(servedElves.length >= data.length) servedElves = [];

        //найти минимальное количество камней среди всех эльфов
        let minGemAmount = Number.MAX_VALUE;
        data.forEach(function (elf) {
            let currentElf = elf.login;

            elvesToRating[currentElf] = [];

            if (elf.gem_amount + tempGemGiving[currentElf] < minGemAmount) {
                minGemAmount = elf.gem_amount;
            }
        });

        const MAX_RATING = 1;
        const MIN_RATING = 0;

        data.forEach(function (elf) {
            let currentElf = elf.login;
            elvesToRating[currentElf] = [];

            //вычислить рейтинг для каждого эльфа по равномерному распределению
            if (elf.gem_amount === minGemAmount) {
                elvesToRating[currentElf].push(MAX_RATING * signSettings.assign_equally);
            } else elvesToRating[currentElf].push(MIN_RATING * signSettings.assign_equally);

            //рейтинг по соответствию предпочтениям
            if (stash in elf.prefs) {
                elvesToRating[currentElf].push(parseFloat(elf.prefs[gemInStash.type]) * signSettings.assign_prefs);
            } else elvesToRating[currentElf].push(0);

            //рейтинг по раздать по одному
            if (!servedElves.includes(currentElf)) {
                elvesToRating[currentElf].push(MAX_RATING * signSettings.assign_byone);
            }  else elvesToRating[currentElf].push(MIN_RATING * signSettings.assign_byone);
        });

        //найти эльфа с максимальным рейтингом
        let elfForGem;
        let maxRating = 0;

        for (let elfRating in elvesToRating) {
            let currentRating = elvesToRating[elfRating];

            let sumRating = currentRating.reduce((accum, reduc) => accum + reduc);
            if (sumRating >= maxRating) {
                elfForGem = elfRating;
                maxRating = sumRating;
            }
        }

        let gemForElf = document.querySelector('#g' + gemInStash.id);
        gemForElf.value = elfForGem;

        servedElves.push(elfForGem);
        tempGemGiving[elfForGem]++;
    });
}

let elvesToData = [];
const assignButton = document.querySelector('#js-assign-button');
const unassignGems = document.querySelectorAll('.js-unassign-gem');
const manuallyGemInput = document.querySelector('#m-gems');

assignButton.addEventListener('click', function () {
    let elfDataRequest = new XMLHttpRequest();

    elfDataRequest.open('GET', 'http://gemenity:81/elves-data.php');

    elfDataRequest.addEventListener('readystatechange', function () {
        if (elfDataRequest.readyState === 4) {
            if (elfDataRequest.status === 200) {
                elvesToData = JSON.parse(elfDataRequest.responseText);

                let gemStash = [];

                unassignGems.forEach(function (gem) {
                    gemStash.push(
                        {
                            id: parseInt(gem.dataset.gemid),
                            type: parseInt(gem.dataset.gemtype)
                        }
                    );
                });

                calculateRating(elvesToData, gemStash);
                manuallyGemInput.value = '';
            } else console.warn('Ошибка запроса!');
        }
    });

    elfDataRequest.send();
});

unassignGems.forEach((input)=> {
    input.addEventListener('input',()=>{
        const gemId = input.dataset.gemid;
        let tempValue = manuallyGemInput.value;
        let valueArray = tempValue.split(';');

        console.log(valueArray);

        if (!valueArray.includes(gemId)) {
            valueArray.push(gemId);
        }

        manuallyGemInput.value = valueArray.join(';');
    });
});


