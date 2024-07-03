<?php 
include("menus.php");
?>
<div class="home-section">
    <div class="home-content">
      <i class="fas fa-bars"></i>
      <span class="text">Student Progression Management System</span>
    </div>
    <br clear="all"><br>
    <main class="main-container">
      <!-- Main Title -->
      <div class="main-title">
          <h2>DASHBOARD</h2>
      </div>

      <!-- Main Cards -->
      <div class="main-cards">
          <!-- Card 1: Search Student -->
          <div class="card">
              <div class="card-inner">
                  <a href="upload3.html"><h3>Upload Student Data</h3></a>
              </div>
          </div>
         
          <!-- Card 2: Graph-wise Progression -->
          <div class="card">
              <div class="card-inner">
                  <a href="search.php"><h3>Search Departmental Progress</h3></a>
              </div>
          </div>
          
          <!-- Card 3: Upload Student Data -->
          <div class="card">
              <div class="card-inner">
                  <a href="bargraph.php"><h3>View Student Progress</h3></a>
              </div>
          </div>
      </div>
  </main>
</div>

<?php
include("footer.php");
?>
