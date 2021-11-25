<?php 
class database{
  var $host = "localhost";
  var $username = "root";
  var $password = "";
  var $database = "login";
  var $koneksi;

  function __construct(){
    $this->koneksi = mysqli_connect($this->host, $this->username, $this->password,$this->database);
  }


  function register($username,$password,$nama)
  { 
    $insert = mysqli_query($this->koneksi,"insert into tb_user values ('','$username','$password','$nama')");
    return $insert;
  }

  function login($username,$password,$remember = false)
  {
    $query = mysqli_query($this->koneksi,"SELECT * FROM tb_user WHERE username='$username'");
    $data_user = $query->fetch_array();
    if($data_user) {
        if(password_verify($password,$data_user['password']))
    {
      if($remember)
      {
        setcookie('username', $username, time() + (60 * 60 * 24 * 5), '/');
        setcookie('nama', $data_user['nama'], time() + (60 * 60 * 24 * 5), '/');
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data_user['nama'];
            $_SESSION['is_login'] = TRUE;
            return header("Location: home.php");
      } else {
          $_SESSION['username'] = $username;
          $_SESSION['nama'] = $data_user['nama'];
          $_SESSION['is_login'] = TRUE;
          return header("Location: home.php");
      }
    } else {
        return false;
    }
    } else {
        return false;
    }
  }

  function username($username) {
      $query = mysqli_query($this->koneksi,"SELECT * FROM tb_user WHERE username='$username'");
      return $query->fetch_assoc();
  }

  function relogin($username)
  {
    $query = mysqli_query($this->koneksi,"select * from tb_user where username='$username'");
    $data_user = $query->fetch_array();
    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $data_user['nama'];
    $_SESSION['is_login'] = TRUE;
  }

  function created() 
  {
    $nama = htmlspecialchars($_POST['nama']);
  $harga = htmlspecialchars($_POST['harga']);
  $descripsi = htmlspecialchars($_POST['descripsi']);

      // ambil dulu isi dari $_FILES
      $namaFile = $_FILES['file']['name'];
      $ukuranFile = $_FILES['file']['size'];
      $error = $_FILES['file']['error'];
      $tmpName = $_FILES['file']['tmp_name'];

      // cek apakah yang di upload adalah file yang di perbolehkan
      $ektensifileValid = ['jpg', 'jpeg', 'png'];
      $ektensifile = explode('.', $namaFile);
      $ektensifile = strtolower(end($ektensifile));

      // yang di upload bukan file yang di perbolehkan
      if (!in_array($ektensifile, $ektensifileValid)) {
          echo "<script>
              alert('yang anda upload bukan file');
          </script>";
          return false;
      }

      // cek jika ukuran file terlalu besar
      

      $namaFileBaru = uniqid();
      $namaFileBaru .= ".";
      $namaFileBaru .= $namaFile;

      // apakah user mengupload file tidak
      if ($error === 4) {
          $namaFile = null;
      } else {
          move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
      }

      mysqli_query($this->koneksi,"INSERT INTO produk VALUES('','$namaFileBaru','$harga','$nama','$descripsi')");
      return header("Location: home.php");
  }

