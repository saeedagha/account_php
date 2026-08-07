<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>لطفا منتظر بمانید ...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->

<!-- #END# Search Bar -->
<!-- Top Bar -->

<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header" style="color: #FFF;">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="javascript:void(0);"> <?php echo 'امروز'. jdate(" l , d , F Y");?></a>
            <?php
            $url =  $_SERVER['REQUEST_URI'];
            if (str_ends_ba($url, 'moein.php')) {
                $current_page =  'cuurentPage';
            }else{
                $current_page='';
            }

?>

        </div>

    </div>
</nav>

<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <div class="user-info"></div>
        <!-- Menu -->

        <div class="menu">
            <ul class="list">
                <li class="header">صفحات اصلی</li>
                <li <?php echo (str_ends_ba($url, 'index.php') && !str_ends_ba($url, 'hesab/index.php')) ? ' class="active"' : ''; ?>>
                    <a href="<?php echo BASE_URL; ?>/index.php">
                        <i class="material-icons">dashboard</i>
                        <span>داشبورد مدیریتی</span>
                    </a>
                </li>
                <li <?php if (str_ends_ba($url, 'index.php') || str_ends_ba($url, 'kol.php') || str_ends_ba($url, 'moein.php') || str_ends_ba($url, 'tafsili.php') ) {
                    if(!str_ends_ba($url, 'hesab/index.php')){
                        echo ' class="active"';
                    }
                } ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">layers</i>
                        <span>دفاتر</span>
                    </a>
                    <ul class="ml-menu">
                        <li <?php if((str_ends_ba($url, 'ruznameh.php')) && (!str_ends_ba($url, 'hesab/index.php'))){ echo ' class="active"';} ?>>
                            <a href="<?php echo BASE_URL; ?>/ruznameh.php">

                                <span>روزنامه</span>
                            </a>
                        </li>
                        <li <?php echo (str_ends_ba($url, 'kol.php')) ? ' class="active"' : ''; ?>>
                            <a href="<?php echo BASE_URL; ?>/kol.php">

                                <span>کل</span>
                            </a>
                        </li>
                        <li <?php echo (str_ends_ba($url, 'moein.php')) ? ' class="active"' : ''; ?>>
                            <a href="<?php echo BASE_URL; ?>/moein.php">

                                <span>معین</span>
                            </a>
                        </li>
                        <li <?php echo (str_ends_ba($url, 'tafsili.php')) ? ' class="active"' : ''; ?>>
                            <a href="<?php echo BASE_URL; ?>/tafsili.php">

                                <span>تفضیلی</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li <?php echo (str_ends_ba($url, 'hesab/index.php') || str_ends_ba($url, 'hesab/new.php') ) ? ' class="active"' : ''; ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">book</i>
                        <span>حساب ها</span>
                    </a>
                    <ul class="ml-menu">
                        <li <?php echo (str_ends_ba($url, 'hesab/index.php')) ? ' class="active"' : ''; ?>>
                            <a href="<?php echo BASE_URL; ?>/hesab/index.php">

                                <span>همه حساب ها</span>
                            </a>
                        </li>
                        <li <?php echo (str_ends_ba($url, 'hesab/new.php')) ? ' class="active"' : ''; ?>>
                            <a href="<?php echo BASE_URL; ?>/hesab/new.php">

                                <span>حساب جدید</span>
                            </a>
                        </li>


                    </ul>
                </li>
                <li <?php echo (str_ends_ba($url, 'vam.php')) ? ' class="active"' : ''; ?>>
                    <a href="<?php echo BASE_URL; ?>/vam.php">
                        <i class="material-icons">sync</i>
                        <span>مدیریت وام ها</span>
                    </a>

                </li>
                <li <?php echo (str_ends_ba($url, 'report.php')) ? ' class="active"' : ''; ?>>
                    <a href="<?php echo BASE_URL; ?>/report.php">
                        <i class="material-icons">pie_chart</i>
                        <span>گزارشات</span>
                    </a>

                </li>

                <li <?php echo (str_ends_ba($url, 'setting.php')) ? ' class="active"' : ''; ?>>
                    <a href="<?php echo BASE_URL; ?>/setting.php">
                        <i class="material-icons">settings</i>
                        <span>تنظیمات</span>
                    </a>

                </li>
                <li <?php echo (str_ends_ba($url, 'bak.php')) ? ' class="active"' : ''; ?>>
                    <a href="<?php echo BASE_URL; ?>/inc/config/back.php">
                        <i class="material-icons">backup</i>
                        <span>پشتیبان گیری</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>/login/logout.php?home=<?php echo BASE_URL; ?>/login/index.php&log=true">
                        <i class="material-icons">exit_to_app</i>
                        <span>خروج</span>
                    </a>

                </li>


            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                © 1398-<?php echo  jdate("Y",'','','', 'en'); ?><a href="javascript:void(0);">نرم افزار حسابداری شخصی بهمن</a>
            </div>

        </div>
        <!-- #Footer -->
    </aside>

    <!-- #END# Left Sidebar -->

</section>