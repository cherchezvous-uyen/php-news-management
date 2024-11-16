<?php
$link = 'http://giavang.doji.vn/api/giavang/?api_key=258fbd2a72ce8481089d88c678e9fe4f';
$xml = simplexml_load_file($link);

// Chuyển đổi XML thành mảng
$xmlJSON = json_encode($xml);
$xmlArr = json_decode($xmlJSON, true);

// Lấy danh sách vàng từ mảng
$goldList = array_column($xmlArr['DGPlist']['Row'], '@attributes');

// Tạo xhtml cho bảng
$xhtml = '';
foreach ($goldList as $goldItem) {
    $xhtml .= '
    <tr>
        <td>' . htmlspecialchars($goldItem['Name']) . '</td>
        <td>' . htmlspecialchars($goldItem['Buy']) . '</td>
        <td>' . htmlspecialchars($goldItem['Sell']) . '</td>
    </tr>
    ';
}
?>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Tên vàng</th>
            <th><b>Mua vào</b></th>
            <th><b>Bán ra</b></th>
        </tr>
    </thead>
    <tbody>
        <?php echo $xhtml; ?>
    </tbody>
</table>
