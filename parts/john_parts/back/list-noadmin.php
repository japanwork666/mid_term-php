<?php
# MVC
$pageName = 'list';
$title = '列表';

require './parts/john_parts/back/part/connect-db.php';

$perPage = 10; #每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; #用戶要看第幾頁

if ($page < 1) {
    header('Location:?page=1');
    exit;
}

$t_sql = 'SELECT COUNT(1) FROM `member`';
// $t_row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);
// echo json_encode($t_row);
// exit;
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數

// echo "$totalRows, $totalPages";
// exit();
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM `member` ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}
?>


<div class="container">
    <div class="row">
        <?php include './parts/john_parts/back/part/navbar.php'; ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=1"><i class="fa-solid fa-angles-left"></i></a>
                </li>

                <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
                </li>

                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i >= 1 and $i <= $totalPages) :
                ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                <?php endif;
                endfor; ?>
                <li class="page-item  <?= $totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
                <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col"><i class="fa-solid fa-trash"></i></th>
                    <th scope="col">帳號</th>
                    <th scope="col">密碼</th>
                    <th scope="col">大頭貼</th>
                    <th scope="col">姓名</th>
                    <th scope="col">生日</th>
                    <th scope="col">身分證密碼</th>
                    <th scope="col">性別</th>
                    <th scope="col">居住地</th>
                    <th scope="col">身高</th>
                    <th scope="col">體重</th>
                    <th scope="col">星座</th>
                    <th scope="col">血型</th>
                    <th scope="col">抽菸</th>
                    <th scope="col">酒量</th>
                    <th scope="col">教育程度</th>
                    <th scope="col">職業</th>
                    <th scope="col">自介</th>
                    <th scope="col">手機</th>
                    <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <td><a href="javascript: delete_it(<?= $r['member_id'] ?>)"><i class="fa-solid fa-trash"></i></a></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= $r['password'] ?></td>
                        <td><?= $r['images'] ?></td>
                        <td><?= $r['member_name'] ?></td>
                        <td><?= $r['member_birth'] ?></td>
                        <td><?= $r['id_number'] ?></td>
                        <td><?= $r['gender'] ?></td>
                        <td><?= $r['location'] ?></td>
                        <td><?= $r['height'] ?></td>
                        <td><?= $r['weight'] ?></td>
                        <td><?= $r['zodiac'] ?></td>
                        <td><?= $r['bloodtype'] ?></td>
                        <td><?= $r['smoke'] ?></td>
                        <td><?= $r['alchohol'] ?></td>
                        <td><?= $r['education_level'] ?></td>
                        <td><?= $r['job'] ?></td>
                        <td><?= $r['profile'] ?></td>
                        <td><?= $r['mobile'] ?></td>
                        <td><a href="account_edit.php?member_id=<?= $r['member_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php #include './parts/scripts.php'; 
?>

<script>
    document.querySelector('li.page-item.active a').removeAttribute('href');

    function delete_it(member_id) {
        if (confirm(`是否要刪除編號為 ${member_id} 的資料?`)) {
            location.href = 'account_delete.php?member_id=' + member_id;
        }

    }
</script>

<?php #include './parts/html-foot.php'; 
?>