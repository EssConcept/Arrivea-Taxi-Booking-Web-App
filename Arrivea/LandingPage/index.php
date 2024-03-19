<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
  display: flex;
  justify-content: center;
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

.section-bnr {
  border-spacing: 30px; 
}

.th{
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

.services-img{
  
}

.services-dsc{
  padding-left:10px;
}

.service1{
  padding-top:10%;
  margin-left:15%;
  padding-bottom:0px;
}
.service2{
  display:flex;
  justify-content:right;
  align-items:right;
  margin-left:30%;
  margin-right:10%;
  margin-top:5%;

}

.services-dsc2{
  padding-left:0px;
  
}

.about-us{
  display:flex;
  justify-content:center;
  align-items:center;
  margin-bottom:100px;
  background-color:#f2f2f2;
  padding-top:30px;
  padding-bottom:50px;
}

.description{
  width:600px;
  padding-right:50px;
  font-weight:300;
}

.th2{
  font-size:40px;
  font-weight:600;
  padding-bottom:30px;
  padding-top:10px;
}

.teamwork{
  padding-left:30px;
}
.subtitle{
  font-weight:600;
  font-size:18px;
  margin-bottom:-20px;
  color:#616161;
}

.sign{
  transform: rotate(-5deg);
}
.ceo{
  padding-top:10px;
}

.faq-section {
    width: 1000px;
    margin: 0 auto;
    padding-top:100px;
    padding-bottom:100px;
}

.faq-item {
    margin-bottom: 20px;
}

.question {
    cursor: pointer;
    font-size: 18px;
    margin: 0;
    padding: 10px;
    background-color: #f0f0f0;
    border-radius: 5px;
}

.answer {
    display: none;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.answer p {
    margin: 0;
}

.question.active + .answer {
    display: block;
}

.faqth{
  font-size:32px;
}

.center-table{
  display: flex;
  justify-content: center;
  width: 100%;
  background-color:#f0f0f0;
  padding-top:40px;
  padding-bottom:20px;
}

.footer{
  padding-top:150px;
}

.jumping-arrow {
  animation: jump 0.5s infinite alternate;
}

@keyframes jump {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-10px);
  }
}

.topbtn{
  display: flex;
  justify-content: center;
  padding-top:15px;
}

.services-img-dashboard{
  padding-right:20px;
}

.service3{
  padding-top:10%;
  margin-left:10%;
  padding-bottom:200px;
}
</style>
<body>
<?php 
    include('header.php');
?>
<div class="container" id="home">
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
  <table border="0px" class="section-bnr">
    <th colspan="3" class="th">Ready-to-go tech solution for taxi businesses</th>
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

<div>
  <table border="0px" class="service1" id="services">
    <tr>
      <td rowspan="3" class="services-img"><img src="service1.png" alt="image" height="500px"width="530px"></td>
    </tr>

    <tr>
      <td class="services-dsc" align="left" width="500px">
        <ul>
          <h1>Quick Booking</h1>
          <li><h4>Effortless Booking:</h4>With a user-friendly interface, booking a taxi takes just a few clicks, making it quick and convenient for users.</li>
          <li><h4>Customizable for All:</h4> Our platform caters to both businesses and individuals, offering customizable features to suit various needs. We've got you covered.</li>
        <li><h4>Seamless Travel:</h4> Relax and enjoy your trip while we handle the logistics.</li>
        </ul>
      </td>
    </tr>    
  </table>
</div>

<div>
  <table border="0px" class="service2">
    <tr>
      <td rowspan="3" class="services-img"><img src="service1.png" alt="image" height="500px" width="530px"></td>
    </tr>

    <tr>
      <td class="services-dsc2" align="left">
      <ul>
        <h1>Driver Availability</h1>
        <li><h4>Instant Driver Connection:</h4>Drivers can easily go online and receive ride requests with a tap.</li>
        <li><h4>Effortless Ordering:</h4>Customers can view and order from the best-priced taxi drivers on a map with ease, simplifying the booking process.</li>
        <li><h4>Convenient Experience for All:</h4> Our platform caters to drivers seeking opportunities and customers in need of efficient transportation solutions, ensuring a seamless experience for all.</li>
      </ul>
    </td>
    </tr>
  </table>
</div>

