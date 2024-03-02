// Array of image URLs
var imageUrls = [
  "Images/photo-1563841930606-67e2bce48b78.avif",
  "Images/image2.avif",
  "Images/image3.jpg",
  "Images/image4.avif"
  
  // Add more image URLs as needed
];

// Get the image element
var imageElement = document.getElementById("aboutImage");

// Counter to track the current image index
var currentImageIndex = 0;

// Function to change the image
function changeImage() {
  // Set the src attribute of the image element to the next image URL
  imageElement.src = imageUrls[currentImageIndex];

  // Increment the currentImageIndex
  currentImageIndex++;

  // Reset the index if it exceeds the length of the imageUrls array
  if (currentImageIndex >= imageUrls.length) {
    currentImageIndex = 0;
  }
}

// Change the image every 3 seconds (adjust the interval as needed)
setInterval(changeImage, 3000);