// Get the modal
var modal = document.getElementById("packageGalleryModal");

// Get the button that opens the modal
var btn = document.getElementById("viewAllPhotos");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function () {
modal.style.display = "block";
populateImages(); // Call this function to add images dynamically
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
if (event.target == modal) {
   modal.style.display = "none";
}
}

function populateImages() {
var imagesSlide = document.getElementById('imagesSlide');
imagesSlide.innerHTML = ''; // Clear existing images

otherImages.forEach(function (imagePath, index) {
   var imgElement = document.createElement('img');
   imgElement.src = `${imagePath}`; // Adjust path as needed
   imgElement.alt = "Package Image " + (index + 1);
   imgElement.style.width = "100%";
   imagesSlide.appendChild(imgElement);
});

// Show the first image or handle visibility as needed
if (otherImages.length > 0) {
   changeSlide(1);
}
}

var slideIndex = 1;

function changeSlide(n) {
var slides = document.querySelectorAll('#imagesSlide img');
if (n > slides.length) {
   slideIndex = 1;
}
if (n < 1) {
   slideIndex = slides.length;
}
for (var i = 0; i < slides.length; i++) {
   slides[i].style.display = "none";
}
slides[slideIndex - 1].style.display = "block";
}

document.querySelector('.next').addEventListener('click', function () {
changeSlide(slideIndex += 1);
});

document.querySelector('.prev').addEventListener('click', function () {
changeSlide(slideIndex -= 1);
});
