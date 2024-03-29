<?php include './parts/head.php' ?>
<title><?= isset($title) ? $title . '-FriendTrip' : 'FriendTrip' ?>
</title><!-- 網頁標題可自行修改-->
<style>
    table>thead>tr>th:nth-child(1) {
        width: 2%;
    }

    table>thead>tr>th:nth-child(2) {
        width: 8%;
    }

    table>thead>tr>th:nth-child(3) {
        width: 5%;
    }

    table>thead>tr>th:nth-child(4) {
        width: 5%;
    }

    table>thead>tr>th:nth-child(5) {
        width: 45%;
    }
</style>
</style>
</head>

<body>

    <?php include './parts/navbar.php'
    ?>
    <div class="main_screen d-flex justify-content-between">
        <button id="OffcanvasNav" class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fa-solid fa-caret-right"></i></button>

        <?php include './parts/pei_parts/list.php' ?> <!-- 路徑可自行修改-->
    </div>

    <script>
        //可自行修改JS
    </script>
    <?php include './parts/foot.php' ?>