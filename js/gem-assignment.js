'use strict';

let elvesToData = [];

function calculateRating () {
    let unassignGems = document.querySelectorAll('.js-unassign-gem');
    let gemStash = [];

    unassignGems.forEach(function (gem) {
        gemStash.push(parseInt(gem.dataset.gemtype));
    });

    console.log(gemStash);

    gemStash.forEach(function (gemInStash) {
        let elvesToRating = {};

        //вычислить рейтинг для каждого эльфа по равномерному распределению

        let minGemAmount = Number.MAX_VALUE;
        elvesToData.forEach(function (elf) {
            let currentElf = elf.login;

            elvesToRating[currentElf] = [];

            if (elf.gem_amount < minGemAmount) {
                minGemAmount = elf.gem_amount;
            }
        });

        const MAX_RATING = 1;
        const MIN_RATING = 0;

        elvesToData.forEach(function (elf) {
            let currentElf = elf.login;
            elvesToRating[currentElf] = [];

            if (elf.gem_amount === minGemAmount) {
                elvesToRating[currentElf].push(MAX_RATING);
            } else elvesToRating[currentElf].push(MIN_RATING);
        });

        //рейтинг по соответствию предпочтениям

        elvesToData.forEach(function (elf) {
            let currentElf = elf.login;
            console.log(elf);
            if (gemStash in elf.prefs) {
                elvesToRating[currentElf].push(parseFloat(elf.prefs[gemInStash]));
            } else elvesToRating[currentElf].push(0);
        });

        //рейтинг по раздать по одному

        let servedElves = [];

        elvesToData.forEach(function (elf) {
            let currentElf = elf.login;

            if (!servedElves.includes(currentElf)) {
                elvesToRating[currentElf].push(MAX_RATING);
            }  else elvesToRating[currentElf].push(MIN_RATING);
        });

        console.log(elvesToRating);
    });
}

window.addEventListener('load', function () {
    let elfDataRequest = new XMLHttpRequest();

    elfDataRequest.open('GET', 'http://gemenity:81/elves-data.php');

    elfDataRequest.addEventListener('readystatechange', function () {
        if (elfDataRequest.readyState === 4) {
            if (elfDataRequest.status === 200) {
                elvesToData = JSON.parse(elfDataRequest.responseText);
                calculateRating();
            } else console.warn('Ошибка запроса!');
        }
    });

    elfDataRequest.send();
});


