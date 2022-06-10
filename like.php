<?
	if (isset($_COOKIE[session_name()]))
	{
		session_start();
	}

	include "configurations/db.php";
	
	$query = "SELECT id, Name, Surname, Institute, Course, Age, Photo FROM users WHERE Token = '".$_COOKIE["token"]."'";
	$result = mysqli_query($link,$query);
	$profile = mysqli_fetch_assoc($result);
	
	$query = "SELECT users.id, users.Name, users.Surname, users.Institute, users.Course, users.Photo FROM requests JOIN users ON users.id = ToUser WHERE FromUser = '".$profile['id']."' AND IsAnswered = 0";
	$result = mysqli_query($link,$query);
	$counter = 0;
	while ($res = mysqli_fetch_assoc($result))
	{
		$outgoing[$counter] = $res;
		if ($outgoing[$counter]["Photo"]!="")
		{
			$outgoing[$counter]["Photo"] = "images/avatars/".$outgoing[$counter]['Photo'];
		}
		else $outgoing[$counter]["Photo"] = "images/no_avatar.jpg";
		$counter++;
	}
	
	$query = "SELECT users.id, users.Name, users.Surname, users.Institute, users.Course, users.Photo FROM requests JOIN users ON users.id = FromUser WHERE ToUser = '".$profile['id']."' AND IsAnswered = 0";
	$result = mysqli_query($link,$query);
	$counter = 0;
	while ($res = mysqli_fetch_assoc($result))
	{
		$incoming[$counter] = $res;
		if ($incoming[$counter]["Photo"]!="")
		{
			$incoming[$counter]["Photo"] = "images/avatars/".$incoming[$counter]['Photo'];
		}
		else $incoming[$counter]["Photo"] = "images/no_avatar.jpg";
		$counter++;
	}
	
	$query = "SELECT users.id, users.Name, users.Surname, users.Link, users.Photo FROM requests JOIN users ON users.id = FromUser WHERE ToUser = '".$profile['id']."' AND IsAnswered = 1 AND Answer = 1";
	$result = mysqli_query($link,$query);
	$counter = 0;
	while ($res = mysqli_fetch_assoc($result))
	{
		$reciprocity[$counter] = $res;
		if ($reciprocity[$counter]["Photo"]!="")
		{
			$reciprocity[$counter]["Photo"] = "images/avatars/".$reciprocity[$counter]['Photo'];
		}
		else $reciprocity[$counter]["Photo"] = "images/no_avatar.jpg";
		$counter++;
	}
	$query = "SELECT users.id, users.Name, users.Surname, users.Link, users.Photo FROM requests JOIN users ON users.id = ToUser WHERE FromUser = '".$profile['id']."' AND IsAnswered = 1 AND Answer = 1";
	$result = mysqli_query($link,$query);
	while ($res = mysqli_fetch_assoc($result))
	{
		$reciprocity[$counter] = $res;
		if ($reciprocity[$counter]["Photo"]!="")
		{
			$reciprocity[$counter]["Photo"] = "images/avatars/".$reciprocity[$counter]['Photo'];
		}
		else $reciprocity[$counter]["Photo"] = "images/no_avatar.jpg";
		$counter++;
	}
	
	if ($profile["Photo"]!="")
	{
		$photo = "images/avatars/".$profile['Photo'];
	}
	else $photo = "images/no_avatar.jpg";

	
	if (isset($_GET['likeID']))
	{
		$query = "UPDATE requests SET IsAnswered = 1, Answer = 1 WHERE ToUser = '".$profile["id"]."' AND FromUser= '".$_GET['likeID']."'";
		$result = mysqli_query($link,$query);
		header ("Location: like.php");
	}
	
	if (isset($_GET['dislikeID']))
	{
		$query = "UPDATE requests SET IsAnswered = 1, Answer = 0 WHERE ToUser = '".$profile["id"]."' AND FromUser= '".$_GET['dislikeID']."'"; 
		$result = mysqli_query($link,$query);
		header ("Location: like.php");
	}
	
	if (isset($_GET['exit']) && $_GET['exit']==true)
	{
		$query = "UPDATE users SET Token = NULL WHERE Token = '".$_COOKIE["token"]."'"; 
		$result = mysqli_query($link,$query);
		setcookie(session_name(), "", time()-3600, "/");
		session_destroy;
		header ("Location: index.php");
	}
	
	mysqli_close($link);
