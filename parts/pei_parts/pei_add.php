<?php
$pageName = 'add';
// $title = '新增';
include './parts/pei_parts/connect-db.php';

?>
<?php #include './parts/html-head.php' 
?>
<?php #include './parts/navbar.php' 
?>

<?php
//將景點類型資料表名稱讀出來
$sql_type = "SELECT `type_name` FROM `attractions＿type` WHERE 1";
$typeArray = $pdo->query($sql_type)->fetchAll();
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
                    <h5 class="card-title">新增景點</h5>
                    <form name=form1 onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="name " class="form-label">*景點名稱</label>
                            <input type="text" class="form-control" id="name" name="name" data-require="1">
                            <div class="form-text" style="color:red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="type_name" class="form-label">景點類別</label>
                            <select name="type_name" id="type_name" class="form-control">
                                <option selected>--請選擇---</option>
                                <?php foreach ($typeArray as $i) : ?>
                                    <option value="<?= $i['type_name'] ?>"><?= $i['type_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">城市</label>
                            <select class="form-select" aria-label="Default select example" id="city" name="city">
                                <option selected>---請選擇---</option>
                                <option value="台北市">台北市</option>
                                <option value="新北市">新北市</option>
                                <option value="基隆市">基隆市</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="city" name="city"> -->
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">介紹</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="open_time" class="form-label">開放時間</label>
                            <input type="text" class="form-control" id="open_time" name="open_time" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">地址</label>
                            <textarea class="form-control" id="address" name="address" data-required="1"></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tel" class="form-label">電話</label>
                            <input type="text" class="form-control" id="tel" name="tel" data-required="1">
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

        // for (let f of fields) {
        //     // 出錯時標示出外觀的樣式
        //     f.style.border = '1px solid #CCC';
        //     f.nextElementSibling.innerHTML = '';
        // }
        // nameField.style.border = '1px solid #CCC';
        // nameField.nextElementSibling.innerHTML = '';

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

            fetch('pei_add-api.php', {
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
    }

    function goback() {
        window.location = './pei_view_custom_itinerary.php'
    }
</script>
<?php # include './parts/html-foot.php' 
?>