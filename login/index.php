<?php
  ob_start();
$titlepage = "ورود به سیستم";
session_start();
require('header-login.php'); ?>
<style>
.bars {



	}</style>
<body class="login-page">

    <form id="logn" class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><img src="<?php echo BASE_URL; ?>/inc/assets/images/logo_l.png" width="150" alt="" title="" /></a><br/>
            <small>نرم افزار حسابداری بهمن</small>
        </div>
        <div class="card">
            <div class="body">
                <div id="lgn">
                    <div class="msg"><?php 
						if(isset($_GET['log']) && $_GET['log']='true') {
						echo '<i class="material-icons col-orange lgot">warning</i><span class="font-bold col-orange">از سیستم خارج شدید</span>';
						}else {

						    echo (isset($_SESSION['lgn']) ? 'وارد سایت شده اید <a href="'.BASE_URL.'/login/logout.php?home='.BASE_URL.'/login/index.php&log=true">"خروج"</a>' : 'برای ورود نام کاربری و رمز را وارد نمایید');  }
 ?></div>
                   <?php if(!isset($_SESSION['lgn'])) { ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" id="user" name="username" placeholder="نام کاربری را وارد نمایید" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" id="pass" name="password" placeholder="رمز عبور را وارد نمایید" required>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-xs-4 col-xs-offset-8 btlg">
                          <input type="hidden" value="lg" name="lg" />
						<?php	echo '<input type="hidden" name="location" id="location" value="';
if(isset($_GET['location'])) {
    echo htmlspecialchars($_GET['location']);
}
	echo '" />'; ?>
                            <button class="btn btn-block bg-pink waves-effect vorud" data-type="ajax-loader" type="submit">ورود</button>
                        </div>
                    </div>
                    <?php }else {
	echo'<a href="/account/index.php" class="btn btn-block btn-lg bg-green waves-effect">ورود به سیستم</a>';
} ?>
                </div>
            </div>
        </div>
    </form>

  
<?php include('footer-login.php'); ?>