  function edit()
  {
    $nama = htmlspecialchars($_POST['nama']);
    $id = $_POST['id'];
    $img_lama = $_POST['img_lama'];
    $harga = htmlspecialchars($_POST['harga']);
    $descripsi = htmlspecialchars($_POST['descripsi']);

      // ambil dulu isi dari $_FILES
      $namaFiles = $_FILES['file']['name'];
      if($namaFiles) {
        $namaFile = $_FILES['file']['name'];
        $ukuranFile = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];
        $tmpName = $_FILES['file']['tmp_name'];
  
        // cek apakah yang di upload adalah file yang di perbolehkan
        $ektensifileValid = ['jpg', 'jpeg', 'png'];
        $ektensifile = explode('.', $namaFile);
        $ektensifile = strtolower(end($ektensifile));
  
        // yang di upload bukan file yang di perbolehkan
        if (!in_array($ektensifile, $ektensifileValid)) {
            echo "<script>
                alert('yang anda upload bukan file');
            </script>";
            return false;
        }
  
        // cek jika ukuran file terlalu besar
        if ($ukuranFile > 90000) {
            echo "<script>
                alert('ukuran file terlalu besar');
            </script>";
            return false;
        }
  
        $namaFileBaru = uniqid();
        $namaFileBaru .= ".";
        $namaFileBaru .= $namaFile;
  
        // apakah user mengupload file tidak
        if ($error === 4) {
            $namaFile = $img_lama;
        } else {
            move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
        }
      } else {
        $namaFileBaru = $img_lama;
      }

      mysqli_query($this->koneksi,"UPDATE produk SET
      img = '$namaFileBaru',
      harga = '$harga',
      nama  = '$nama',
      descripsi = '$descripsi'
      WHERE id_produk = $id
      ");
      return header("Location: home.php");
  }
} 
function send($data) {
  $db = mysqli_connect("localhost","root","","login");
    $judul = htmlspecialchars($data['judul']);
    $pesan = htmlspecialchars($data['descripsi']);

     // ambil dulu isi dari $_FILES
     $namaFile = $_FILES['file']['name'];
     $ukuranFile = $_FILES['file']['size'];
     $error = $_FILES['file']['error'];
     $tmpName = $_FILES['file']['tmp_name'];

     // cek apakah yang di upload adalah file yang di perbolehkan
     $ektensifileValid = ['jpg', 'jpeg', 'png'];
     $ektensifile = explode('.', $namaFile);
     $ektensifile = strtolower(end($ektensifile));

     // yang di upload bukan file yang di perbolehkan
     if (!in_array($ektensifile, $ektensifileValid)) {
         echo "<script>
             alert('yang anda upload bukan file');
         </script>";
         return false;
     }

     // cek jika ukuran file terlalu besar
     if ($ukuranFile > 90000) {
         echo "<script>
             alert('ukuran file terlalu besar');
         </script>";
         return false;
     }

     $namaFileBaru = uniqid();
     $namaFileBaru .= ".";
     $namaFileBaru .= $namaFile;

     // apakah user mengupload file tidak
     if ($error === 4) {
         $namaFile = null;
     } else {
         move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
     }

     $insert = "INSERT INTO services VALUES('','$judul','$namaFileBaru','$pesan')";
     mysqli_query($db,$insert);
     return mysqli_affected_rows($db);

}

function edit($data) {
  $db = mysqli_connect("localhost","root","","login");
    $judul = htmlspecialchars($data['judul']);
    $pesan = htmlspecialchars($data['descripsi']);
    $id = $_POST['id'];

    $namaFiles = $_FILES['file']['name'];
    if(!$namaFiles) {
      $namaFileBaru = $data['file_lama'];
    } else {
           // ambil dulu isi dari $_FILES
           $namaFile = $_FILES['file']['name'];
           $ukuranFile = $_FILES['file']['size'];
           $error = $_FILES['file']['error'];
           $tmpName = $_FILES['file']['tmp_name'];
      
           // cek apakah yang di upload adalah file yang di perbolehkan
           $ektensifileValid = ['jpg', 'jpeg', 'png'];
           $ektensifile = explode('.', $namaFile);
           $ektensifile = strtolower(end($ektensifile));
      
           // yang di upload bukan file yang di perbolehkan
           if (!in_array($ektensifile, $ektensifileValid)) {
               echo "<script>
                   alert('yang anda upload bukan file');
               </script>";
               return false;
           }
      
           // cek jika ukuran file terlalu besar
           if ($ukuranFile > 90000) {
               echo "<script>
                   alert('ukuran file terlalu besar');
               </script>";
               return false;
           }
      
           $namaFileBaru = uniqid();
           $namaFileBaru .= ".";
           $namaFileBaru .= $namaFile;
      
           // apakah user mengupload file tidak
           if ($error === 4) {
               $namaFile = null;
           } else {
               move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
           }
    }

     $insert = "UPDATE services SET title = '$judul',
     img = '$namaFileBaru',
     pesan = '$pesan'
     WHERE id_services = '$id'";
     mysqli_query($db,$insert);
     return mysqli_affected_rows($db);

}

