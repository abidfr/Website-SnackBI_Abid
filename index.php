<?php 
$db = mysqli_connect("localhost","root","","login");
session_start();
if(isset($_SESSION['login'])) {
  return header("Location: home.php");
}
include_once('db_connect.php');
$database = new database();

// if(isset($_SESSION['is_login']))
// {
//     header('location:home.php');
// }

// if(isset($_COOKIE['username']))
// {
//   $database->relogin($_COOKIE['username']);
//   header('location:home.php');
// }

// if(isset($_POST['login']))
// {
//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     if(isset($_POST['remember']))
//     {
//       $remember = TRUE;
//     }
//     else
//     {
//       $remember = FALSE;
//     }

//     if($database->login($username,$password,$remember))
//     {
//       header('location:home.php');
//     }
// }
$no_login = "";
$remember = "";
if(isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if(!$remember) {
    $remember = 0;
  } else {
    $remember = $_POST['remember'];
  }

  $result = mysqli_query($db,"SELECT * FROM tb_user WHERE username = '$username'");
  $num = mysqli_fetch_assoc($result);
  if($num) {
    if(password_verify($password,$num['password'])) {
      if(isset($remember)) {
        setcookie('username', $username, time() + (60 * 60 * 24 * 5), '/');
        setcookie('nama', $num['nama'], time() + (60 * 60 * 24 * 5), '/');
        $_SESSION['login'] = true;
        $_SESSION['username'] = $num['username'];
        $_SESSION['email'] = $num['email'];
        $_SESSION['password'] = $num['password'];
        $_SESSION['id'] = $num['id'];

        return header("Location: home.php");
        exit;
      } else {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $num['username'];
        $_SESSION['email'] = $num['email'];
        $_SESSION['password'] = $num['password'];
        $_SESSION['id'] = $num['id'];

        return header("Location: home.php");
        exit;
      }
    } else {
      $no_login = true;
    }
  } else {
    $no_login = true;
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v3.8.5">
  <title>Login Form</title>

  <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/"> -->

  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
    integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap" rel="stylesheet">
  <style>
    .container .login {
      display: grid !important;
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 20px !important;
      align-items: center;
    }

    .container {
      border: 0px !important;
    }

    .boxs {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      text-align: center;
      background-color: white;
      display: block;
      font-size: 20px;
      line-height: 50px;
    }

    body {
      font-family: 'Slabo 27px', serif;
      background-color: #1DB9C3 !important;
    }

    @media screen and (max-width:991px) {
      .container .login {
        grid-template-columns: repeat(1, 1fr) !important;
        margin-top: 50%;
        margin-bottom: 50px;
      }
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .box-center {
      display: flex;
      justify-content: center;
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="assets/css/signin.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="login">
      <div class="col_1">
        <div class="w-100 h-100">
          <img src="assets/img/ilustrasi.svg" alt="" class="w-100 h-100" style="object-fit: cover;">
        </div>
      </div>
      <div class="col_1">
        <h3 class="text-white">Welcome Back :)</h3>
        <p class="text-white">
          To keep connected with us please login with your personal information by email address and password
        </p>
        <?php if($no_login == true) : ?>
          <div class="alert alert-danger">Username Atau Password Salah</div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="bg-white p-3" style="border-radius: 10px;">
            <div class="d-flex pt-3">
              <i class="fas fa-envelope pt-3 pr-3"></i>
              <div class="omrs-input-group w-100">
                <label class="omrs-input-underlined w-100">
                  <input required type="text" name="username">
                  <span class="omrs-input-label" style="margin-top: -10px;">Username</span>
                  <span class="omrs-input-helper"></span>
                </label>
              </div>
            </div>
            <div class="d-flex">
              <i class="fas fa-lock pt-3 pr-3"></i>
              <div class="omrs-input-group w-100">
                <label class="omrs-input-underlined w-100">
                  <input required type="password" name="password">
                  <span class="omrs-input-label" style="margin-top: -10px;">Password</span>
                  <span class="omrs-input-helper"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="d-flex mt-2" style="justify-content: space-between;">
            <div class="custom-control custom-checkbox pt-2">
              <input type="checkbox" name="remember" value="1" class="custom-control-input" id="customCheck1">
              <label class="custom-control-label text-white" for="customCheck1">Remember me</label>
            </div>
            <a href="#" class="nav-link text-white">Forgot Password</a>
          </div>
         <div class="d-flex flex-row">
          <button name="login" class="btn btn-primary p-3 px-4 mr-2" style="border-radius: 50px;color: white;" type="submit">Login</button>
          <a href="register.php" style="border-radius: 50px;text-decoration: none;"class="p-3 px-4 bg-white text-center btn btn-white">Create Account</a>
          <a href="https://www.facebook.com/abid.nakzz.3" class="boxs ml-2 mr-2">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="https://twitter.com/abidfaddd?s=08" class="boxs ml-2 mr-2">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="https://www.instagram.com/abidfaddd_/" class="boxs ml-2 mr-2">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
        </form>
        
        </div>
      </div>
    </div>
  </div>
  <script>
    // JavaScript for label effects only
    $(window).load(function () {
      $(".col-3 input").val("");

      $(".input-effect input").focusout(function () {
        if ($(this).val() != "") {
          $(this).addClass("has-content");
        } else {
          $(this).removeClass("has-content");
        }
      })
    });
  </script>
</body>

</html>