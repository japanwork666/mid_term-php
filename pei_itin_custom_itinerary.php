<?php include './parts/head.php' ?>
<title><?= isset($title) ? $title . '-FriendTrip' : 'FriendTrip' ?>
</title><!-- 網頁標題可自行修改-->
<style>

   
</style>
</style>
</head>

<body>

    <?php include './parts/navbar.php'
    ?>
    <div class="main_screen d-flex justify-content-between">
        <button id="OffcanvasNav" class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fa-solid fa-caret-right"></i></button>

        <?php include './parts/pei_parts/itin_list.php' ?> <!-- 路徑可自行修改-->
    </div>

    <script>
        //可自行修改JS
    </script>
    <?php include './parts/foot.php' ?>