function created($data)
{
  $db = mysqli_connect("localhost","root","","login");
  $nama = htmlspecialchars($_POST['nama']);
  $harga = htmlspecialchars($_POST['harga']);
  $descripsi = htmlspecialchars($_POST['descripsi']);

      // ambil dulu isi dari $_FILES
      $namaFile = $_FILES['file']['name'];
      $ukuranFile = $_FILES['file']['size'];
      $error = $_FILES['file']['error'];
      $tmpName = $_FILES['file']['tmp_name'];

      // cek apakah yang di upload adalah file yang di perbolehkan
      $ektensifileValid = ['jpg', 'jpeg', 'png'];
      $ektensifile = explode('.', $namaFile);
      $ektensifile = strtolower(end($ektensifile));

      // yang di upload bukan file yang di perbolehkan
      if (!in_array($ektensifile, $ektensifileValid)) {
          echo "<script>
              alert('yang anda upload bukan file');
          </script>";
          return false;
      }

      // cek jika ukuran file terlalu besar
      if ($ukuranFile > 90000) {
          echo "<script>
              alert('ukuran file terlalu besar');
          </script>";
          return false;
      }

      $namaFileBaru = uniqid();
      $namaFileBaru .= ".";
      $namaFileBaru .= $namaFile;

      // apakah user mengupload file tidak
      if ($error === 4) {
          $namaFile = null;
      } else {
          move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
      }

      mysqli_query($db,"INSERT INTO produk VALUES('','$namaFileBaru','$harga','$nama','$descripsi')");
      return mysqli_affected_rows($db);
}

function update($data) 
{
  $db = mysqli_connect("localhost","root","","login");
  $nama = htmlspecialchars($data['nama']);
    $id = $data['id'];
    $img_lama = $data['img_lama'];
    $harga = htmlspecialchars($data['harga']);
    $descripsi = htmlspecialchars($data['descripsi']);

      // ambil dulu isi dari $_FILES
      $namaFiles = $_FILES['file']['name'];
      if($namaFiles) {
        $namaFile = $_FILES['file']['name'];
        $ukuranFile = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];
        $tmpName = $_FILES['file']['tmp_name'];
  
        // cek apakah yang di upload adalah file yang di perbolehkan
        $ektensifileValid = ['jpg', 'jpeg', 'png'];
        $ektensifile = explode('.', $namaFile);
        $ektensifile = strtolower(end($ektensifile));
  
        // yang di upload bukan file yang di perbolehkan
        if (!in_array($ektensifile, $ektensifileValid)) {
            echo "<script>
                alert('yang anda upload bukan file');
            </script>";
            return false;
        }
  
        // cek jika ukuran file terlalu besar
        if ($ukuranFile > 90000) {
            echo "<script>
                alert('ukuran file terlalu besar');
            </script>";
            return false;
        }
  
        $namaFileBaru = uniqid();
        $namaFileBaru .= ".";
        $namaFileBaru .= $namaFile;
  
        // apakah user mengupload file tidak
        if ($error === 4) {
            $namaFile = $img_lama;
        } else {
            move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
        }
      } else {
        $namaFileBaru = $img_lama;
      }

      mysqli_query($db,"UPDATE produk SET
      img = '$namaFileBaru',
      harga = '$harga',
      nama  = '$nama',
      descripsi = '$descripsi'
      WHERE id_produk = $id
      ");
      return mysqli_affected_rows($db);
}

?>