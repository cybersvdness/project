<?
	function Registration($email, $name, $surname, $gender, $institute, $course, $age, $password, $link_u)
	{
		include "configurations/db.php";
		
		$query = "SELECT Email FROM users WHERE Email = '$email'";
		
		$result = mysqli_query($link, $query);
		$result = mysqli_fetch_array($result);
		
		if (empty($result))
		{
			$query = "INSERT INTO users(Email, Password, Name, Surname, Gender, Institute, Course, Age, Link) VALUES ('$email','".password_hash($password, PASSWORD_DEFAULT)."','$name', '$surname', '$gender', '$institute', '$course', '$age', '$link_u')";
			$result = mysqli_query($link,$query);
			header ("Location: authorization.php");
		}
		else 
		{
			return "Пользователь с таким email уже существует!";
		}
		
		mysqli_close($link);
	}
	if (!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['gender']) && !empty($_POST['institute']) && !empty($_POST['course']) && !empty($_POST['age']) && !empty($_POST['password']) && !empty($_POST['link']))
	{
		echo "<p align=center>".Registration($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['institute'], $_POST['course'], $_POST['age'], $_POST['password'], $_POST['link'])."</p>";
	}
?>
<!doctype html>
<html>
	<head>
		<link rel="icon" href="./images/logo.png" type="image/x-icon"> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<title>Регистрация</title>
		<style>
		body{
			height:700px;
			background-attachment:fixed;
			background-size:cover;
		}
		.luxe > a{
			background-color:black;
			color:white;
		}
		.mb-3{
			margin-top:10px;
		}
		.form1 > .mb-3{
			margin-left:10px;
			margin-right:10px;
		}
		.form1{
			margin-top:2%;
			margin-right:auto;
			margin-left:auto;
			width:500px;
			background-color:white;
			border:2px solid #323c8d;
			border-radius:10px;
		}
		.pagination{
			margin-right:auto;
			margin-left:auto;
			width:250px;
			margin-top:4%;
		}
		.page-item > a:hover{
			background-color:black;
			color:white;
		}
		.luxe > a:hover{
			background-color:black;
			color:white;
		}
		.comfort > a:hover{
			background-color:black;
			color:white;
		}
		.econom > a:hover{
			background-color:black;
			color:white;
		}
		.page-link {
			background-color:white;
			color:black;
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
		.color1 > .kim > .kim4{
			text-align: center;
			font-size:40px;
			margin-top:40px;
			color:#323c8d;
		}
		</style>
	</head>
	<body>
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
							<a class="nav-link" href="./authorization.php">АВТОРИЗАЦИЯ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="./registration.php">РЕГИСТРАЦИЯ</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="color1">
		<div class="kim">
			<h2 class="kim4">РЕГИСТРАЦИЯ</h2>
			<form class="form1" method="POST" action="">
				<div class="mb-3">
					<div id="emailHelp" style="text-align: center; color:#323c8d" class="form-text">Вы <b>зарегистрированы</b>? Перейти к <a href="authorization.php">авторизации</a></div>
					<label class="form-label">E-mail адрес</label>
					<input type="email" class="form-control" aria-describedby="emailHelp" name="email" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Имя</label>
					<input type="text" class="form-control" name="name" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Фамилия</label>
					<input type="text" class="form-control" name="surname" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Пол</label>
					<select class="form-select" aria-label="Default select example" name="gender" required>
						<option selected></option>
						<option value="муж">Мужской</option>
						<option value="жен">Женский</option>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label">Институт</label>
					<input type="text" class="form-control" name="institute" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Курс</label>
					<input input type="number" class="form-control" min="1" max="5" name="course" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Возраст</label>
					<input input type="number" class="form-control" min="16" name="age" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Ссылка для общения (VK, Telegram, Instagram и т.п.)</label>
					<input type="text" class="form-control" name="link" required>
				</div>
				<div class="mb-3">
					<label class="form-label">Придумайте пароль</label>
					<input type="password" class="form-control" name="password" required>
				</div>
				<div class="mb-3">
					<button name="register" type="submit" style="background-color:#323c8d; font-size:20px; color:white;border-radius:10px">Зарегистрироваться</button>
				</div>
			</form>
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