?>
<!doctype html>
<html lang="ru">
	<head>
		<link rel="icon" href="./images/logo.png" type="image/x-icon"> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<title>Лайки</title>
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
				border-top:none;
			}
			.shadow{
				border: 2px;
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
				margin-top:50px;
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
				max-width:100%;
			}
			.card{
				margin-left:auto;
				margin-right:auto;
				padding:0;
				margin-bottom:20px;
				width: 400px; 
				border-radius:20px;
				border-color: white;
				height: 550px;
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
			.page-link{
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
			.card-text{
				
				font-size: 22px;
				Color:#323c8d;
			}
			.card-img-top{
				width:250px;
				height:250px;
				border-radius:20px;
			}
			.card1{
				margin-left:auto;
				margin-right:auto;
				padding:0;
				width: 400px; 
				height: 300px;
				border-radius:20px;
			}
			.card1-img-top{
				width:300px;
				height:300px;
				border-radius:20px;
			}
			.card-body1{
				padding-top:17px;

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
					<p class="navbar-brand" style="margin-top: 1%;margin-right:3%;font-size: 16px">«NMSTU - LOVE»<br>Сервис знакомств<br>МГТУ им. Г.И. Носова</p>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link" href="./index.php">ГЛАВНАЯ</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="./profile.php">МОЙ ПРОФИЛЬ</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link" href="./search.php">ПОИСК ЗНАКОМСТВ</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link" href="?exit=true" style="background-color: white; color:#323c8d; border-radius:12px"><b>ВЫХОД</b></a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="color1">
		<div class="kim">
		<h2 class="kim4">ЛАЙКИ</h2>
		<div>
			<div class="row">
				<div class="card">
					<p style="margin-top: 1%;text-align:left;font-size: 26px; color:#323c8d; margin-left:15px;">ПОСТУПИВШИЕ ЛАЙКИ</p>
					<?if($_GET['viewMode'] == 1 && !empty($incoming)){ 
						$i = isset($_GET['view'])? $_GET['view']: 0;
					?>
						<img src="<?=$incoming[$i]['Photo']?>" class="card-img-top" alt="...">
						<p class="card-text"><b>Имя:</b> <?echo $incoming[$i]['Name']?></p>
						<p class="card-text"><b>Фамилия:</b> <?echo $incoming[$i]['Surname']?></p>
						<p class="card-text"><b>Институт:</b> <?echo $incoming[$i]['Institute']?></p>
						<p class="card-text"><b>Курс:</b> <?echo $incoming[$i]['Course']?></p>
						<div class="mb-3">
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?likeID=<?=$incoming[$i]['id']?>'">Лайк ♥</button>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?dislikeID=<?=$incoming[$i]['id']?>'">Дизлайк X</button>
						</div>
						<div class="mb-3">
							<?if ($i>0){?><button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=1&view=<?=($i-1)?>'"><<</button><?}?>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='like.php'">Выйти из просмотра</button>
							<?if ($i+1<count($incoming)){?><button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=1&view=<?=($i+1)?>'">>></button><?}?>
						</div>
					<?}
					else{?>
						<div class="card-body">
							<p class="card-text"><b>Вам поставили лайков:</b> <?echo empty($incoming)? 0: count($incoming);?></p>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=1'">Просмотреть</button>
						</div>
					<?}?>
				</div>
				<div class="card1">
					<p style="margin-top: 1%;text-align:left;font-size: 26px; color:#323c8d">ПОСТАВЛЕННЫЕ ЛАЙКИ</p>
					<div class="card-body1">
						<?if ($_GET['viewMode'] == 2 && !empty($outgoing)){ 
						$i = isset($_GET['view'])? $_GET['view']: 0;
					?>
						<img src="<?=$outgoing[$i]['Photo']?>" class="card-img-top" alt="...">
						<p class="card-text"><b>Имя:</b> <?echo $outgoing[$i]['Name']?></p>
						<p class="card-text"><b>Фамилия:</b> <?echo $outgoing[$i]['Surname']?></p>
						<p class="card-text"><b>Институт:</b> <?echo $outgoing[$i]['Institute']?></p>
						<p class="card-text"><b>Курс:</b> <?echo $outgoing[$i]['Course']?></p>
						<div class="mb-3">
							<?if ($i>0){?><button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=2&view=<?=($i-1)?>'"><<</button><?}?>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='like.php'">Выйти из просмотра</button>
							<?if ($i+1<count($outgoing)){?><button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=2&view=<?=($i+1)?>'">>></button><?}?>
						</div>						
					<?}
					else{?>
						<div class="card-body1">
							<p class="card-text" style="margin-top: -15px;margin-right:20px;"><b>Вы поставили лайков:</b> <?echo empty($outgoing)? 0: count($outgoing);?></p>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px;" onClick="window.location.href ='?viewMode=2'">Просмотреть</button>
						</div>
					<?}?>
					</div>
				</div>
				<div class="card">
					<p style="margin-top: 1%;text-align:left;font-size: 26px; color:#323c8d">ВЗАИМНЫЕ ЛАЙКИ</p>
					<div class="card-body1">
						<?if ($_GET['viewMode'] == 3 && !empty($reciprocity)){ 
						$i = isset($_GET['view'])? $_GET['view']: 0;
					?>
						<img src="<?=$reciprocity[$i]['Photo']?>" class="card-img-top" alt="...">
						<p class="card-text"><b>Имя:</b> <?echo $reciprocity[$i]['Name']?></p>
						<p class="card-text"><b>Фамилия:</b> <?echo $reciprocity[$i]['Surname']?></p>
						<p class="card-text"><b>Ссылка:</b> <?echo $reciprocity[$i]['Link']?></p>
						<div class="mb-3">
							<?if ($i>0){?><button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=3&view=<?=($i-1)?>'"><<</button><?}?>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='like.php'">Выйти из просмотра</button>
							<?if ($i+1<count($reciprocity)){?><button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?viewMode=3&view=<?=($i+1)?>'">>></button><?}?>
						</div>						
					<?}
					else{?>
						<div class="card-body1">
							<p class="card-text" style="margin-top: -15px;margin-right:20px;"><b>Взаимных лайков:</b> <?echo empty($reciprocity)? 0: count($reciprocity);?></p>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px;" onClick="window.location.href ='?viewMode=3'">Просмотреть</button>
						</div>
					<?}?>
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