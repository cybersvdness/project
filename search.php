<?
	date_default_timezone_set('Asia/Yekaterinburg');
	include "configurations/db.php";
	if (isset($_COOKIE[session_name()]))
	{
		session_start();
	}
	
	$url = $_SERVER['REQUEST_URI'];
	$url = str_replace("page=".$_GET['page'], "", $url);
	$url .= preg_match("/\?/", $url)? "&": "?";
	$url = str_replace("&&", "&", $url);
	
	$query = "SELECT id, Name, Surname, Institute, Course, Age, Gender, Photo FROM users WHERE Token = '".$_COOKIE["token"]."'";
	$result = mysqli_query($link,$query);
	$profile = mysqli_fetch_assoc($result);
	
	$query = "SELECT id, Name, Surname, Institute, Course, Photo FROM users WHERE id != '".$profile['id']."' AND id NOT IN (SELECT ToUser FROM requests WHERE FromUser = '".$profile['id']."') AND id NOT IN (SELECT FromUser FROM requests WHERE ToUser = '".$profile['id']."')";
	if (!empty($_GET['institute']) || !empty($_GET['course']) || !empty($_GET['gender']))
	{
		if(!empty($_GET['institute'])) $query .= " AND Institute = '".$_GET['institute']."'";
		if(!empty($_GET['course'])) $query .= " AND Course = '".$_GET['course']."'";
		if(!empty($_GET['gender'])) $query .= " AND Gender = '".$_GET['gender']."'";
	}
	$result = mysqli_query($link,$query);
	$counter = 0;
	
	while($res = mysqli_fetch_assoc($result))
	{
		$profiles[$counter] = $res;
		if ($profiles[$counter]["Photo"]!="")
		{
			$profiles[$counter]["Photo"] = "images/avatars/".$profiles[$counter]['Photo'];
		}
		else $profiles[$counter]["Photo"] = "images/no_avatar.jpg";
		$counter++;
	}
	
	if (isset($_GET['liked']))
	{
		$query = "INSERT INTO requests (FromUser, ToUser, Date, Time) VALUES ('".$profile['id']."','".$profiles[$_GET['liked']]['id']."','".date('Y-m-d')."','".date('h:i:s')."')";
		$result = mysqli_query($link,$query);
		header ("Location: search.php");
	}
	
	function GetAmountOfPages($size)
	{
		$pages = 1;
		while ((int)(($size-1)/3)!=0)
		{
			$pages++;
			$size -= 3;
		}
		return $pages;
	}	

	$size = count($profiles);
	if (isset ($_GET["page"]))
	{
		$page = $_GET["page"];
	}
	else $page = 1;
	$startnum = 3*($page-1);
	$endnum = 3 * $page < $size? 3 * $page: $size;		
	
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
		<title>Поиск знакомств</title>
		<style>
			.center > nav > ol {
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
			.shadow{
				border: 2px solidgray;
				box-shadow: 1 1 10 px rgba(1,1,1,1);
			}
			.form
			{
				margin-right:auto;
				margin-left:auto;
				margin-top: 50px;
				margin-bottom: 50px;
				width:1300px;
				background-color:#323c8d;
				border:2px solid lightgray;
				border-radius:10px;
				height:150px;
			}
			.mb-3
			{
				margin-top:10px;
				display: inline-block;
			}
			.form > .mb-3
			{
				margin-left:10px;
				margin-right:10px;
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
				widht: 200px;
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
			.card-text{
				font-size: 22px;
				Color:#323c8d;
			}
			.card-img-top{
				width:300px;
				height:300px;
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
								<a class="nav-link" href="./profile.php">МОЙ ПРОФИЛЬ</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link active" aria-current="page" href="./search.php">ПОИСК ЗНАКОМСТВ</a>
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
		<h2 class="kim4">ВСЕ АНКЕТЫ</h2>
		<form class="form" method="GET" action="">
			<div align="center">
				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label" style="color: white;font-weight:bold">Пол</label>
					<select class="form-control" name="gender" aria-label="Default select example" style="font-family: 'Source Sans Pro', sans-serif;">
						<option selected></option>
						<option value="муж">Мужской</option>
						<option value="жен">Женский</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label" style="color: white;font-weight:bold">Институт</label>
					<select class="form-control" name="institute" aria-label="Default select example" style="font-family: 'Source Sans Pro', sans-serif;">
						<option selected></option>
						<?
							include "configurations/db.php";
							$query = "SELECT DISTINCT Institute FROM users";
							$result = mysqli_query($link,$query);
							while($inst  = mysqli_fetch_assoc($result))
							{
								echo "<option value='".$inst["Institute"]."'>".$inst["Institute"]."</option>";
							}
							mysqli_close($link);
						?>
					</select>
				</div>
				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label" style="color: white;font-weight:bold">Курс</label>
					<select class="form-control" name="course" aria-label="Default select example" style="font-family: 'Source Sans Pro', sans-serif;">
						<option selected></option>
						<option value="1">1 курс</option>
						<option value="2">2 курс</option>
						<option value="3">3 курс</option>
						<option value="4">4 курс</option>
						<option value="5">5 курс</option>
					</select>
				</div>
				<div class="mb-3">
					<button type="submit" class="btn btn-success" style="background-color:white; color: #323c8d">Найти</button>
				</div>
			</div>
		</form>
		<div>
			<div class="row">
				<?for($i = $startnum; $i < $endnum; $i++){?>
					<div class="card" style="width: 300px; border-radius:20px;">
						<img src="<?=$profiles[$i]["Photo"]?>"class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text"><b>Имя:</b> <?echo $profiles[$i]['Name']?></p>
							<p class="card-text"><b>Фамилия:</b> <?echo $profiles[$i]['Surname']?></p>
							<p class="card-text"><b>Институт:</b> <?echo $profiles[$i]['Institute']?></p>
							<p class="card-text"><b>Курс:</b> <?echo $profiles[$i]['Course']?></p>
							<button type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px" onClick="window.location.href = '?liked=<?=$i?>'">Лайк ♥</button>
						</div>
					</div>
				<?}
				if ($endnum ==0) echo "<p align=center>Записей нет</p>";
				?>
			</div>
			<?if (GetAmountOfPages($size)>1){?>
			<div class="pagin">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<?for($i=1; $i <= GetAmountOfPages($size); $i++){?>
							<li class="page-item"><a class="page-link" href="<?=$url."page=".$i?>"><?=$i?></a></li>
						<?}?>
					</ul>
				</nav>
			</div>
			<?}?>
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