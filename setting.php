<?php
$titlepage = "تنظیمات";
require_once 'inc/config/autoload.php';
require(get_path('header.php'));
ob_start();

$idu = (int)addslashes(htmlentities($_SESSION['lgn']));
if (!empty($idu) && isset($idu)) {
    $sql = "SELECT * FROM ";
    $sql .= "`tbl_user` WHERE ";
    $sql .= "`id` = $idu";
    $stm = $conn->prepare($sql);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
}
if (isset($_POST['save_document_template'])) {

    $name = trim($_POST['template_name'] ?? '');
    $operationType = trim($_POST['template_operation_type'] ?? '');
    $hesabBed = (int)($_POST['template_hesab_bed'] ?? 0);
    $hesabBes = (int)($_POST['template_hesab_bes'] ?? 0);
    $sharh = trim($_POST['template_sharh'] ?? '');

    $allowedOperationTypes = array(
        'cost',
        'income',
        'transfer'
    );

    if (
        $name === '' ||
        !in_array($operationType, $allowedOperationTypes, true) ||
        $hesabBed <= 0 ||
        $hesabBes <= 0
    ) {
        echo '<div class="alert alert-danger">
                اطلاعات الگو کامل نیست.
              </div>';
    } else {

        try {

            $sql = "
                INSERT INTO `document_templates`
                (
                    `name`,
                    `operation_type`,
                    `hesab_bed`,
                    `hesab_bes`,
                    `sharh`,
                    `active`
                )
                VALUES
                (
                    :name,
                    :operation_type,
                    :hesab_bed,
                    :hesab_bes,
                    :sharh,
                    1
                )
            ";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':name' => $name,
                ':operation_type' => $operationType,
                ':hesab_bed' => $hesabBed,
                ':hesab_bes' => $hesabBes,
                ':sharh' => $sharh
            ]);

            header('Location: setting.php');
            exit;

        } catch (Exception $e) {

            echo '<div class="alert alert-danger">
                    خطا در ثبت الگو.
                  </div>';
        }
    }
}
// START Profile Settings
if (isset($_POST['profile_settings'])) {
    $error = array();
    $id = (int)addslashes(htmlentities($_SESSION['lgn']));
    if ($id == 0) {
        $id = NULL;
    }
    $username = addslashes(htmlentities($_POST['username']));
    echo $username;
    $email = addslashes(htmlentities($_POST["email"]));
    $title = addslashes(htmlentities($_POST["title"]));
    $mobile = addslashes(htmlentities($_POST["mobile"]));
    $sql = "UPDATE `tbl_user`  SET `username`= :username, `title`= :title,  `email`= :email,  `mobile`= :mobile  WHERE `id` = $id";
    $result = $conn->prepare($sql);
    if ($result->execute(array(
        "username" => $username,
        "title" => $title,
        "email" => $email,
        "mobile" => $mobile,
    ))) {
        $error['color'] = 'teal';
        $error['message'] = ' حساب کاربری  ' . $username . ' با موفقیت ویرایش شد ';
    } else {
        $error['color'] = 'pink';
        $error['message'] = 'مشکلی در ویرایش حساب کاربری به وجود آمد لطفا صفحه را مجدد بارگزاری کنید و یا در ورود مقادیر دقت نمایید';
    }
}
// END Profile Settings
// START Change Password settings
if (isset($_POST['sub_pass'])) {
    //  print_r($_POST);
    $error = array();
    $oldpassword = addslashes(htmlentities($_POST["oldpassword"]));
    $newpassword = addslashes(htmlentities($_POST["newpassword"]));
    $newpasswordconfirm = addslashes(htmlentities($_POST["newpasswordconfirm"]));
    $pass = HashPassword($oldpassword);
    $curpass = $row['password'];
    if ($pass == $curpass && $newpassword == $newpasswordconfirm) {
        $password = HashPassword($newpassword);
        $sql = "UPDATE `tbl_user`  SET `password`= :password  WHERE `id` = $idu ";
        $result = $conn->prepare($sql);
        if ($result->execute(array(
            "password" => $password,
        ))) {
            $error['color'] = 'teal';
            $error['message'] = 'رمز حساب با موفقیت ویرایش شد ';
        } else {
            $error['color'] = 'pink';
            $error['message'] = 'مشکلی در ویرایش رمز به وجود آمد لطفا صفحه را مجدد بارگزاری کنید و یا در ورود مقادیر دقت نمایید';
        }
    } else {
        $error['color'] = 'pink';
        $error['message'] = 'مشکلی در ویرایش رمز به وجود آمد لطفا صفحه را مجدد بارگزاری کنید و یا در ورود مقادیر دقت نمایید';
    }
}
// END Change Password settings
// START System Settings
if (isset($_POST['save_sys'])) {
    $error = array();
    $araye = array();
    $col_tsk = addslashes(htmlentities($_POST["col_tsk"]));
    $araye["col_tsk"] = $col_tsk;
    $sandugh_id = (int)addslashes(htmlentities($_POST["sandugh_id"]));
    $araye["sandugh_id"] = $sandugh_id;
    $income_id = (int)addslashes(htmlentities($_POST["income_id"]));
    $araye["income_id"] = $income_id;
    $vam_id = (int)addslashes(htmlentities($_POST["vam_id"]));
    $araye["vam_id"] = $vam_id;
    $ashkhas_id = (int)addslashes(htmlentities($_POST["ashkhas_id"]));
    $araye["ashkhas_id"] = $ashkhas_id;
    $cost_id = (int)addslashes(htmlentities($_POST["cost_id"]));
    $bx1 = (int)addslashes(htmlentities($_POST["bx1"]));
    $araye["bx1"] = $bx1;
    $bx2 = (int)addslashes(htmlentities($_POST["bx2"]));
    $araye["bx2"] = $bx2;
    $bx3 = (int)addslashes(htmlentities($_POST["bx3"]));
    $araye["bx3"] = $bx3;
    $bx4 = (int)addslashes(htmlentities($_POST["bx4"]));
    $araye["bx4"] = $bx4;
    $bx5 = (int)addslashes(htmlentities($_POST["bx5"]));
    $araye["bx5"] = $bx5;
    $bx6 = (int)addslashes(htmlentities($_POST["bx6"]));
    $araye["bx6"] = $bx6;
    $bx7 = (int)addslashes(htmlentities($_POST["bx7"]));
    $araye["bx7"] = $bx7;
    $bx8 = (int)addslashes(htmlentities($_POST["bx8"]));
    $araye["bx8"] = $bx8;
    $col_bx1 = addslashes(htmlentities($_POST["col_bx1"]));
    $araye["col_bx1"] = $col_bx1;
    $col_bx2 = addslashes(htmlentities($_POST["col_bx2"]));
    $araye["col_bx2"] = $col_bx2;
    $col_bx3 = addslashes(htmlentities($_POST["col_bx3"]));
    $araye["col_bx3"] = $col_bx3;
    $col_bx4 = addslashes(htmlentities($_POST["col_bx4"]));
    $araye["col_bx4"] = $col_bx4;
    $col_bx5 = addslashes(htmlentities($_POST["col_bx5"]));
    $araye["col_bx5"] = $col_bx5;
    $col_bx6 = addslashes(htmlentities($_POST["col_bx6"]));
    $araye["col_bx6"] = $col_bx6;
    $col_bx7 = addslashes(htmlentities($_POST["col_bx7"]));
    $araye["col_bx7"] = $col_bx7;
    $col_bx8 = addslashes(htmlentities($_POST["col_bx8"]));
    $araye["col_bx8"] = $col_bx8;
    foreach ($araye as $key => $value) {
        if ($rw = exist_key_option($key)) {
            $rw = (int)$rw;
            $sql = "UPDATE `tbl_opt`  SET `klid`= :klid, `val`= :val  WHERE `id` = $rw";
            $result = $conn->prepare($sql);
            if ($result->execute(array(
                "klid" => $key,
                "val" => $value,
            ))) {
                $error['color'] = 'teal';
                $error['message'] = 'تنظیمات به روز رسانی شد ';
            }
        } else {
            $sql = "INSERT INTO `tbl_opt` (`klid`, `val`) VALUES (:klid, :val);";
            $result = $conn->prepare($sql);
            if ($result->execute(array(
                "klid" => $key,
                "val" => $value,
            ))) {
                $error['color'] = 'teal';
                $error['message'] = 'تنظیمات به روز رسانی شد ';
            }
        }
    }
}
// END System Settings
// Setting Option
//$opt = setting_tbl();
$defaultOptions = array("
col_tsk" => "purple",
    "sandugh_id" => 0,
    "income_id" => 0,
    "vam_id" => 0,
    "ashkhas_id" => 0,
    "cost_id" => 0,
    "bx1" => 0,
    "bx2" => 0,
    "bx3" => 0,
    "bx4" => 0,
    "bx5" => 0,
    "bx6" => 0,
    "bx7" => 0,
    "bx8" => 0,
    "col_bx1" => "0",
    "col_bx2" => "0",
    "col_bx3" => "0",
    "col_bx4" => "0",
    "col_bx5" => "0",
    "col_bx6" => "0",
    "col_bx7" => "0",
    "col_bx8" => "0",
);
$customOptions =setting_tbl();
$opt = array_merge($defaultOptions, $customOptions);
$colors=array(
    "red",
    "pink",
    "purple",
    "deep-purple",
    "indigo",
    "blue",
    "light-blue",
    "cyan",
    "teal",
    "green",
    "light-green",
    "lime",
    "yellow",
    "amber",
    "orange",
    "deep-orange",
    "brown",
    "grey",
    "blue-grey",
    "black"
);
$document_templates = array();
try {
    $sql = "
        SELECT
            id,
            name,
            operation_type,
            hesab_bed,
            hesab_bes,
            sharh,
            active
        FROM `document_templates`
        ORDER BY id DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $document_templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $document_templates = array();
}
$template_operation_type = $_POST['template_operation_type']
    ?? 'cost';

