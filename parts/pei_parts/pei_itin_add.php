<?php
$pageName = 'add';
// $title = '新增';
include './parts/pei_parts/connect-db.php';

?>
<?php #include './parts/html-head.php'
?>
<?php #include './parts/navbar.php' 
?>
<!-- 抓取會員全部id和name(遞增方式呈現)-->
<?php
$m_sql = "SELECT * FROM `member` ORDER BY `member_id` ASC";
$m_rows = $pdo->query($m_sql)->fetchAll();
?>


<style>
    .form-text {
        color: red;
    }
</style>

<div class="container">
    <div class="row mt-4">
        <div class="col-6 ">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">行程</h5>
                    <form name=form1 onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="itin_id " class="form-label">行程編號</label>
                            <input type="text" class="form-control" id="itin_id" name="itin_id" data-required="1">
                            <div class="form-text" style="color:red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="member_id" class="form-label">會員編號</label>
                            <select name="member_id" id="member_id" class="form-control" data-required="1">
                                <?php foreach ($m_rows as $r) : ?>
                                    <option value="<?= $r['member_id'] ?>">
                                        <?= $r['member_id'] . "-" . $r['member_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text" style="color:red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="ppl" class="form-label">人數</label>
                            <input type="text" class="form-control" id="ppl" name="ppl" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="date " class="form-label">日期</label>
                            <input type="date" class="form-control" id="date" name="date" data-required="1">
                            <div class="form-text" style="color:red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">*名稱</label>
                            <input type="text" class="form-control" id="name" name="name" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">說明</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="public" class="form-label">是否需要公開</label>
                            <input class="form-check-input" type="radio" name="public" id="public" value="公開">
                            <label class="form-check-label" for="public">公開</label>
                            <input class="form-check-input" type="radio" name="public" id="public" value="不公開">
                            <label class="form-check-label" for="public">不公開</label>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="create_at" class="form-label">建立時間</label>
                            <input type="text" class="form-control" id="create_at" name="create_at">
                            <div class="form-text"></div>
                        </div>
                        <div class="alert alert-danger" role="alert" id="infoBar" style="display: none;"></div>
                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include './parts/scripts.php' ?>
<script>
    const nameField = document.querySelector('#name');
    const infoBar = document.querySelector('#infoBar');

    //取得必填欄位
    const fields = document.querySelectorAll('form *[data-required="1"]');


    function checkForm(event) {
        event.preventDefault(); //不要用傳統方式送出去
        let isPass = true; // 預設值是通過的

        // TODO:檢查欄位資料
        for (let f of fields) {
            if (!f.value) {
                isPass = false;
                f.style.border = '1px solid red';
                f.nextElementSibling.innerHTML = '請填入資料';
            }
        }

        if (nameField.value.length < 2) {
            isPass = false;
            nameField.style.border = '1px solid red';
            nameField.nextElementSibling.innerHTML = '請輸入至少兩個字';
        }

        if (isPass) {
            // 有通過就執行
            const fd = new FormData(document.form1); //沒有外觀的form的物件
            // const usp = new URLSearchParams(fd); //可以轉換為urlencoded格式
            // console.log(usp.toString());

            fetch('pei_itin_add-api.php', {
                    method: 'POST',
                    body: fd, //Content-Type 省略,multipart/form-data
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '新增成功'
                        infoBar.style.display = 'block';
                        setTimeout(() => {
                            goback();
                        }, 2000)

                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '新增失敗'
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000)
                })
                .catch(ex => {
                    console.log(ex)
                    infoBar.classList.remove('alert-success')
                    infoBar.classList.add('alert-danger')
                    infoBar.innerHTML = '新增發生錯誤'
                    infoBar.style.display = 'block';
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000)
                })
        } else {
            //沒有通過
        }
    };
    // 時間顯示
    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth() + 1;
    const day = now.getDate();
    const hour = now.getHours();
    const minute = now.getMinutes();
    const second = now.getSeconds();
    const formattedTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
    document.getElementById("create_at").value = formattedTime;

    function goback() {
        window.location = './pei_itin_custom_itinerary.php'
    }
</script>
<?php # include './parts/html-foot.php' 
?>