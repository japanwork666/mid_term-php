<?php include './parts/head.php' ?>
<title>Test for Layout</title> <!-- 網頁標題可自行修改-->
<style>
    /* CSS可以自行修改 */
</style>
</head>

<body style="background-color:#57BC90;">

    <?php include './parts/navbar.php' ?>
    <div class="main_screen d-flex justify-content-between">
        <button id="OffcanvasNav" class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fa-solid fa-caret-right"></i></button>

        <?php include './parts/john_parts/back/index_.php' ?>
        <!-- 路徑可自行修改-->
    </div>

    <?php include './parts/scripts.php' ?>
    <script>
        //可自行修改JS
    </script>
    <?php include './parts/foot.php' ?>