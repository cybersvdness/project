<?
	if (isset($_COOKIE[session_name()]))
	{
		session_start();
	}
	if (isset($_GET['exit']) && $_GET['exit']==true)
	{
		include "configurations/db.php";
		$query = "UPDATE users SET Token = NULL WHERE Token = '".$_COOKIE["token"]."'"; 
		$result = mysqli_query($link,$query);
		mysqli_close($link);
		setcookie(session_name(), "", time()-3600, "/");
		session_destroy;
		header ("Location: index.php");
	}
?>
<!doctype html>
<html lang="ru">
	<head>
		<link rel="icon" href="./images/logo.png" type="image/x-icon"> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<title>NMSTU-LOVE</title>
		<style>
			.center > nav > ol{
				margin-top:25px;
			}
			.list > ul > li{
				border-right:none;
				border-left:none;
			}
			.list > ul > li#first{
				background:lightgray;
				border-top:none;
			}
			.list > ul > li#third{
				border-bottom:none;
			}
			.list > ul > li#second{
				background:lightgray;
				border-top:none;
			}
			.color{
				background-color:white;
				background-size:cover;
				height:1200px;
			}
			.shadow{
				border: 2px solidgray;
				box-shadow: 1 1 10 px rgba(1,1,1,1);
			}
			.kim > .kim1{
				margin-top: 100px;
				text-align: center;
				font-size:55px;
				margin-bottom:10px;
				color:#323c8d;
			}
			.color1 > .kim > .kim4{
				text-align: center;
				font-size:40px;
				margin-bottom:80px;
				color:#323c8d;
			}
			.kim > h2{
				margin-top:120px;
			}
			.kim > .kim5{
				margin-top: 150px;
				text-align: center;
				font-size:40px;
				margin-bottom:20px;
				color:#323c8d;
			}
			.kim > .kim6{
				margin-top: 100px;
				text-align: center;
				font-size:40px;
				margin-bottom:20px;
				color:#323c8d;
			}
			.kim > .kim2{
				color:#323c8d;
				text-align: center;
				font-size:20px;
			}
			.row{
				margin-left:0;
				max-width:100%;
			}
			.card{
				margin-left:auto;
				margin-right:auto;
				padding:0;
				margin-bottom:20px;
			}
			.accord{
				margin-bottom:50px;
				magin-top:1000px;
			}
			.slaid{
				width: 1200px;
				margin-left:auto;
				margin-right:auto;
				margin-top: 100px;
			}
			.pagination{
				margin-right:auto;
				margin-left:auto;
				width:295px;
				margin-top:20px;
			}
			.page-item > a:hover{
				background-color:#3a5e84;
				color:white;
			}
			.luxe > a:hover{
				background-color:#3a5e84;
				color:white;
			}
			.comfort > a:hover{
				background-color:#3a5e84;
				color:white;
			}
			.econom > a:hover{
				background-color:#3a5e84;
				color:white;
			}
			.page-link {
				background-color:white;
				color:#3a5e84;
			}
			.list{
				margin-top:30px;
				margin-left:auto;
				margin-right:auto;
				width:900px;
				height:400px;
				text-align:center;	
			}
			.list-group-item{
				height:80px;
				width:300px;
			}
			.breadcrumb > li > a{
				color:white;
			}
			.row > div:hover{
				cursor:pointer;
				transform: scale(1.05);
				transition: transform .1s;
				border: 2px solidgray;
				box-shadow: 1 1 10 px rgba(1,1,1,1);
			}
			.position-fixed{
				opacity:0.1;
			}
			.position-fixed:hover{
				opacity:1;
			}
			.under-footer{
				margin-top: 5px;
				padding: 20px 0;
				display: flex;
				justify-content: space-between;
				align-items: center;
				border-top: 1px solid #323c8d;
			}
			.under-footer__text{
				font-weight: 600;
				font-size: 16px;
				Color:#323c8d;
			}
			.futicon-box{
				display: flex;
			}
			.futicon-box__item{
				box-sizing: content-box;
				background-color: rgba(223, 223, 223, 0.685);
				border-radius: 50%;
				padding: 10px;
				width: 15px;
				margin:  0 10px;
			}
			.footer{
				margin-top: 30px;
				padding: 20px 100px;
			}
			.container-fluid{
				background-color: #323c8d;
			}
		</style>
	</head>
	<body>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
  
		<div class="color">
			<nav class="navbar navbar-expand-lg navbar-dark">
				<div class="container-fluid">
					<img src="images/logo.png" style="border-radius:50px; width: 5%; padding-right: 1%" class="d-block w-150" alt="...">
					<p class="navbar-brand" style="margin-right:3%;font-size: 16px; margin-top:1%">«NMSTU - LOVE»<br>Сервис знакомств<br>МГТУ им. Г.И. Носова</p>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="./index.php">ГЛАВНАЯ</a>
							</li>
							<?if (isset($_COOKIE[session_name()])){?>
							<li class="nav-item">
								<a class="nav-link" href="./profile.php">МОЙ ПРОФИЛЬ</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link" href="./search.php">ПОИСК ЗНАКОМСТВ</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link" href="?exit=true" style="background-color: white; color:#323c8d; border-radius:12px"><b>ВЫХОД</b></a>
							</li>
							<?}
							else{?>
							<li class="nav-item">
								<a class="nav-link" href="./authorization.php">ВХОД</a>
							</li>
							<?}?>
						</ul>
					</div>
				</div>
			</nav>
			<div class="kim">
				<h1 class="kim1">СЕРВИС ЗНАКОМСТВ «NMSTU - LOVE»</h1>
				<p class="kim2">
				Добро пожаловать на сервис знакомств «NMSTU - LOVE»! Найди новых собеседников, друзей, и даже свою любовь в МГТУ им. Г.И. Носова.</p>
			</div>
			<div class="slaid">
				<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
					</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="images/слайдер2.png" style="border-radius:50px;" class="d-block w-150" alt="...">
							<div class="carousel-caption d-none d-md-block">
								<h5 style="color: #3a5e84; border:2px solid; background-color:#323c8d; border-radius:20px; padding:10px; font-size:20px; color: white">Удобный способ знакомства</h5>
							</div>
						</div>
						<div class="carousel-item">
							<img src="images/слайдер1.png" style="border-radius:50px;" class="d-block w-100" alt="...">
							<div class="carousel-caption d-none d-md-block">
								<h5 style="color: #3a5e84; border:2px solid; background-color:#323c8d; border-radius:20px; padding:10px; font-size:20px; color: white">Приятное общение</h5>
							</div>
						</div>
						<div class="carousel-item">
							<img src="images/слайдер3.png" style="border-radius:50px;" class="d-block w-100" alt="...">
							<div class="carousel-caption d-none d-md-block">
								<h5 style="color: #3a5e84; border:2px solid; background-color:#323c8d; border-radius:20px; padding:10px; font-size:20px; color: white">Незабываемые эмоции</h5>
							</div>
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Предыдущий</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Следующий</span>
					</button>
				</div>
			</div>
		</div>
		<div class="color1">
		<div class="kim">
		<h2 class="kim4">ИСПОЛЬЗУЯ НАШ СЕРВИС,<br>ВЫ СМОЖЕТЕ ОСУЩЕСТВЛЯТЬ</h2>
		<div>
			<div class="row">
				<div class="card" style="width: 29rem; border-radius:20px;">
					<img src="images/1.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">Создать анкету, содержащую информацию о Вас, которая будет видна другим пользователям нашего сервиса и, ориентируясь на которую, они смогут принимать решение начинать общение с Вами.</p>
					</div>
				</div>
				<div class="card" style="width: 29rem; border-radius:20px;">
					<img src="images/2.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">Просматривать на сервисе NMSTU-LOVE анкеты других пользователей, которые содержат информацию о них и, ориентируясь на которые, Вы сами сможете принимать решение начинать общение с ними.</p>
					</div>
				</div>
			</div>
			<footer class="footer">
			<div class="under-footer">
				<p class="under-footer__text">&copy NMSTU-LOVE</p>
				<div class="futicon-box">
					<img src="./images/facebook-app-symbol.png" alt="" class="futicon-box__item">
					<img src="./images/twitter.png" alt="" class="futicon-box__item">
					<img src="./images/youtube.png" alt="" class="futicon-box__item">
				</div>
			</div>
		</div>
	</body>
</html>