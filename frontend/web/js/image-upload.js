'use strict';

var uploadAvatarElement = document.querySelector('#upload-avatar');
var avatarImageElement = document.querySelector('.account__redaction-avatar img');

var uploadAvatarElementChangeHandler = function () {
    var selectedFile = uploadAvatarElement.files[0];
    var fileName = selectedFile.name;

    avatarImageElement.src = './img/' + fileName;
};

uploadAvatarElement.addEventListener('change', uploadAvatarElementChangeHandler);

