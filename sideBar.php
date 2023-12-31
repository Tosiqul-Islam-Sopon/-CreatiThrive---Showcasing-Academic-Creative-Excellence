<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Side Bar</title>

    <style>
      table,
      th,
      td {
        border: 1px solid;
      }
    </style>
    <!-- Include Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Roboto:ital@1&display=swap");
      * {
        padding: 0%;
        margin: 0%;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }

      .sidebar {
        min-height: 100vh;
        width: 80px;
        padding: 6px 14px;
        z-index: 1100;
        background-color: rgb(56, 56, 104);
        transition: all 0.5s ease;
        position: fixed;
        top: 0;
        left: 0;
      }
      .sidebar.open {
        width: 250px;
      }
      .sidebar .logo_details {
        height: 60px;
        text-align: center;
        display: flex;
        align-items: center;
        position: relative;
      }
      .sidebar .logo_details .icon {
        opacity: 0;
        transition: all 0.5s ease;
      }

      .sidebar .logo_details .logo_name {
        color: white;
        font-size: 22px;
        font-weight: 600;
        opacity: 0;
        transition: all 0.5s ease;
      }
      .sidebar.open .logo_details .icon,
      .sidebar.open .logo_details .logo_name {
        opacity: 1;
      }

      .sidebar .logo_details #btn {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        font-size: 22px;
        text-align: right;
        cursor: pointer;
        transition: all 0.5s ease;
      }
      .sidebar i {
        color: white;
        height: 60px;
        line-height: 60px;
        min-width: 50px;
        font-size: 25px;
        text-align: center;
      }
      .sidebar .new-list {
        margin-top: 20px;
        height: 100%;
        
        padding-left: 0px;
      }
     
      .sidebar li {
        position: relative;
        margin: 8px 0;
        list-style: none;
      }
      .sidebar li .tooltip {
        position: absolute;
        top: 20px;
        left: calc(100% + 15px);
        z-index: 3;
        background-color: white;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 6px 14px;
        font-size: 15px;
        font-weight: 400;
        border-radius: 5px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
      }
      .sidebar li:hover .tooltip {
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        top: 50%;
        transform: translateY(-50%);
      }
      .sidebar.span li .tooltip {
        display: none;
      }
      .sidebar input {
        font-size: 15px;
        color: white;
        font-weight: 400;
        outline: none;
        height: 35px;
        width: 35px;
        border: none;
        border-radius: 5px;
        color: rgb(74, 108, 97);
        transition: all 0.5s ease;
      }
      .sidebar input::placeholder {
        color: rgb(74, 108, 97);
      }
      .sidebar.open input {
        padding: 0 20px 0 50px;
        width: 100%;
      }
      .sidebar .bx-search {
        position: absolute;
        font-size: 22px;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        background-color: rgb(74, 108, 97);
        color: white;
      }
      .sidebar li a {
        display: flex;
        height: 100%;
        width: 100%;
        align-items: center;
        text-decoration: none;
        background-color: rgb(56, 56, 104);
        position: relative;
        transition: all 0.5s ease;
        z-index: 12;
      }
      .sidebar li a::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        transform: scaleX(0);
        background-color: white;
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
        transform-origin: left;
        z-index: -2;
      }
      .sidebar li a:hover::after {
        transform: scaleX(1);
        color: rgb(56, 56, 104);
      }
      .sidebar li a .link_name {
        color: white;
        font-size: 15px;
        font-weight: 400;
        white-space: nowrap;
        pointer-events: auto;
        transition: all 0.4s ease;
        pointer-events: none;
        opacity: 0;
      }
      .sidebar li a:hover .link_name,
      .sidebar li a:hover i {
        transition: all 0.5s ease;
        color: rgb(56, 56, 104);
      }
      .sidebar.open li a .link_name {
        pointer-events: auto;

        opacity: 1;
      }
      .sidebar li i {
        height: 35px;
        line-height: 35px;
        font-size: 18px;
        border-radius: 5px;
      }
    </style>

    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />

<style>
  /* Custom CSS to make the button white */
  .btn-white {
      background-color: white;
      color: rgb(207, 37, 37);
  }

  /* CSS for the hover effect */
  .btn-white:hover {
      background-color: black;
      color: white;
  }

  /* Custom class for black background */
  .black-bg {
      background-color: black;
  }

</style>

    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div>
      <div class="sidebar">
        <div class="logo_details">
          <div class="logo_name">CreatiThrive</div>
          <i class="bx bx-menu mr-3" id="btn"></i>
        </div>

        <?php
        // Include the PHP logic file
        include('sidebar_logic.php');
        ?>

      </div>

      <script>
        window.onload = function () {
          const sidebar = document.querySelector(".sidebar");
          const closeBtn = document.querySelector("#btn");
          const searchBtn = document.querySelector(".bx-search");
          closeBtn.addEventListener("click", function () {
            sidebar.classList.toggle("open");
          });
          search.addEventListener("click", function () {
            sidebar.classList.toggle("open");
            menuBtnChange();
          });
          function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
              closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
              closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
          }
        };
      </script>
    </div>
  </body>
</html>