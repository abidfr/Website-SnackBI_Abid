<?php 
$db = mysqli_connect("localhost","root","","login");
session_start();
if(isset($_SESSION['login'])) {
  return header("Location: home.php");
}
include_once('db_connect.php');
$database = new database();
$login = "";
$no_login = "";


if(isset($_POST['register'])) {
  $username = $_POST['username'];
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];
  $email = $_POST['email'];

  $result = mysqli_query($db,"SELECT * FROM tb_user WHERE username = '$username'");
  $num  = mysqli_num_rows($result);
  if($num) {
    $no_login = true;
  } elseif($password1 != $password2) {
    $no_login = true;
  } else {
    $password_hash = password_hash($password2,PASSWORD_DEFAULT);
    $insert = mysqli_query($db,"INSERT INTO tb_user VALUES('',
    '$username',
    '$password_hash',
    '$email')");
      if($insert) {
        $login = true;
      } else {
        $no_login = true;
      }
  } 
}

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
      overflow-x: hidden;
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
        <h3 class="text-white mb-4">Create Account </h3>
        <?php if($login == true) : ?>
          <div class="alert alert-success">Data Berhasil Di Tambahkan Silahkan Login</div>
          <?php elseif($no_login == true) : ?>
            <div class="alert alert-danger">Data Gagal Di Tambahkan</div>
          <?php endif; ?>
        <form action="" method="POST">
          <div class="bg-white p-3" style="border-radius: 10px;">
            <div class="d-flex pt-3">
              <i class="fas fa-user pt-3 pr-3"></i>
              <div class="omrs-input-group w-100">
                <label class="omrs-input-underlined w-100">
                  <input required type="text" name="username">
                  <span class="omrs-input-label" style="margin-top: -10px;">Username</span>
                  <span class="omrs-input-helper"></span>
                </label>
              </div>
            </div>
            <div class="d-flex ">
              <i class="fas fa-envelope pt-3 pr-3"></i>
              <div class="omrs-input-group w-100">
                <label class="omrs-input-underlined w-100">
                  <input required type="text" name="email">
                  <span class="omrs-input-label" style="margin-top: -10px;">Email</span>
                  <span class="omrs-input-helper"></span>
                </label>
              </div>
            </div>
            <div class="d-flex">
              <i class="fas fa-lock pt-3 pr-3"></i>
              <div class="omrs-input-group w-100">
                <label class="omrs-input-underlined w-100">
                  <input required type="password" name="password1">
                  <span class="omrs-input-label" style="margin-top: -10px;">Repeat Password</span>
                  <span class="omrs-input-helper"></span>
                </label>
              </div>
            </div>
            <div class="d-flex">
              <i class="fas fa-lock pt-3 pr-3"></i>
              <div class="omrs-input-group w-100">
                <label class="omrs-input-underlined w-100">
                  <input required type="password" name="password2">
                  <span class="omrs-input-label" style="margin-top: -10px;">Password</span>
                  <span class="omrs-input-helper"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="custom-control custom-checkbox pt-2">
            <input type="checkbox" required class="custom-control-input" id="customCheck1">
            <label class="custom-control-label text-white" for="customCheck1">please fill in the data completely...</label>
          </div>
          <div class="mt-3 d-flex">
            <button name="register" class="p-3 px-4 bg-white text-center btn btn-white mr-2" style="border-radius: 50px;color: blue;"
              type="submit">Create Account</button>
              <a href="index.php" style="border-radius: 50px;text-decoration: none;" class="btn btn-primary p-3 px-4">Login </a>
            <div class="boxs ml-2">
              <a href="https://www.facebook.com/abid.nakzz.3">
                <i class="fab fa-facebook"></i>
              </a>
            </div>
            <div class="boxs ml-2 mr-2">
              <a href="https://twitter.com/abidfaddd?s=08">
                <i class="fab fa-twitter"></i>
              </a>
            </div>
            <div class="boxs">
              <a href="https://www.instagram.com/abidfaddd_/">
                <i class="fab fa-instagram"></i>
              </a>
            </div>
          </div>
        </form>
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