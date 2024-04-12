<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Slider</title>
<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
}

.slider-container {
  position: relative;
  width: 100%;
  max-width: 1200px;
  margin: auto;
  overflow: hidden;
}

.slider {
  display: flex;
  transition: transform 0.5s ease-in-out; /* Added transition */
}

.slide {
  flex: 0 0 auto;
  width: 100%;
}

.slide img {
  width: 100%;
  height: auto;
}

.prev,
.next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  padding: 10px;
  background-color: rgba(0, 0, 0, 0.5);
  color: #fff;
  border: none;
  cursor: pointer;
}

.prev {
  left: 0;
}

.next {
  right: 0;
}

</style>
</head>
<body>
  <div class="slider-container">
    <div class="slider">
      <div class="slide"><img src="images/img.jpg" alt="Slide 1"></div>
      <div class="slide"><img src="images/img4.jpg" alt="Slide 2"></div>
      <div class="slide"><img src="images/img7.png" alt="Slide 3"></div>
    </div>
    <button class="prev" onclick="prevSlide()">&#10094;</button>
    <button class="next" onclick="nextSlide()">&#10095;</button>
  </div>

  <script>
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const slider = document.querySelector('.slider');

function showSlide(n) {
  if (n < 0) {
    slideIndex = slides.length - 1;
  } else if (n >= slides.length) {
    slideIndex = 0;
  }

  slider.style.transform = `translateX(-${slideIndex * 100}%)`;
}

function nextSlide() {
  showSlide(++slideIndex);
}

function prevSlide() {
  showSlide(--slideIndex);
}

showSlide(slideIndex);

// Change slide every 3 seconds
setInterval(nextSlide, 3000);

  </script>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/style.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="slideshow-container">

<?php
// Include database connection file
require('backends/connection-pdo.php');

// Retrieve all banner images from the database
$sql = 'SELECT image FROM banner_info';

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="banner-section">
    <?php foreach ($arr_all as $image) { ?>
        <div class="mySlides"> <!-- Add the 'mySlides' class here -->
            <img src="<?php echo $image['image']; ?>" alt="Banner Image">
        </div>
    <?php } ?>
</div>


<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>
</div>
<br>

<div style="text-align:center">
<?php
// Output navigation dots based on the number of slides
if ($arr_all) {
    for ($i = 1; $i <= count($arr_all); $i++) {
        echo '<span class="dot" onclick="currentSlide(' . $i . ')"></span>';
    }
}
?>
</div>

<script>
let slideIndex = 0;
let timer;

// Function to start the slideshow
function startSlideshow() {
    // Clear the previous timer
    clearTimeout(timer);
    // Call the showSlides function to display the initial slide
    showSlides();
}

// Function to display the slides
function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (slides.length > 0) { // Check if slides array is not empty
        if (n) {
            slideIndex = n;
        } else {
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        clearTimeout(timer);
        timer = setTimeout(showSlides, 3000); // Change image every 3 seconds
    } else {
        console.error("No slides found");
    }
}

// Function to move to the previous slide
function plusSlides(n) {
    clearTimeout(timer);
    let newIndex = slideIndex + n;
    if (newIndex < 1) {
        newIndex = document.getElementsByClassName("mySlides").length;
    } else if (newIndex > document.getElementsByClassName("mySlides").length) {
        newIndex = 1;
    }
    showSlides(newIndex);
}

// Function to move to a specific slide
function currentSlide(n) {
    clearTimeout(timer);
    showSlides(n);
}

// Call the startSlideshow function to initiate the slideshow
startSlideshow();
</script>

</body>
</html>
