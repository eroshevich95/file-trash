
<?php
include "boot.php";


if (!check_auth()) {
    header('Location: /login.php');
    die;
}
?>
<!DOCTYPE html>
<html>
    <head>
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Моя ФайлоПомоечка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha3849ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

            <style>
        [class*="icon-"]
        {
            display:inline-block;
            width:16px;
            height:16px; background:url("data:image/png;base64,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") no-repeat 0 0;
            vertical-align:bottom
        }
        .icon-document{background-position:-16px 0}
        .icon-folder{background-position:-32px 0}
        .icon-folder_add{background-position:-48px 0}
        .icon-upload{background-position:-64px 0}
        .icon-arrow_up{background-position:-80px 0}
        .icon-home{background-position:-96px 0}
        .icon-separator{background-position:-112px 0}
        .icon-cross{background-position:-128px 0}
        .icon-copy{background-position:-144px 0}
        .icon-apply{background-position:-160px 0}
        .icon-cancel{background-position:-176px 0}
        .icon-rename{background-position:-192px 0}
        .icon-checkbox{background-position:-208px 0}
        .icon-checkbox_invert{background-position:-224px 0}
        .icon-checkbox_uncheck{background-position:-240px 0}
        .icon-download{background-position:-256px 0}
        .icon-goback{background-position:-272px 0}
        .icon-folder_open{background-position:-288px 0}
        .icon-file_application{background-position:0 -16px}
        .icon-file_code{background-position:-16px -16px}
        .icon-file_csv{background-position:-32px -16px}
        .icon-file_excel{background-position:-48px -16px}
        .icon-file_film{background-position:-64px -16px}
        .icon-file_flash{background-position:-80px -16px}
        .icon-file_font{background-position:-96px -16px}
        .icon-file_html{background-position:-112px -16px}
        .icon-file_illustrator{background-position:-128px -16px}
        .icon-file_image{background-position:-144px -16px}
        .icon-file_music{background-position:-160px -16px}
        .icon-file_outlook{background-position:-176px -16px}
        .icon-file_pdf{background-position:-192px -16px}
        .icon-file_photoshop{background-position:-208px -16px}
        .icon-file_php{background-position:-224px -16px}
        .icon-file_playlist{background-position:-240px -16px}
        .icon-file_powerpoint{background-position:-256px -16px}
        .icon-file_swf{background-position:-272px -16px}
        .icon-file_terminal{background-position:-288px -16px}
        .icon-file_text{background-position:-304px -16px}
        .icon-file_word{background-position:-320px -16px}
        .icon-file_zip{background-position:-336px -16px}
        .icon-logout{background-position:-304px 0}
        .icon-chain{background-position:-320px 0}
        .icon-link_folder{background-position:-352px -16px}
        .icon-link_file{background-position:-368px -16px}
   
    </style>
    </head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
        <img src="img/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
      </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Моя ФайловаяПомоечка</a>
        </li>
         <li class="nav-item">
           <a class="btn btn-outline-danger" aria-current="page" href="/login.php?auth=1">Выход</a>
        </li>
          
          
      </ul>
    </div>
  </div>
</nav>    
    
    
    