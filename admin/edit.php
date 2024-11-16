<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once 'connect.php';
require_once 'libs/Validate.class.php';
require_once 'libs/Form.class.php';

$error = '';
$id = $_GET['id'];
$id = mysqli_real_escape_string($database->getConnect(), $id);

// Sửa câu truy vấn SQL - sử dụng dấu nháy kép thay vì dấu nháy đơn
$query = "SELECT * FROM `rss` WHERE `id` = '$id'";

// Thay thế cách gọi phương thức để lấy dữ liệu
$singleRecord = $database->singleRecord($query);

if (empty($singleRecord)) {
    header('Location: list.php');
    exit();
}

$outValidate = $singleRecord;

if (!empty($_POST)) {
    $source = [
        'link' => $_POST['link'],
        'status' => $_POST['status'],
        'ordering' => $_POST['ordering']
    ];

    $validate = new Validate($source);
    $validate->addRule('link', 'url')
             ->addRule('ordering', 'int', ['min' => 1, 'max' => 100])
             ->addRule('status', 'status');

    $validate->run();

    $outValidate = $validate->getResult();
    if (!$validate->isValid()) {
        $error = $validate->showErrorMessage();
    } else {
        $database->update($outValidate, [['id', $id]]);
        header('Location: list.php');
        exit();
    }
}

$lblLink = Form::label('Link');
$lblStatus = Form::label('Status');
$lblOrdering = Form::label('Ordering');

$inputLink = Form::input('text', 'link', @$outValidate['link']);
$inputOrdering = Form::input('number', 'ordering', @$outValidate['ordering']);
$statusValues = [
    'default' => 'Select status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

$slbStatus = Form::selectBox($statusValues, 'status', $outValidate['status'] ?? 'default');
$rowLink = Form::formRow($lblLink, $inputLink);
$rowStatus = Form::formRow($lblStatus, $slbStatus);
$rowOrdering = Form::formRow($lblOrdering, $inputOrdering);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once 'html/head.php'?>
</head>
<body style="background-color: #eee;">
    <div class="container pt-5">
        <form action="" method="post">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">EDIT RSS</h4>
                </div>
                <div class="card-body">
                    <?= $error ?>
                    <?= $rowLink . $rowStatus . $rowOrdering ?>
                </div>
                <div class="card-footer">
                    <input class="form-control" type="hidden" name="token" value="1611025715"> 
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="list.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <?php require_once "html/script.php"?>
</body>
</html>
