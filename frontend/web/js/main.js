'use strict';

var openModalLinks = document.querySelectorAll(".open-modal");
var closeModalLinks = document.querySelectorAll(".form-modal-close");
var overlay = document.querySelector(".overlay");

for (var i = 0; i < openModalLinks.length; i++) {
  var modalLink = openModalLinks[i];

  modalLink.addEventListener("click", function (evt) {
    var modalId = evt.currentTarget.getAttribute("data-for");

    var modal = document.getElementById(modalId);
    modal.classList.add("show");
    overlay.classList.add("show");

  });
}

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

for (var i = 0; i < closeModalLinks.length; i++) {
  var closeModalLink = closeModalLinks[i];

  closeModalLink.addEventListener("click", closeModal)
}
if (document.getElementById('close-modal')) {
  document.getElementById('close-modal').addEventListener("click", closeModal);
}

var starRating = document.getElementsByClassName("completion-form-star");

if (starRating.length) {
  starRating = starRating[0];
  var starElements = starRating.querySelectorAll('span');

  starRating.addEventListener("click", function(evt) {

    starElements.forEach(function(starElement) {
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
