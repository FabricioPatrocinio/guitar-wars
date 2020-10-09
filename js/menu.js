// Function for open and close menu
const $btnMenu = document.querySelector(".btn-menu");
const $menu = document.querySelector(".container-menu-reponsive");
const $closeMenu = document.querySelector(".btn-close");

$btnMenu.addEventListener('click', function() {
    $menu.classList.add('open-menu')
})

$closeMenu.addEventListener('click', function() {
    $menu.classList.remove('open-menu')
})

// Function for hiden names input files
var $input = document.querySelector('#screenshot'),
    $fileName = document.querySelector('#file-name');

$input.addEventListener('change', function() {
    $fileName.innerHTML = this.value;
});

// Maxlegth = 7, input type number
// https://jsfiddle.net/DRSDavidSoft/zb4ft1qq/2/
function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}