<?php
include_once('../_common.php');
if($member['mb_level2'] != 3 && $member['mb_1'] != 'admin') {
    alert('권한 없음');
}

$w          = $_REQUEST['w'];
$seq        = $_REQUEST['seq'];
$aw_subject = trim($_POST['aw_subject']);
$aw_url     = trim($_POST['aw_url']);
$aw_category= trim($_POST['aw_category']); // 상장/명장/인증

// 삭제
if($w=='d') {
    $row = sql_fetch("SELECT aw_img FROM awards_table WHERE seq='$seq'");
    if($row['aw_img']) {
        $full_path = $_SERVER['DOCUMENT_ROOT'].$row['aw_img'];
        if(file_exists($full_path)) @unlink($full_path);
    }
    sql_query("DELETE FROM awards_table WHERE seq='$seq'");
    alert('삭제되었습니다.','./awards.html');
    exit;
}

// 업로드
$aw_img = '';
if(isset($_FILES['aw_file']) && $_FILES['aw_file']['name']) {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/_data/awards/';
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $filename = basename($_FILES['aw_file']['name']);
    $target_file = $upload_dir.$filename;

    if(move_uploaded_file($_FILES['aw_file']['tmp_name'], $target_file)) {
        $aw_img = '/_data/awards/'.$filename;
    } else {
        alert('이미지 업로드에 실패했습니다.');
    }
}

// INSERT
if($w=='') {
    $sql = "
      INSERT INTO awards_table
         SET aw_subject='{$aw_subject}',
             aw_img='{$aw_img}',
             aw_url='{$aw_url}',
             aw_category='{$aw_category}',
             aw_datetime=NOW()
    ";
    sql_query($sql);
    alert('등록되었습니다.','./awards.html');
    exit;
}

// UPDATE
if($w=='u') {
    $row = sql_fetch("SELECT * FROM awards_table WHERE seq='$seq'");
    if(!$row) alert('수정할 데이터가 없습니다.');

    $sql_img = '';
    if($aw_img) {
        // 기존 이미지 삭제
        if($row['aw_img']) {
            $old_path = $_SERVER['DOCUMENT_ROOT'].$row['aw_img'];
            if(file_exists($old_path)) @unlink($old_path);
        }
        $sql_img = " aw_img='{$aw_img}', ";
    }

    $sql = "
      UPDATE awards_table
         SET aw_subject='{$aw_subject}',
             aw_url='{$aw_url}',
             aw_category='{$aw_category}',
             {$sql_img}
             aw_datetime=NOW()
       WHERE seq='{$seq}'
    ";
    sql_query($sql);
    alert('수정되었습니다.','./awards.html');
    exit;
}

alert('잘못된 접근','./awards.html');