$template_bed_accounts = get_document_template_accounts(
    $template_operation_type,
    'bed'
);

$template_bes_accounts = get_document_template_accounts(
    $template_operation_type,
    'bes'
);
?>
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12">
                    <?php if (isset($error) && !empty($error)) {
                        echo ' <div class="alert bg-' . $error['color'] . ' alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  ' . $error['message'] . '
                    </div>';
                    } ?>
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#document_templates"
                                           aria-controls="settings"
                                           role="tab"
                                           data-toggle="tab">
                                            الگوهای ثبت سند
                                        </a>
                                    </li>
                                    <li role="presentation "><a href="#system_settings"
                                                                               aria-controls="settings" role="tab"
                                                                               data-toggle="tab">تنظیمات سیستم</a></li>
                                    <li role="presentation "><a href="#profile_settings" aria-controls="settings"
                                                                role="tab" data-toggle="tab">تنظیمات کاربری</a></li>
                                    <li role="presentation"><a href="#change_password_settings" aria-controls="settings"
                                                               role="tab" data-toggle="tab">تغییر رمز</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel"
                                         class="tab-pane fade in active"
                                         id="document_templates">
                                        <div class="row clearfix">
                                            <div class="col-xs-12">
                                                <div class="card-inside-title">
                                                    <h3 style="margin-bottom: 25px;">
                                                        الگوهای ثبت سند
                                                    </h3>
                                                </div>
                                                <div class="text-left" style="margin-bottom: 15px;">
                                                    <button
                                                            type="button"
                                                            class="btn btn-primary waves-effect"
                                                            data-toggle="collapse"
                                                            data-target="#document_template_form"
                                                            aria-expanded="false"
                                                            aria-controls="document_template_form">
                                                        <i class="material-icons">add</i>
                                                        <span>افزودن الگو</span>
                                                    </button>
                                                </div>
                                                <div
                                                        id="document_template_form"
                                                        class="panel-collapse collapse"
                                                        style="margin-bottom: 25px;">

                                                    <div class="panel panel-primary">

                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                افزودن الگوی ثبت سند
                                                            </h4>
                                                        </div>

                                                        <div class="panel-body">

                                                            <form method="post">

                                                                <div class="row clearfix">

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>نام الگو</label>

                                                                            <div class="form-line">
                                                                                <input
                                                                                        type="text"
                                                                                        name="template_name"
                                                                                        class="form-control"
                                                                                        required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>نوع عملیات</label>

                                                                            <select
                                                                                    name="template_operation_type"
                                                                                    id="template_operation_type"
                                                                                    class="form-control show-tick"
                                                                                    required>

                                                                                <option value="cost">
                                                                                    هزینه
                                                                                </option>

                                                                                <option value="income">
                                                                                    درآمد
                                                                                </option>

                                                                                <option value="transfer">
                                                                                    انتقال وجه
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row clearfix">

                                                                    <div class="col-md-6">

                                                                        <div class="form-group">

                                                                            <label>حساب بدهکار</label>

                                                                            <select
                                                                                    name="template_hesab_bed"
                                                                                    id="template_hesab_bed"
                                                                                    class="form-control show-tick"
                                                                                    data-live-search="true"
                                                                                    required>

                                                                                <option value="">
                                                                                    انتخاب حساب بدهکار
                                                                                </option>

                                                                                <?php foreach ($template_bed_accounts as $key => $value) { ?>

                                                                                    <?php if (is_array($value)) { ?>

                                                                                        <optgroup
                                                                                                label="<?php echo htmlspecialchars(
                                                                                                    gethesabname($key),
                                                                                                    ENT_QUOTES,
                                                                                                    'UTF-8'
                                                                                                ); ?>">

                                                                                            <?php foreach ($value as $id => $name) { ?>

                                                                                                <option value="<?php echo (int)$id; ?>">
                                                                                                    <?php echo htmlspecialchars(
                                                                                                        $name,
                                                                                                        ENT_QUOTES,
                                                                                                        'UTF-8'
                                                                                                    ); ?>
                                                                                                </option>

                                                                                            <?php } ?>

                                                                                        </optgroup>

                                                                                    <?php } else { ?>

                                                                                        <option value="<?php echo (int)$key; ?>">
                                                                                            <?php echo htmlspecialchars(
                                                                                                $value,
                                                                                                ENT_QUOTES,
                                                                                                'UTF-8'
                                                                                            ); ?>
                                                                                        </option>

                                                                                    <?php } ?>

                                                                                <?php } ?>

                                                                            </select>

                                                                        </div>

                                                                    </div>


                                                                    <div class="col-md-6">

                                                                        <div class="form-group">

                                                                            <label>حساب بستانکار</label>

                                                                            <select
                                                                                    name="template_hesab_bes"
                                                                                    id="template_hesab_bes"
                                                                                    class="form-control show-tick"
                                                                                    data-live-search="true"
                                                                                    required>

                                                                                <option value="">
                                                                                    انتخاب حساب بستانکار
                                                                                </option>

                                                                                <?php foreach ($template_bes_accounts as $key => $value) { ?>

                                                                                    <?php if (is_array($value)) { ?>

                                                                                        <optgroup
                                                                                                label="<?php echo htmlspecialchars(
                                                                                                    gethesabname($key),
                                                                                                    ENT_QUOTES,
                                                                                                    'UTF-8'
                                                                                                ); ?>">

                                                                                            <?php foreach ($value as $id => $name) { ?>

                                                                                                <option value="<?php echo (int)$id; ?>">
                                                                                                    <?php echo htmlspecialchars(
                                                                                                        $name,
                                                                                                        ENT_QUOTES,
                                                                                                        'UTF-8'
                                                                                                    ); ?>
                                                                                                </option>

                                                                                            <?php } ?>

                                                                                        </optgroup>

                                                                                    <?php } else { ?>

                                                                                        <option value="<?php echo (int)$key; ?>">
                                                                                            <?php echo htmlspecialchars(
                                                                                                $value,
                                                                                                ENT_QUOTES,
                                                                                                'UTF-8'
                                                                                            ); ?>
                                                                                        </option>

                                                                                    <?php } ?>

                                                                                <?php } ?>

                                                                            </select>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                <div class="row clearfix">

                                                                    <div class="col-md-12">

                                                                        <div class="form-group">

                                                                            <label>شرح</label>

                                                                            <div class="form-line">

                                <textarea
                                        name="template_sharh"
                                        class="form-control"
                                        rows="3"></textarea>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                <div class="text-left">

                                                                    <button
                                                                            type="submit"
                                                                            name="save_document_template"
                                                                            class="btn btn-primary waves-effect">

                                                                        <i class="material-icons">save</i>
                                                                        <span>ذخیره</span>

                                                                    </button>

                                                                    <button
                                                                            type="button"
                                                                            class="btn btn-default waves-effect"
                                                                            data-toggle="collapse"
                                                                            data-target="#document_template_form">

                                                                        انصراف

                                                                    </button>

                                                                </div>

                                                            </form>

                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>نام الگو</th>
                                                            <th>نوع عملیات</th>
                                                            <th>حساب بدهکار</th>
                                                            <th>حساب بستانکار</th>
                                                            <th>شرح</th>
                                                            <th>وضعیت</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if (!empty($document_templates)) { ?>
                                                            <?php foreach ($document_templates as $template) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo htmlspecialchars(
                                                                            $template['name'],
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        switch ($template['operation_type']) {
                                                                            case 'cost':
                                                                                echo 'هزینه';
                                                                                break;
                                                                            case 'income':
                                                                                echo 'درآمد';
                                                                                break;
                                                                            case 'transfer':
                                                                                echo 'انتقال وجه';
                                                                                break;
                                                                            default:
                                                                                echo $template['operation_type'];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo (int)$template['hesab_bed']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo (int)$template['hesab_bes']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo htmlspecialchars(
                                                                            $template['sharh'] ?? '',
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ((int)$template['active'] === 1) { ?>
                                                                            <span class="label bg-teal">
                                            فعال
                                        </span>
                                                                        <?php } else { ?>
                                                                            <span class="label bg-grey">
                                            غیرفعال
                                        </span>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr>
                                                                <td colspan="6" class="text-center">
                                                                    الگویی ثبت نشده است.
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="system_settings">
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label">انتخاب رنگ
                                                    سیستم</label>
                                                <div class="col-sm-10">
                                                    <div class="form-group" name="color_system" id="select_cld">
                                                        <select class="form-control5 show-tick5 pull-right"
                                                                data-show-subtext="true" id="col_tsk" name="col_tsk">
                                                            <option value="" selected>--رنگ--</option>
                                                            <?php foreach ($colors as $color){ ?>
                                                            <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_tsk'] == $color) {echo 'selected';} ?>></option>
                                                           <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="setion_hd">
                                                جهت عملکرد صحیح سیستم حساب پیشفرض را در قسمت زیر انتخاب نمایید
                                            </div>
                                            <div class="form-group">
                                                <label for="sandugh_id" class="col-sm-2 control-label">حساب
                                                    صندوق</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line input-group">
                                                        <select class="form-control show-tick" id="sandugh_id"
                                                                name="sandugh_id" data-live-search="true">
                                                            <option value="0" selected>--حساب صندوق را انتخاب نمایید--
                                                            </option>
                                                            <?php
                                                            $parent_kol = list_kol();
                                                            foreach ($parent_kol as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($opt['sandugh_id'] == $key) {
                                                                    echo ' selected';
                                                                } ?>><?php echo $value; ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ashkhas_id" class="col-sm-2 control-label">حساب
                                                    اشخاص</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line input-group">
                                                        <select class="form-control show-tick" id="ashkhas_id"
                                                                name="ashkhas_id" data-live-search="true">
                                                            <option value="0" selected>--حساب اشخاص را انتخاب کنید--
                                                            </option>
                                                            <?php
                                                            foreach ($parent_kol as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($opt['ashkhas_id'] == $key) {
                                                                    echo ' selected';
                                                                } ?>><?php echo $value; ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="income_id" class="col-sm-2 control-label">حساب درآمد</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line input-group">
                                                        <select class="form-control show-tick" id="income_id"
                                                                name="income_id" data-live-search="true">
                                                            <option value="0" selected>--حساب درآمد را انتخاب نمایید--
                                                            </option>
                                                            <?php
                                                            foreach ($parent_kol as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($opt['income_id'] == $key) {
                                                                    echo ' selected';
                                                                } ?>><?php echo $value; ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="vam_id" class="col-sm-2 control-label"> حساب وام</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line input-group">
                                                        <select class="form-control show-tick" id="vam_id" name="vam_id"
                                                                data-live-search="true">
                                                            <option value="0" selected>--حساب اصلی وام را انتخاب
                                                                نمایید--
                                                            </option>
                                                            <?php
                                                            foreach ($parent_kol as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($opt['vam_id'] == $key) {
                                                                    echo ' selected';
                                                                } ?>><?php echo $value; ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cost_id" class="col-sm-2 control-label">حساب هزینه</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line input-group">
                                                        <select class="form-control show-tick" id="cost_id"
                                                                name="cost_id" data-live-search="true">
                                                            <option value="0" selected>--حساب هزینه را انتخاب نمایید--
                                                            </option>
                                                            <?php
                                                            foreach ($parent_kol as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($opt['cost_id'] == $key) {
                                                                    echo ' selected';
                                                                } ?>><?php echo $value; ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس اول</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx1"
                                                                name="bx1" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                <?php list_all_hesab($opt['bx1']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx1" name="col_bx1">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx1'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس دوم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx2"
                                                                name="bx2" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx2']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx2" name="col_bx2">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx2'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس سوم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx3"
                                                                name="bx3" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx3']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx3" name="col_bx3">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx3'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس چهارم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx4"
                                                                name="bx4" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx4']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx4" name="col_bx4">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx4'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس پنجم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx5"
                                                                name="bx5" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx5']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx5" name="col_bx5">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx5'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس ششم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx6"
                                                                name="bx6" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx6']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx6" name="col_bx6">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx6'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس هفتم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx7"
                                                                name="bx7" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx7']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx7" name="col_bx7">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx7'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="card-inside-title" style="margin-bottom: 25px;">باکس هشتم</h2>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <b>انتخاب عنوان حساب</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <select class="form-control show-tick" id="bx8"
                                                                name="bx8" data-live-search="true">
                                                            <option value="0" selected>--حساب  را انتخاب نمایید--
                                                            </option>
                                                            <?php list_all_hesab($opt['bx8']); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>انتخاب رنگ</b>
                                                    <div class="form-line input-group" style="margin-top: 20px;">
                                                        <div class="form-group">
                                                            <select class="form-control5 show-tick5 pull-right"
                                                                    data-show-subtext="true" id="col_bx8" name="col_bx8">
                                                                <option value="">--رنگ--</option>
                                                                <?php foreach ($colors as $color){ ?>
                                                                    <option data-subtext="<div class='bg-<?php echo $color; ?> col_bxf' /></div>" value="<?php echo $color; ?>" <?php if ($opt['col_bx8'] == $color) {echo 'selected';} ?>></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="save_sys"
                                                            class="btn btn-danger pull-left clear clearfix">ذخیره
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in " id="profile_settings">
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label">نام کاربری</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="username"
                                                               name="username" placeholder="نام کاربری را وارد نمایید"
                                                               value="<?php echo $row['username']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">ایمیل</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" id="email" name="email"
                                                               placeholder="ایمیل را وارد نمایید"
                                                               value="<?php echo $row['email']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label">عنوان نمایشی</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="title" name="title"
                                                               placeholder="نام جهت نمایش در سیستم"
                                                               value="<?php echo $row['title']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile" class="col-sm-2 control-label">شماره موبایل</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="mobile"
                                                               name="mobile"
                                                               placeholder="شماره موبایل خود را وارد نمایید"
                                                               value="<?php echo $row['mobile']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="prof_set" value="">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="profile_settings"
                                                            class="btn btn-danger pull-left clear clearfix">ذخیره
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="form-group">
                                            <div class="col-sm-3 text-left">
                                                <label for="OldPassword" class="control-label">رمز فعلی</label>&nbsp;&nbsp;
                                                <span toggle="#oldpassword" class="fa fa-fw fa-eye field-icon toggle-password" style="font-size: 15px;"></span>&nbsp;
                                            </div>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="oldpassword"
                                                               name="oldpassword" placeholder="رمز فعلی را وارد نمایید"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-3 text-left">
                                                    <label for="newpassword" class="control-label">رمز جدید</label>&nbsp;&nbsp;
                                                    <span toggle="#newpassword" class="fa fa-fw fa-eye field-icon toggle-password" style="font-size: 15px;"></span>&nbsp;
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="newpassword"
                                                               name="newpassword" placeholder="رمز جدید را وارد نمایید"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-3 text-left">
                                                <label for="newpasswordconfirm" class="control-label">تکرار
                                                    رمز</label>&nbsp;&nbsp;
                                                <span toggle="#newpasswordconfirm" class="fa fa-fw fa-eye field-icon toggle-password" style="font-size: 15px;"></span>&nbsp;
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control"
                                                               id="newpasswordconfirm" name="newpasswordconfirm"
                                                               placeholder="رمز جدید را مجدد وارد نمایید" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" name="sub_pass" class="btn btn-danger">
                                                        ویرایش
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require(get_path('footer.php')); ?>