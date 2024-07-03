<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dropdown Sidebar - Tivotal</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="dashbord.css">
  <title>Dashboard</title>      
  <link rel="stylesheet" href="hstyle.css">
</head>
<body>
  <div class="sidebar close">
    <div class="logo">
     <img src="logo (2).png" class="logo" />
      <span class="logo-name">Dnyanshree Institute Of Engineering And Technology Satara</span>
    </div>

    <ul class="nav-list">
      <li>
        <a href="home.php">
            <i class="fab fa-microsoft"></i>
            <span class="link-name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
            <li><a href="home.php"  class="link-name">Dashboard</a></li>
        </ul>
    </li>

      <li>
        <div class="icon-link">
          <a href="#">
            <i class="fas fa-solid fa-user-graduate"></i>
            <span class="link-name">Degree</span>
          </a>
          <i class="fas fa-caret-down arrow"></i>
        </div>
        <ul class="sub-menu">
          <li><a href="#" class="link-name">Degree</a></li>
          <li><a href="degree.php?name=Mechanical">Mechanical</a></li>
          <li><a href="degree.php?name=Computer">Computer</a></li>
          <li><a href="degree.php?name=Entc">Entc</a></li>
          <li><a href="degree.php?name=Civil">Civil</a></li>
          <li><a href="degree.php?name=Electrical">Electrical</a></li>
          
          
        </ul>
      </li>
      <li>
        <div class="icon-link">
          <a href="#">
            <i class="fas fa-solid fa-graduation-cap"></i>
            <span class="link-name">Diploma</span>
          </a>
          <i class="fas fa-caret-down arrow"></i>
        </div>
        <ul class="sub-menu">
          <li><a href="#" class="link-name">Diploma</a></li>
          <li><a href="diploma.php?name=Mechanical">Mechanical</a></li>
          <li><a href="diploma.php?name=Computer">Computer</a></li>
          <li><a href="diploma.php?name=Entc">Entc</a></li>
        </ul>
      </li>

      <li>
        <a href="about.php">
        <i class="fas fa-regular fa-circle-info"></i>
          <span class="link-name">About</span>
        </a>
        <ul class="sub-menu blank">
          <li><a href="about.php" class="link-name">About</a></li>
        </ul>
      </li>

      <li>
        <a href="logout.php">
          <i class="fas fa-right-to-bracket"></i>
          <span class="link-name">Exit</span>
          </a>
          <ul class="sub-menu blank">
            <li><a href="logout.php" class="link-name">Exit</a></li>
          </ul>
      </li>
    </ul>
  </div>