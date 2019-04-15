/*
 * Gallery class used for select images and tracking the impression
 * No JS library (e.g. jQuery etc.) used for this test, just pure javascript!
 */
function Gallery(images)
{
    // initialise all image items
    this.initialize = function() {
        let imageRow = document.getElementById('images_row');
        for (let i = 0; i < images.length; i++) {
            let selectedClass = i === 0 ? ' selected_image' : '';
            let thumbnail = document.createElement('div');
            thumbnail.setAttribute('id', 'image_' + (i + 1));
            thumbnail.setAttribute('class', 'image_item' + selectedClass);
            thumbnail.addEventListener('click', selectImage);
            thumbnail.style.backgroundImage = "url('" + images[i].link + "')";
            thumbnail.style.backgroundSize = "contain";
            imageRow.appendChild(thumbnail);
        }

        let numberOfImages = images.length;
        // one image width is 288, borders width 4, space between every one is 20px
        let thumbnailsRowWidth = numberOfImages * 288 + ((numberOfImages - 1) * 20) + numberOfImages * 4;
        imageRow.style.width = thumbnailsRowWidth + 'px';
    };


    // remove class for element
    let removeClass = function(element, className) {
        classes = element.className.split(' ');
        for (let i = 0; i < classes.length; i++) {
            if (classes[i] === className) {
                classes.splice(i, 1);
                i --;
            }
        }

        element.className = classes.join(' ');
    };


    // send tracking data
    let sendTrackingData = function(imageObj) {
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "curl.php", true);
        xhttp.setRequestHeader("Content-type", "application/json; charset=UTF-8");
        xhttp.onload = function () {
            // Ajax request failed
            if (!(xhttp.readyState == 4 && xhttp.status == "200")) {
                alert('Failed to track data');
            }

            let response = JSON.parse(xhttp.responseText);
            // remote request failed for logging tracking data
            if (!response.hasOwnProperty('success') || !response.success) {
                alert('Failed to track data');
            }
        };

        xhttp.send(JSON.stringify(imageObj));
    };


    // update image status, add or remove appropriate class and send tracking data
    let updateImagesStatus = function(from, to) {
        if (from === to) {
            return;
        }

        imgFrom = document.getElementById('image_' + from);
        imgTo = document.getElementById('image_' + to);

        // set 'to' image as selected, 'from' image as unselected
        removeClass(imgFrom, 'selected_image');
        imgTo.className = imgTo.className + ' selected_image';

        if (to === 1) { // disable left arrow if it is the first image
            document.getElementsByClassName('left_arrow')[0].className += ' disable';
        } else if(to === images.length) { // disable right arrow if it is the last image
            document.getElementsByClassName('right_arrow')[0].className += ' disable';
        } else { // enable left arrow and right arrow if not first or last image
            removeClass(document.getElementsByClassName('left_arrow')[0], 'disable');
            removeClass(document.getElementsByClassName('right_arrow')[0], 'disable');
        }

        sendTrackingData(images[to - 1]);
    };


    // select image
    let selectImage = function() {
        let classes = this.className.split(' ');
        let fromOrder = null;
        let toOrder = null;

        // if an image item clicked
        if (classes.indexOf('image_item') >= 0) {
            let fromId = document.getElementsByClassName('selected_image')[0].getAttribute('id');
            fromOrder = parseInt(fromId.replace('image_', ''));
            toOrder = parseInt(this.getAttribute('id').replace('image_', ''));
        } else if(classes.indexOf('right_arrow') >= 0 && classes.indexOf('disable') < 0) { // if right arrow clicked
            let fromId = document.getElementsByClassName('selected_image')[0].getAttribute('id');
            fromOrder = parseInt(fromId.replace('image_', ''));
            toOrder = fromOrder + 1;
        } else if(classes.indexOf('left_arrow') >= 0 && classes.indexOf('disable') < 0) { // if left arrow clicked
            let fromId = document.getElementsByClassName('selected_image')[0].getAttribute('id');
            fromOrder = parseInt(fromId.replace('image_', ''));
            toOrder = fromOrder - 1;
        }

        updateImagesStatus(fromOrder, toOrder);
    };


    // listen to click event of all images and left, right arrows
    let elements = document.querySelectorAll(".right_arrow, .left_arrow");
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", selectImage);
    }
}