<div>
  <table border="0px" class="service3">
    <tr>
      <td rowspan="3" class="services-img-dashboard"><img src="dashboard-banner.png" alt="image" height="300px" width="600px"></td>
    </tr>
    <tr>
      <td class="services-dsc" align="left" width="500px">
        <ul>
          <h1>Powerful Dashboard</h1>
          <li><h4>User-friendly dashboard:</h4>The platform offers a user-friendly dashboard designed to simplify business operations.</li>
          <li><h4>Centralized management:</h4>It allows for the seamless management of drivers, customers from one convenient location.</li>
          <li><h4>Real-time data access: </h4>Access to real-time data on rides and drivers enables informed decision-making, facilitating business growth and maximizing potential.</li>
        </ul>
      </td>
    </tr> 
  </table>
</div>


<div>
  <table class="about-us" id="aboutus" border="0px">
    <th colspan="2" class="th2">About us</th>
    <tr>
      <td class="description">
      <h2 class="subtitle">BEHIND THE SCREEN</h2><br><h1>Meet our team</h1><br>ARRIVEA a team of three developers, driven by passion, dedicated to crafting exceptional web solutions that elevate businesses to new heights.Our journey began with a shared vision: to revolutionize the digital landscape through creativity and technical excellence. We take pride in our work and go above and beyond to ensure every project is executed flawlessly. <br><br> Our dedication to your satisfaction doesn't end with the launch of your project. We're here to provide ongoing support and guidance every step of the way, ensuring your digital presence continues to thrive long after implementation.
      </td>

      <td>
        <img src="about.png" height="300px" width="430px" class="teamwork">
      </td>
    </tr>

    <tr>
      <td colspan="2" class="ceo">
          <img src="sign.png" alt="" height="100px" class="sign">
      </td>
    </tr>
  </table>
</div>

<div class="faq-section" id="faq">
    <h2 class="faqth">Frequently Asked Questions:</h2>

    <div class="faq-item">
        <h3 class="question">How do I book a taxi on your platform?</h3>
        <div class="answer">
            <p>Booking a taxi is quick and easy. Firstly, you'll need to create an account to access our services. Once logged in, you'll be directed to a map interface where you can view all available taxi drivers in your area. Additionally, there's a table displaying taxi fares from the lowest to the highest prices, enabling you to make an informed decision. When you're ready to book a taxi, simply click on the marker representing your chosen driver on the map. Then, fill out the required form and confirm your booking – it's as easy as that!</p>
        </div>
    </div>

    <div class="faq-item">
        <h3 class="question">How long does it take to book a taxi?</h3>
        <div class="answer">
            <p>Booking a taxi on our platform typically takes just a few moments, with most users completing the process in <b>2-3 minutes</b>. However, the exact duration may vary depending on your preferences and the time you spend selecting the right taxi driver for your needs. We provide a range of options and information to help you make an informed decision.</p>
        </div>
    </div>

    <div class="faq-item">
        <h3 class="question">Is the platform built for a particular taxi company, or can any taxi company join?</h3>
        <div class="answer">
            <p>Our platform is designed to accommodate taxi companies of all sizes and backgrounds. Whether you're a well-established company or a new player in the industry, you're welcome to join our platform. Our goal is to provide a comprehensive solution that benefits both taxi companies and passengers.</p>
        </div>
    </div>

    <div class="faq-item">
        <h3 class="question">What advantages does the platform offer to taxi companies?</h3>
        <div class="answer">
            <p>Taxi companies benefit from having their dedicated page where they can monitor driver and vehicle activity in real-time. Additionally, they gain access to a comprehensive dashboard showcasing their performance metrics. This includes visual representations such as charts displaying profit over the last 7 days, total distance covered, and the number of completed drives, enabling companies to track their progress effectively.</p>
        </div>
    </div>

    <div class="faq-item">
        <h3 class="question">How quickly can I have my company up and running?</h3>
        <div class="answer">
            <p>Based on the size of the company, it takes a maximum of three days to set up the application and start the business after the signing of the contract and the payments. We have a team all set to meet your needs efficiently without any delays.</p>
        </div>
    </div>
</div>

<div class="footer">
  <table class="center-table">
    <tr>
      <td>©2024 Arrivea. All rights reserved.</td>
    </tr>
    <tr>
      <td class="topbtn"><img src="up.png" class="jumping-arrow" id="scrollToTopBtn"></td>
    </tr>
  </table>
</div>


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

document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('header ul li a[href^="#"]');
            links.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: "smooth"
                        });
                    }
                });
            });
        });



      document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question');
    
    questions.forEach(function(question) {
        question.addEventListener('click', function() {
            question.classList.toggle('active');
        });
    });
});

document.getElementById("scrollToTopBtn").addEventListener("click", function() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});
</script>
</body>
</html>