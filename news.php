<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once 'admin/connect.php';

$query = "SELECT * FROM `rss` WHERE `status` = 'active'";
$itemsLink = $database->listRecord($query);

if (!$itemsLink) {
    echo "<p>No active RSS feeds found.</p>";
    exit;
}

foreach ($itemsLink as $rssItem) {
// duyệt từng link
    $rss_url = $rssItem['link'];
    echo '<pre style="color:red">';
    print_r($rssItem);
    echo '</pre>';
    // Lấy danh sách từ khóa bị cấm từ cột bankeyword, tách thành một mảng
        $excludedKeywords = array_map('trim', explode(',', $rssItem['bannedKeyWord']));
    // Neu ko phai vnexpress continue
    $rss_content = simplexml_load_file($rss_url);
    if ($rss_content === false) {
        echo "<p>Error loading RSS feed from URL: {$rss_url}</p>";
        continue;
    }

    $posts = '';
    $max_posts = 12; 

    $count = 0; 
    foreach ($rss_content->channel->item as $item) {
        $title = $item->title;
        $description = $item->description;

        // Kiểm tra từ khóa trong tiêu đề và mô tả
        $containsExcludedKeyword = false;
        foreach ($excludedKeywords as $keyword) {
            if (stripos($title, $keyword) !== false || stripos($description, $keyword) !== false) {
                $containsExcludedKeyword = true;
                break;
            }
        }
        // Nếu có chứa từ khóa không mong muốn, bỏ qua mẫu tin
        if (!$containsExcludedKeyword) {
            continue;
        }

        // Nếu mẫu tin hợp lệ, xử lý tiếp

        if ($count >= $max_posts) {
            break;
        }

        $link = $item->link;
        $description = $item->description;
        $pubDate = date('d/m/Y H:i', strtotime($item->pubDate)); 
        $image_url = ''; 

        if (preg_match('/<img src="(.*?)"/', $description, $matches)) {
            $image_url = $matches[1];
        } else {
            
            $image_url = 'images/default.jpg';
        }

       
        $posts .= "<div class=\"col-md-6 col-lg-4 p-3\">
                        <div class=\"entry mb-1 clearfix\">
                            <div class=\"entry-image mb-3\">
                                <a href=\"{$link}\" data-lightbox=\"image\" style=\"background: url({$image_url}) no-repeat center center; background-size: cover; height: 278px;\"></a>
                            </div>
                            <div class=\"entry-title\">
                                <h3><a href=\"{$link}\" target=\"_blank\">{$title}</a></h3>
                            </div>
                            <div class=\"entry-content\">
                                " . strip_tags($description) . "
                            </div>
                            <div class=\"entry-meta no-separator nohover\">
                                <ul class=\"justify-content-between mx-0\">
                                    <li><i class=\"icon-calendar2\"></i> {$pubDate}</li>
                                   
                                </ul>
                            </div>
                            <div class=\"entry-meta no-separator hover\">
                                <ul class=\"mx-0\">
                                    <li><a href=\"{$link}\" target=\"_blank\">Xem &rarr;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>";
        $count++; 
    }


}

?>
<section id="content" class="bg-light">
    <div class="content-wrap pt-lg-0 pt-xl-0 pb-0">
        <div class="container-fluid clearfix">
            <div class="heading-block border-bottom-0 center pt-4 mb-3"><h3>Tin tức</h3>
            </div>
            <!-- Posts -->
            <div class="row grid-container infinity-wrapper clearfix align-align-items-start">
                <?php echo $posts; ?>
            </div>
        </div>
    </div>
</section>