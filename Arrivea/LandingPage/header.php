<?php 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&family=Raleway&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        header{
            background-color: white;
            position: fixed;
            top: 0;
            left: 0px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90px;
            transition: 0.6s;
            padding: 0px 50px;  
            z-index: 2;    
            color: white;   
            border-bottom: 1px solid #D4D4D4;      
        }

        header ul{
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        header ul li{
            position: relative;
            list-style: none;

        }

        header ul li a{
            position: relative;
            margin: 0 15px;
            text-decoration: none;
            letter-spacing: 1px;
            font-weight: 600;
            color: black; 
            
        }

        .logo{
            transform:translateX(120px);
        }

        a::after {
            content: "";
            display: block;
            height: 2px;
            width: 0%;
            background-color: black;
            position: absolute;
            bottom: -2px;
            left: 0;
            transition: width 0.2s ease-in-out;
        }
  
        a:hover::after {
            width: 100%;
        }
        button {
            padding: 10px 10px;
            background-color: #FFF94E;
            color: black;
            border-style: none;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: black;
            color:#FFF94E;
        }
    </style>
    <header>
        <img src="arrivea-logo-black.png" height="70px" width="70px" class="logo" alt="logo">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#aboutus">About Us</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><button onclick="redirectToMap()">Book a taxi</button></li>
            <li><button onclick="redirectToBusinessAccount()">Business account</button></li>
        </ul>
    </header>

    <script>
    function redirectToBusinessAccount() {
        window.location.href = "/Projects/Arrivea/login.php";
    }

    function redirectToMap(){
        window.location.href = "/Projects/Arrivea/login.php";
    }
</script>
</html>
