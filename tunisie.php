<?php
$current_page = 'tunisie';
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tunisie - Découvrez le Sud Tunisien</title>
  <link rel="stylesheet" href="css/tunisie.css" />
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<?php include __DIR__ . '/includes/tunisie-content.php'; ?>

  <script>
  let menu = document.querySelector('#menu-bar');
  let navbar = document.querySelector('.navbar');
  let searchBtn = document.querySelector('#search-btn');
  let searchBar = document.querySelector('.search-bar-container');
  let formBtn = document.querySelector('#login-btn');
  let formClose = document.querySelector('#form-close');
  let loginForm = document.querySelector('.login-form-container');

  menu.addEventListener('click', () =>{
      menu.classList.toggle('fa-times');
      navbar.classList.toggle('active');
  });

  searchBtn.addEventListener('click', () =>{
      searchBtn.classList.toggle('fa-times');
      searchBar.classList.toggle('active');
  });

  formBtn.addEventListener('click', () =>{
      loginForm.classList.add('active');
  });
  formClose.addEventListener('click', () =>{
      loginForm.classList.remove('active');
  });
  </script>

  <script src="js/tunisie.js"></script>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
