<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrivea</title>
</head>
<style>

body {
  margin: auto;
  margin-top:10px;
  padding: 0;
  height: 100%;
  width:100%;
  overflow-x:hidden;
}
.container {
  z-index: 1; 
  padding-left: 27.5%;
  padding-bottom:100px;
}

*{
  box-sizing:border-box;
}

.slideshow-container {
  width: 850px;
  position: relative;
}

.mySlides {
  display: none;
}

.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: 0px;
  padding: 10px;
  color: black;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition:  0.3s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

.banner1{
  height:500px;
  position: relative;
  width:100%;
  background: #f2f2f2;
  margin-top:0px;
  padding-bottom:320px;
  padding-top:100px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;  
}
.banner1::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 5px;
}
.con-btns{
  text-align: center;
}

table {
  border-spacing: 30px; 
}

table th{
  padding-top:250px;
  font-size:36px;
  font-weight:600;
  padding-bottom:30px;
}

.icons{
  margin: 0 auto; 
  background-color: #FFF94E; 
  border-radius:30px;
  width:50px;
  height:40px;
}

.icons img{
  transform:translateX(7.5px);
}
.title {
  text-align: center; 
  font-weight:500;
  font-size:20px;
}

.dsc{
  font-size:14px;
  padding: 20px;
  margin: 0;
  transform:translateY(-25px);
}

.services{

}


</style>
<body>
<?php 
    include('header.php');
?>
<div class="container">
  <div class="slideshow-container">
    <div class="mySlides fade">
      <img src="img2.png" style="width:100%; height:650px" >
    </div>

    <div class="mySlides fade">
      <img src="img1.png" style="width:100%">
    </div>

    <div class="mySlides fade">
      <img src="img3.png" style="width:100%">
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>


    <div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
  </div>
  </div>
  
</div>
<section class="banner1">
  <table border="0px">
    <th colspan="3">Ready-to-go tech solution for taxi businesses</th>
    <tr>
      <td><div class="icons"><img src="internet.png" alt="" style="width:30px; height:30px"></div></td>
      <td><div class="icons"><img src="calendar.png" alt="" style="width:30px; height:30px"></div></td>
      <td><div class="icons"><img src="analytics.png" alt="" style="width:30px; height:30px"></div></td>
    </tr>
    <tr>
      <td class="title">Customized for your needs</td>
      <td class="title">Book your taxi in seconds</td>
      <td class="title">Get supervision of employees</td>
    </tr>

    <tr>
      <td class="dsc" align="center" width="300px">We provide quick bookings.<br> Businesses can gain valuable insights into employee performance.<br> All customized for your brand.</td>
      <td class="dsc" align="center" width="300px">With just a few clicks, you can book a taxi in seconds. Our user-friendly interface and efficient system make the entire process easy.</td>
      <td class="dsc" align="center" width="300px">Improve your business with our easy-to-use dashboard. Track your drivers in real-time, see which cars they're using, and get key details.</td>
    </tr>
  </table>
</section>
<table class="services">
  <table>
    <tr>
      <td><table>
        <th></th>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td></td>
        </tr>
      </table></td>
    </tr>
  </table>
</table>

<script>

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
</script>
</body>
</html>