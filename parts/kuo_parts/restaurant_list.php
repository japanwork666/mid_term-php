<?php
// 連線資料庫
require './parts/kuo_parts/restaurant_connect-db.php';

// 取地區資料以放到下拉式選單
$sql_area = "SELECT * FROM area_list WHERE 1";
$areaArray = $pdo->query($sql_area)->fetchAll();

// 取餐廳類型資料以放到下拉式選單
$sql_class = "SELECT * FROM restaurant_class WHERE 1";
$classArray = $pdo->query($sql_class)->fetchAll();

?>


<div class="container mt-5" style="width:100%">
    <!-- 搜尋功能 -->
    <form name="searchForm" class="input-group" method="get">
        <div class="mb-3">
            <div class="mb-3 d-flex flex-row">
                <!-- 縣市搜尋下拉選單 -->
                <div class="me-3">
                    <select name="search-area" id="search-area" class="form-select" aria-label="Default select example" data-required="2">
                        <option selected>依縣市搜尋</option>
                        <?php foreach ($areaArray as $i) : ?>
                            <option value="<?= isset($i['area_name']) ? $i['area_name'] : null ?>"><?= $i['area_name'] ?></option>
                        <?php endforeach ?>

                    </select>
                </div>
                <!-- 餐廳類型下拉選單 -->
                <div class="me-3">
                    <select name="search-class" id="search-class" class="form-select" aria-label="Default select example" data-required="2">
                        <option selected>依餐廳類型搜尋</option>
                        <?php foreach ($classArray as $c) : ?>
                            <option value="<?= isset($c['rest_class']) ? $c['rest_class'] : null ?>"><?= $c['rest_class'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <!-- 搜尋鈕 -->
                <div class="me-3">
                    <button id="submit" type="submit" class="btn btn-primary" style="color:white">搜尋</button>
                </div>
            </div>
            <!-- 搜尋結果顯示 -->
            <div>
                <!-- 「搜尋結果」文字 -->
                <div class="my-3" style="font-size:18px;font-weight:800">
                    <?php
                    if (isset($_GET['search-area'])) { ?>
                        <?= ($_GET['search-area'] != null) && ($_GET['search-area'] != '依縣市搜尋' || $_GET['search-class'] != '依餐廳類型搜尋') ? '搜尋結果：' : ''; ?>
                    <?php }; ?></div>

                <!-- 搜尋結果 -->
                <div class="alert alert-success" role="alert" style=<?= (isset($_GET['search-area']) && $_GET['search-area'] != null) && ($_GET['search-area'] != '依縣市搜尋' || $_GET['search-class'] != '依餐廳類型搜尋') ? "display:block"  : "display:none" ?>>
                    <!-- 縣市搜尋結果 -->
                    <div class="mt-2" style="font-size:18px;font-weight:600"><?= isset($_GET['search-area']) && $_GET['search-area'] != '依縣市搜尋' ? '縣市：' . $_GET['search-area'] : '' ?></div>
                    <!-- 餐廳類型結果 -->
                    <div class="mt-2" style="font-size:18px;font-weight:600"><?= isset($_GET['search-class']) && $_GET['search-class'] != '依餐廳類型搜尋' ? '餐廳類型：' . $_GET['search-class'] : '' ?></div>
                </div>
            </div>


    </form>



    <?php
    // 每頁要顯示的資料數量
    $perPage = 10;

    // 使用者當前查看的頁面是第幾頁,強制轉int為了不讓人拿字串亂試網址
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;



    // 搜尋後顯示資料
    $search_area = isset($_GET['search-area']) ? $_GET['search-area'] : null; //取得縣市搜尋結果

    $search_class = isset($_GET['search-class']) ? $_GET['search-class'] : null; //取得餐廳類型搜尋結果

    // 設定搜尋結果type，方便用swirch case語法
    $search_result_type = 0;

    // 預先設定變數以免剛進入頁面還沒開始搜尋時變數為空而報錯
    $total_search_row = [];

    // 判斷搜尋結果type
    if ($search_area != '依縣市搜尋' && $search_class != '依餐廳類型搜尋' && $search_area != null && $search_class != null) { //兩個都有查詢
        $search_sql = sprintf("SELECT COUNT(1) FROM restaurant_list WHERE rest_area='%s' AND`rest_class`='%s'", $search_area, $search_class);
        $total_search_row = $pdo->query($search_sql)->fetch(PDO::FETCH_NUM)[0];
        $search_result_type = 1;
        // echo 'A';
    } elseif ($search_area != '依縣市搜尋' && $search_class == '依餐廳類型搜尋') { //只查詢縣市
        $search_sql = sprintf("SELECT COUNT(1) FROM restaurant_list WHERE rest_area='%s'", $search_area);
        $total_search_row = $pdo->query($search_sql)->fetch(PDO::FETCH_NUM)[0];
        $search_result_type = 2;
        // echo 'B';
    } elseif ($search_area == '依縣市搜尋' && $search_class != '依餐廳類型搜尋') { //只查詢餐廳類型
        $search_sql = sprintf("SELECT COUNT(1) FROM restaurant_list WHERE rest_class='%s'", $search_class);
        $total_search_row = $pdo->query($search_sql)->fetch(PDO::FETCH_NUM)[0];
        $search_result_type = 3;
        // echo 'C';
    } elseif ($search_area == '依縣市搜尋' && $search_class == '依餐廳類型搜尋') {
        // echo "<script language='JavaScript'>alert('請選擇搜尋條件');</script>";
        echo "<div class='alert alert-warning' role='alert' style='font-size:18px;font-weight:700'>請選擇搜尋條件</div>";
    }
    // 沒找到資料要顯示
    if ($total_search_row == 0 && $search_area != null && $search_class != null) {
        // echo "<script language='JavaScript'>alert('未找到資料');</script>";
        echo "<div class='alert alert-warning' role='alert' style='font-size:18px;font-weight:700'>未找到資料</div>";
    }

    // 判斷要顯示甚麼條件、多少筆資料
    if ($total_search_row) {
        // echo "<script language='JavaScript'>count();</script>"
        echo '<div  class"mb-3" style="font-size:18px;font-weight:800">共有 <a style="color: #BD608E">' . $total_search_row . '</a> 筆資料</div>';

        switch ($search_result_type) {
            case 1:
                // 計算總頁數
                $totalPage = ceil($total_search_row / $perPage);
                $rows = [];
                $sql = sprintf("SELECT * FROM restaurant_list WHERE rest_area='%s' AND`rest_class`='%s' LIMIT %s,%s", $search_area, $search_class, ($page - 1) * $perPage, $perPage);
                #依照在第幾頁，撈取對應資料，例如第一頁顯示1-10筆資料，第二頁顯示第11-20筆資料

                $rows = $pdo->query($sql)->fetchAll();
                // echo 'Aa';

                break;
            case 2:
                // 計算總頁數
                $totalPage = ceil($total_search_row / $perPage);
                $rows = [];
                $sql = sprintf("SELECT * FROM restaurant_list WHERE rest_area='%s' LIMIT %s,%s", $search_area, ($page - 1) * $perPage, $perPage);
                #依照在第幾頁，撈取對應資料，例如第一頁顯示1-10筆資料，第二頁顯示第11-20筆資料

                $rows = $pdo->query($sql)->fetchAll();
                // echo 'Bb';
                break;
            case 3:
                // 計算總頁數
                $totalPage = ceil($total_search_row / $perPage);
                $rows = [];
                $sql = sprintf("SELECT * FROM restaurant_list WHERE rest_class='%s' LIMIT %s,%s", $search_class, ($page - 1) * $perPage, $perPage);
                #依照在第幾頁，撈取對應資料，例如第一頁顯示1-10筆資料，第二頁顯示第11-20筆資料

                $rows = $pdo->query($sql)->fetchAll();
                // echo 'Cc';
                break;
        }

        // 如果當前頁碼大於總頁數
        if ($page > $totalPage) {
            header("Location:?page=$totalPage");
        }
    } else {

        //設定未選擇搜尋條件時要顯示的資料筆數
        if (($search_area == null && $search_class == null) || ($search_area == '依縣市搜尋' && $search_class == '依餐廳類型搜尋')) {
            // echo 'EEE';
            #計算總筆數
            $t_sql = "SELECT COUNT(1) FROM restaurant_list";
            $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

            // 計算總頁數
            $totalPage = ceil($totalRows / $perPage);

            $rows = [];

            // 如果資料庫有資料再做資料撈取跟顯示
            if ($totalRows) {

                $sql = sprintf("SELECT * FROM restaurant_list LIMIT %s,%s", ($page - 1) * $perPage, $perPage);
                #依照在第幾頁，撈取對應資料，例如第一頁顯示1-10筆資料，第二頁顯示第11-20筆資料

                $rows = $pdo->query($sql)->fetchAll();

                // 如果當前頁碼大於總頁數
                if ($page > $totalPage) {
                    header("Location:?page=$totalPage");
                }
            }
        } else {
            // echo 'DDD';
            // echo '<div  class="mb-3" style="font-size:18px;font-weight:800">共有 <a style="color:red">'  . 0 . '</a> 筆資料</div>';

            // 設定條件不符合時要顯示的資料
            #計算總筆數
            $t_sql = "SELECT COUNT(1) FROM restaurant_list";
            $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

            // 計算總頁數
            $totalPage = ceil($totalRows / $perPage);

            $rows = [];

            // 如果資料庫有資料再做資料撈取跟顯示
            if ($totalRows) {

                $sql = sprintf("SELECT * FROM restaurant_list LIMIT %s,%s", ($page - 1) * $perPage, $perPage);
                #依照在第幾頁，撈取對應資料，例如第一頁顯示1-10筆資料，第二頁顯示第11-20筆資料

                $rows = $pdo->query($sql)->fetchAll();

                // 如果當前頁碼大於總頁數
                if ($page > $totalPage) {
                    header("Location:?page=$totalPage");
                }
            }
        }
    }
    #限制網址列輸入零或負數頁碼要跳回第一頁
    if ($page < 1) {
        header('Location:?page=1');
        exit;
    }


    ?>

    <!-- 頁面呈現 -->

    <div class="row mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-1">餐廳編號</th>
                    <th class="col-1">餐廳名稱</th>
                    <th class="col-1">所在縣市</th>
                    <th class="col-1">地址</th>
                    <th class="col">經度</th>
                    <th class="col">緯度</th>
                    <th class="col">介紹文字</th>
                    <th class="col-1">餐廳類型</th>
                    <th class="col">創建日期</th>
                    <th class="col"></th>
                    <th class="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <td><?= $r['rest_id'] ?></td>
                        <td><?= $r['rest_name'] ?></td>
                        <td><?= $r['rest_area'] ?></td>
                        <td><?= $r['rest_adress'] ?></td>
                        <td><?= $r['rest_lon'] ?></td>
                        <td><?= $r['rest_lat'] ?></td>
                        <td><?= $r['rest_intro'] ?></td>
                        <td><?= $r['rest_class'] ?></td>
                        <td><?= $r['created_time'] ?></td>

                        <!-- 編輯資料(icon) -->
                        <td>
                            <a style="color:litghtblue" href="kuo_restaurant_edit.php?rest_id=<?= $r['rest_id'] ?>">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </td>
                        <!-- 刪除資料(icon)-->
                        <td>
                            <a href="javascript: deleteData(<?= $r['rest_id'] ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">

                <!-- 最前頁 -->
                <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>"><a class="page-link" href="?page=1">最前頁</a></li>

                <!-- 回上頁 -->
                <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">上一頁</a>
                </li>

                <?php for ($i = $page - 5; $i <= $page + 5; $i++) : ?>
                    <?php if ($i >= 1 and $i <= $totalPage) : ?>
                        <!-- 當前頁 -->
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif ?>
                <?php endfor ?>

                <!-- 下一頁 -->
                <li class="page-item <?= $totalPage == $page ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>">下一頁</a></li>
                <a href="?
                <?php
                if (isset($_GET['search-area'])) : ?>
                    page=<?= $page + 1 ?>" ; <?php else :
                                                echo "page=<?= $page + 1 ?>"; ?> <?php endif;
                                                    ?>">
                    href="?
                    <?php
                    if (isset($_GET['search-area'])) : ?>
                        page=<?= $page + 1 ?>";


                    <?php else :
                        echo "page=<?= $page + 1 ?>"; ?>
                        <?php endif;
                        ?>"
                </a>
                <!-- 最後頁 -->
                <li class="page-item <?= $totalPage == $page ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $totalPage ?>">最後頁</a></li>
            </ul>
        </nav>
    </div>

</div>


<script>
    // 滑鼠移到當前頁的頁碼無法有超連結效果
    document.querySelector('li.page-item.active a').removeAttribute('href'); //有問題

    // 刪除function
    function deleteData(sid) {
        if (confirm(`確認刪除編號${sid}的資料`)) {
            location.href = 'kuo_restaurant_delete_api.php?sid=' + sid;
        }

    }
</script>