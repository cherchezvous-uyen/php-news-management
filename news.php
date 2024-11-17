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

    $rss_url = $rssItem['link'];

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
        // if(!isset($rssItem['source_name'])) continue;

        if ($count >= $max_posts) {
            break;
        }
        $title = $item->title;

        // Lấy ra danh sách từ cấm
        // Nếu $title nó nằm trong danh sách từ cấm continue

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
<!-- Posts (index.php) -->
<?php echo $posts; ?>
