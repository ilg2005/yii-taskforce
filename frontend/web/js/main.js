'use strict';

var openModalLinks = document.querySelectorAll(".open-modal");
var closeModalLinks = document.querySelectorAll(".form-modal-close");
var cancelModalButtons = document.querySelectorAll(".cancel-modal");
var overlay = document.querySelector(".overlay");

function closeModal() {
    var modal = document.querySelector('.show');
    modal.classList.remove("show");
    overlay.classList.remove("show");

    /*
      window.location.href = "/";
    */

    /*var inputElements = enterFormElement.querySelectorAll("input");
    for(var i = 0; i < inputElements.length; i++) {
      inputElements[i].value = "";
    }

    var errorFields = document.querySelectorAll('.has-error');
    for(var i = 0; i < errorFields.length; i++) {
      errorFields[i].classList.remove("has-error");
    }*/

    /*enterFormElement.reset();*/

    /*var errorMessages = modal.querySelectorAll(".text-danger");
    for(var i = 0; i < errorMessages.length; i++) {
      errorMessages[i].innerText = "";
    }*/
}


for (var i = 0; i < openModalLinks.length; i++) {
    var modalLink = openModalLinks[i];

    modalLink.addEventListener("click", function (evt) {
        var modalId = evt.currentTarget.getAttribute("data-for");

        var modal = document.getElementById(modalId);
        modal.classList.add("show");
        overlay.classList.add("show");

    });
}

for (var j = 0; j < cancelModalButtons.length; j++) {
    var cancelModalButton = cancelModalButtons[j];

    cancelModalButton.addEventListener("click", closeModal);
}


for (var k = 0; k < closeModalLinks.length; k++) {
    var closeModalLink = closeModalLinks[k];

    closeModalLink.addEventListener("click", closeModal)
}


var starRating = document.getElementsByClassName("completion-form-star");

if (starRating.length) {
    starRating = starRating[0];
    var starElements = starRating.querySelectorAll('span');

    starRating.addEventListener("click", function (evt) {

        starElements.forEach(function (starElement) {
            starElement.classList.add('star-disabled');
        });

        var rating = 0;

        for (var i = 0; i < starElements.length; i++) {
            var starElement = starElements[i];

            if (starElement.nodeName === "SPAN") {
                starElement.className = "";
                rating++;
            }

            if (starElement === evt.target) {
                break;
            }
        }

        var inputField = document.getElementById("rating");
        inputField.value = rating;
    });
}

ymaps.ready(init);
function init() {
    var map = document.getElementById("map");
    var myMap = new ymaps.Map("map", {
        center: [55.76, 37.64],
        zoom: 14
    });
}
