<?
	function translit_sef($value)
	{
		$converter = array(
			'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
			'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
			'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
			'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
			'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
			'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
			'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
		);
	 
		$value = mb_strtolower($value);
		$value = strtr($value, $converter);
		$value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
		$value = mb_ereg_replace('[-]+', '-', $value);
		$value = trim($value, '-');	
	 
		return $value;
	}

	if (isset($_COOKIE[session_name()]))
	{
		session_start();
	}

	include "configurations/db.php";
	
	$query = "SELECT id, Name, Surname, Institute, Course, Age, Photo, Link FROM users WHERE Token = '".$_COOKIE["token"]."'";
	$result = mysqli_query($link,$query);
	$profile = mysqli_fetch_assoc($result);
	
	if ($profile["Photo"]!="")
	{
		$photo = "images/avatars/".$profile['Photo'];
	}
	else $photo = "images/no_avatar.jpg";

	if(($_FILES['photo']['type'] == 'image/jpeg'||$_FILES['photo']['type'] == 'image/png'))
	{
		$uploaddir = 'images/avatars/';
		$uploadfile = translit_sef($profile["Surname"]." ".$profile["Name"]." ".$profile["Institute"]." ".$profile["id"]) . ".jpg";
		$query = "UPDATE users SET Photo = '$uploadfile' WHERE Token = '".$_COOKIE["token"]."'";
		$result = mysqli_query($link,$query);
		$uploadfile = $uploaddir . $uploadfile;
		move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile);
		header ("Location: profile.php");
	}
	
	if (!empty($_POST['name']) || !empty($_POST['surname']) || !empty($_POST['institute']) || !empty($_POST['course']) || !empty($_POST['age']) || !empty($_POST['link']))
	{
		$query = "UPDATE users SET ";
		if (!empty($_POST['name'])) 		$query .= "Name = '".$_POST['name']."'";
		if (!empty($_POST['surname'])) 		$query .= ", Surname = '".$_POST['surname']."'";
		if (!empty($_POST['institute'])) 	$query .= ", Institute = '".$_POST['institute']."'";
		if (!empty($_POST['course'])) 		$query .= ", Course = '".$_POST['course']."'";
		if (!empty($_POST['age'])) 			$query .= ", Age = '".$_POST['age']."'";
		if (!empty($_POST['link'])) 		$query .= ", Link = '".$_POST['link']."'";
		$query .= " WHERE Token = '".$_COOKIE["token"]."'"; 
		$query = str_replace("SET ,", "SET", $query);
		$result = mysqli_query($link,$query);
		header ("Location: profile.php");
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
		<title>Моя анкета</title>
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
				margin-left:0;
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
				width:300px;
				height:300px;
				border-radius:20px;
			}
			.card1{
				margin-left:auto;
				margin-right:auto;
				padding:0;
				margin-bottom:20px;
				width: 500px; 
				border-radius:20px;
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
		<h2 class="kim4">ВАША АНКЕТА</h2>
		<div>
			<div class="row">
				<div class="card">
					<p style="margin-top: 1%;text-align:left;font-size: 26px; color:#323c8d">ФОТОГРАФИЯ</p>
					<?if (isset($_GET['changeMode']) && $_GET['changeMode']==1){?>
						<form class="form1" enctype="multipart/form-data" method="POST" action="">
							<div class="mb-3">
								<label class="form-label">Фото</label>
								<input type="file" class="form-control" name="photo" accept="image/jpeg,image/png" required>
							</div>
							<div class="mb-3">
								<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px">Изменить</button>
							</div>
						</form>
						<div class="mb-3">
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='profile.php'">Отмена</button>
						</div>
					<?}else{?>
						<img src="<?=$photo?>" class="card-img-top" alt="...">
						<div class="card-body">
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?changeMode=1'">Изменить</button>
						</div>
					<?}?>
				</div>
				<div class="card1">
					<p style="margin-top: 1%;text-align:center;font-size: 26px; color:#323c8d">ИНФОРМАЦИЯ</p>
					<div class="card-body">
						<?if (isset($_GET['changeMode']) && $_GET['changeMode']==2){?>
							<form class="form1" method="POST" action="">
								<div class="mb-3">
									<label class="form-label">Имя</label>
									<input type="text" class="form-control" name="name">
								</div>
								<div class="mb-3">
									<label class="form-label">Фамилия</label>
									<input type="text" class="form-control" name="surname">
								</div>
								<div class="mb-3">
									<label class="form-label">Институт</label>
									<input type="text" class="form-control" name="institute">
								</div>
								<div class="mb-3">
									<label class="form-label">Курс</label>
									<input input type="number" class="form-control" min="1" max="5" name="course">
								</div>
								<div class="mb-3">
									<label class="form-label">Возраст</label>
									<input input type="number" class="form-control" min="16" name="age">
								</div>
								<div class="mb-3">
									<label class="form-label">Ссылка</label>
									<input input type="text" class="form-control" value="vk.com/" name="link">
								</div>
								<div class="mb-3">
									<button name="register" type="submit" style=" background-color:#323c8d; font-size:20px; color:white;border-radius:10px">Изменить</button>
								</div>
							</form>
							<div class="mb-3">
								<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='profile.php'">Отмена</button>
							</div>
						<?}else{?>
							<p class="card-text"><b>Имя:</b> <?echo $profile['Name']?></p>
							<p class="card-text"><b>Фамилия:</b> <?echo $profile['Surname']?></p>
							<p class="card-text"><b>Институт:</b> <?echo $profile['Institute']?></p>
							<p class="card-text"><b>Курс:</b> <?echo $profile['Course']?></p>
							<p class="card-text"><b>Возраст:</b> <?echo $profile['Age']?></p>
							<p class="card-text"><b>Ссылка:</b> <?echo $profile['Link']?></p>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href ='?changeMode=2'">Изменить</button>
						<?}?>
					</div>
				</div>
				<div class="card mb-3">
					<p style="margin-top: 1%;text-align:center;font-size: 26px; color:#323c8d">ЛАЙКИ</p>
					<a href="./like.php"  class="nav-link" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px; text-align:center;">Просмотреть</a>
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