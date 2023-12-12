<ul class="new-list">
  <li>
    <i class="bx bx-search"></i>
    <input name="search" type="text" placeholder="Search by Project" />
    <span class="tooltip">Search</span>
  </li>
  <li>
    <a href="index.php">
      <i class="bx bx-home"></i> <span class="link_name">Home</span>
    </a>
    <span class="tooltip">Home</span>
  </li>

  <?php
  if (isset($_SESSION['user_id'])) {
    // User is logged in
    echo '
    <li>
      <a href="uploadProject.php">
        <i class="bx bx-cart-add"></i>
        <span class="link_name">Add Project</span>
      </a>
      <span class="tooltip">Add Project</span>
    </li>
    <li>
      <a href="profile2.php">
        <i class="bx bx-user"></i>  
        <span class="link_name">Profile</span>
      </a>
      <span class="tooltip">Profile</span></span>
    </li>
    <li>
      <a href="logout.php">
        <i class="bx bx-log-out"></i>
        <span class="link_name">LogOut</span>
      </a>
      <span class="tooltip">LogOut</span>
    </li>';
  } else {
    // User is logged out
    echo '
    <li>
      <a href="login.php">
        <i class="bx bx-log-in"></i>
        <span class="link_name">Login</span>
      </a>
      <span class="tooltip">Login</span>
    </li>';
  }
  ?>

  <li>
    <a href="aboutUs.php">
      <i class="bx bx-info-circle"></i>
      <span class="link_name">About Us</span>
    </a>
    <span class="tooltip">About Us</span>
  </li>
</ul>
