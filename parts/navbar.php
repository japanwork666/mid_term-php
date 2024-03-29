<!-- 組長公告：公用版型，勿動 -->
<nav class="navbar flex-column bg-cus2 offcanvas offcanvas-start show" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" aria-modal="true" role="dialog">
    <div class="navbar_content w-100">
        <div id="Logo" class="text-cus1 text-center pm-3">
            <div class="w-100 d-flex justify-content-end pe-3 pt-2">
                <button type="button" class="btn-close d-block" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <a href="account_main.php"><img src="./imgs/logo/logo.png" style="width: 70%"></a>
        </div>

        <ul class="navbar-nav d-flex align-items-center flex-grow-1">
            <!-- 會員中心 -->
            <li class="nav-item dropdown">


                <!-- <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false">
                        會員中心<br>
                    </a> -->

                <a class="link_btn" href="account.php" role="button">
                    <span class="material-symbols-outlined nav-icon">account_circle</span>
                    會員中心<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false"></a>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickable">
                    <li><a class="dropdown-item" href="account.php">列表</a></li>
                    <li><a class="dropdown-item" href="account_add.php">新增</a></li>
                </ul>
            </li>
         


            <!-- 自訂行程 -->
            <!-- <li class="nav-item" 待確認是否須保留>   
                <a href="custom_itinerary.php" class="link_btn">
                    <span class="material-symbols-outlined nav-icon">map</span>
                    <span class="nav-link">自訂行程</span>
                </a>
            </li> -->

            <!-- 景點 -->
            <li class="nav-item dropdown">
                <a class="link_btn" href="pei_view_custom_itinerary.php" role="button">
                    <i class="fa-solid fa-mountain"></i>
                    景點<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false"></a>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="pei_view_add_custom_itinerary.php">新增景點</a></li>
                </ul>
            </li>

            <!-- 自訂行程 -->
            <li class="nav-item dropdown">
                <a class="link_btn" href="pei_itin_custom_itinerary.php" role="button">
                    <span class="material-symbols-outlined nav-icon">map</span>
                    自訂行程<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false"></a>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="pei_itin_add_custom_itinerary.php">行程增加資料庫</a></li>
                </ul>
            </li>


            <!-- 餐廳 & 票券 -->
            <!-- <li class="nav-item">
                <a href="ticket.php" class="link_btn">
                    <span class="material-symbols-outlined nav-icon">local_activity</span>
                    <span class="nav-link">餐廳</span>
                </a>
            </li> -->
            <li class="nav-item dropdown">
                <a class="link_btn" href="kuo_restaurant_list.php" role="button">
                    <i class="fa-solid fa-utensils"></i>
                    餐廳管理<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false"></a>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="kuo_restaurant_list.php">餐廳管理
                            <!-- <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">
                                        新增餐廳
                                    </a></li>
                            </ul> -->
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="kuo_restaurant_add.php">新增餐廳</a></li>
                    <li><a class="dropdown-item" href="kuo_restaurant_class_list.php">餐廳類型管理</a></li>
                    <li><a class="dropdown-item" href="kuo_restaurant_class_add.php">新增餐廳類型</a></li>


                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="link_btn" href="kuo_reserve_list.php" role="button">
                    <span class="material-symbols-outlined nav-icon">local_activity</span>
                    訂位管理<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false"></a>
                </a>
                <ul class="dropdown-menu">

                    <li><a class="dropdown-item" href="kuo_reserve_list.php">訂位管理</a></li>
                    <li><a class="dropdown-item" href="kuo_reserve_add.php">新增訂位</a></li>

                </ul>
            </li>

            <!-- 官方行程 -->
            <li class="nav-item">
                <a href="official_itinerary.php" class="link_btn">
                    <span class="material-symbols-outlined nav-icon">travel_explore</span>
                    <span class="nav-link">官方行程</span>
                </a>
            </li>
            <!-- 留言板 -->
            <li class="nav-item">
                <a href="board.php" class="link_btn">
                    <span class="material-symbols-outlined nav-icon">mode_comment</span>
                    <span class="nav-link">留言板</span>
                </a>
            </li>

            <!-- 商品資料庫 -->
            <li class="nav-item">
                <a href="yun_product.php" class="link_btn">
                    <span class="material-symbols-outlined nav-icon">local_mall</span>
                    <span class="nav-link">商品資料庫</span>
                </a>
            </li>
            <!-- 購物資料庫 -->
            <li class="nav-item">
                <a href="yun_cart.php" class="link_btn">
                    <span class="material-symbols-outlined nav-icon">shopping_cart</span>
                    <span class="nav-link">購物車資料庫</span>
                </a>
            </li>
            <!-- 訂單資料庫 -->
            <li class="nav-item">
                <a href="yun_order.php" class="link_btn">
                    <span class="material-symbols-outlined">description</span>
                    <span class="nav-link">訂單資料庫</span>
                </a>
            </li>
        </ul>
    </div>
</nav>