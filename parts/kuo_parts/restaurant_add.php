<?php

require './parts/kuo_parts/restaurant_connect-db.php';

// 取地區資料
$sql_area = "SELECT * FROM area_list WHERE 1";
$areaArray = $pdo->query($sql_area)->fetchAll();

// 取料理類型資料
$sql_class = "SELECT * FROM restaurant_class WHERE 1";
$classArray = $pdo->query($sql_class)->fetchAll();

// 每頁要顯示的資料數量
$perPage = 10;
#計算總筆數
$t_sql = "SELECT COUNT(1) FROM restaurant_list";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// 計算總頁數
$totalPage = ceil($totalRows / $perPage);


?>



<style>
    form .mb-3 .form-text {
        color: #57BC90;
    }

    h5 {
        color: #57BC90;
    }
</style>

<div class="container my-3">
    <div class="row">
        <div class="col-6">
            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title fs-3">新增餐廳資料</h5>
                    <form name="restaurant_addform" onsubmit="restForm(event)">
                        <div class="mb-3">
                            <label for="rest_name" class="form-label">餐廳名稱</label>
                            <input type="text" class="form-control" id="rest_name" name="rest_name" value="<?= isset($_POST['rest_name']) ? htmlentities($_POST['rest_name']) : '' ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="rest_area" class="form-label" class="form-control">所在縣市</label>
                            <select name="rest_area" id="rest_area" class="form-select" aria-label="Default select example" data-required="2">
                                <option selected>--請選擇--</option>
                                <?php foreach ($areaArray as $i) : ?>
                                    <option value="<?= $i['area_name'] ?>"><?= $i['area_name'] ?></option>
                                <?php endforeach ?>

                            </select>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="rest_adress" class="form-label">地址</label>
                            <input type="text" class="form-control" id="rest_adress" name="rest_adress" value="<?= isset($_POST['rest_adress']) ? htmlentities($_POST['rest_adress']) : '' ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="rest_lon" class="form-label">經度</label>
                            <input type="text" class="form-control" id="rest_lon" name="rest_lon" data-required="1" data-required="3">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="rest_lat" class="form-label">緯度</label>
                            <input type="text" class="form-control" id="rest_lat" name="rest_lat" data-required="1" data-required="3">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="rest_intro" class="form-label">介紹文字</label>
                            <textarea name="rest_intro" id="rest_intro" class="form-control" aria-label="With textarea" data-required="1"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="rest_class" class="form-label">料理類型</label>

                            <select name="rest_class" id="rest_class" class="form-select" aria-label="Default select example" data-required="2">
                                <option selected>--請選擇--</option>

                                <?php foreach ($classArray as $c) : ?>
                                    <option value="<?= $c['rest_class'] ?>"><?= $c['rest_class'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="form-text"></div>
                        </div>
                        <!-- 上傳檔案 -->
                        <!-- <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02">
                            <label class="input-group-text" for="inputGroupFile02"><i class="fa-solid fa-ellipsis"></i></label>
                        </div> -->

                        <!-- <div class="mb-3">
                            <label for="">資料建立時間</label>

                        </div> -->

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">新增</button>

                    </form>
                </div>
            </div>


        </div>
    </div>



</div>
<script>
    const infoBar = document.querySelector('#infoBar');

    const fields = document.querySelectorAll('form *[data-required="1"]');
    const selects = document.querySelectorAll('form *[data-required="2"]');

    function restForm(event) {
        event.preventDefault();
        for (let f of fields) {

            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = ''
        }
        for (let s of selects) {

            s.style.border = '1px solid #ccc';
            s.nextElementSibling.innerHTML = ''
        }

        let ispass = true; // 預設值是通過的

        // TODO: 檢查欄位資料
        for (let f of fields) {
            if (!f.value) {
                ispass = false;
                f.style.border = '1px solid #57BC90';
                f.nextElementSibling.innerHTML = '請輸入資料'
            }

        }

        for (let s of selects) {
            if (s.value == '--請選擇--') {
                ispass = false;
                s.style.border = '1px solid #57BC90';
                s.nextElementSibling.innerHTML = '請選擇欄位'
            }

        }


        if (ispass) {
            const fd = new FormData(document.restaurant_addform);

            fetch('kuo_restaurant_add_api.php', {
                    method: 'POST',
                    body: fd,
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '新增成功'
                        infoBar.style.display = 'block';
                        setTimeout(() => {
                            goback();
                        }, 2000);

                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '新增失敗'
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000);

                })
                .catch(ex => {
                    console.log(ex);
                    infoBar.classList.remove('alert-success')
                    infoBar.classList.add('alert-danger')
                    infoBar.innerHTML = '資料格式有誤'
                    infoBar.style.display = 'block';
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000);
                })
        } else {
            // 沒通過檢查
        }
    }

    function goback() {
        // let previousPageUrl = document.referrer;
        // location.href = previousPageUrl;
        window.location.href = './kuo_restaurant_list.php?page=<?= $totalPage ?>'
    }
</script>