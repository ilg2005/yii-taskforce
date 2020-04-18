var openModalLinks = document.querySelectorAll(".open-modal");
var closeModalLinks = document.querySelectorAll(".form-modal-close");
var overlay = document.querySelector(".overlay");
var enterFormElement = document.querySelector("#login");

for (var i = 0; i < openModalLinks.length; i++) {
  var modalLink = openModalLinks[i];

  modalLink.addEventListener("click", function (event) {
    var modalId = event.currentTarget.getAttribute("data-for");

    var modal = document.getElementById(modalId);
    modal.classList.add("show");
    overlay.classList.add("show");

  });
}

function closeModal(event) {
  var modal = event.currentTarget.parentElement;

  modal.classList.remove("show");
  overlay.classList.remove("show");

  window.location.href = "/";

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

document.getElementById('close-modal').addEventListener("click", closeModal);

var starRating = document.getElementsByClassName("completion-form-star");

if (starRating.length) {
  starRating = starRating[0];

  starRating.addEventListener("click", function(event) {
    var stars = event.currentTarget.childNodes;
    var rating = 0;

    for (var i = 0; i < stars.length; i++) {
      var element = stars[i];

      if (element.nodeName === "SPAN") {
        element.className = "";
        rating++;
      }

      if (element === event.target) {
        break;
      }
    }

    var inputField = document.getElementById("rating");
    inputField.value = rating;
  });
}
