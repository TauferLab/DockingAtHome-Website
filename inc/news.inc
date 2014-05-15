<?php

if(!defined("PROJECT_HTML_FOLDER")) require_once("../project/project.inc");

function display_news_item_html($news_item,$full_text) {
  echo "<a name=\"".$news_item["id"]."\"></a>\n";
  echo "<h5>".$news_item["title"]."</h5>\n";
  echo "<h6><i>".$news_item["date"]."</i></h6>\n";
  if (!$full_text) {
    if (strlen($news_item["text"])>400) {
      $news_item["text"] = substr( $news_item["text"], 0, 400 )." ... ";
      $news_item["text"] .= "<a href=\"/about/project/news.php#".$news_item["id"]."\">(more)</a>";
    }
  }
  echo "<p>".$news_item["text"]."</p>\n";
}

function display_news_item_rss($news_item) {
  $d = strtotime($news_item["date"]);
  $news_item["date"] = gmdate('D, d M Y H:i:s',$d).' GMT';
  if (empty($news_item["title"])) {
      $news_item["title"] = "Project News ".$news_item["date"];
  } else {
      $news_item["title"] = strip_tags($news_item["title"]);
  }
  echo "<item>\n";
  echo "\t<title>".$news_item["title"]."</title>\n";
  echo "\t<link>".$news_item["link"]."</link>\n";
  echo "\t<guid isPermaLink=\"true\">".$news_item["link"]."</guid>\n";
  echo "\t<description><![CDATA[".strip_tags($news_item["text"])."]]></description>\n";
  echo "\t<pubDate>".$news_item["date"]."</pubDate>\n";
  echo "</item>\n";
}

function display_all_news($news_items) {
  display_news_html($news_items,-1,true);
}

function display_homepage_news($news_items) {
  display_news_html($news_items,3,false);
}

function display_news_rss($news_items,$number_to_display=9) {
  foreach (get_news($news_items,$number_to_display) as $current_news_item) {
    display_news_item_rss($current_news_item);
  }
}

function display_news_html($news_items,$number_to_display=50,$full_text=true) {
  foreach (get_news($news_items,$number_to_display) as $current_news_item) {
    display_news_item_html($current_news_item,$full_text);
  }
}

function get_news($news_items,$number_to_get) {
  if ($number_to_get < -1) {
    return null;
  }
  $total_items = count($news_items);
  if ($number_to_get > $total_items || $number_to_get == -1) {
    $number_to_get = $total_items;
  }
  for ($i=0; $i<$number_to_get; $i++) {
    $current_item = $total_items - $i;
    $current_news_item = $news_items[$i];
    $current_news_item["id"] = $current_item;
    $current_news_item["link"] = URL_BASE."about/project/news.php#".$current_item;
    $selected_news[$i] = $current_news_item;
  }
  return $selected_news;
}

function news_item($date, $text, $title="") {
    echo "<span class=\"news_date\">$date</span> <span class=\"news_title\">$title</span>
        <br><span class=\"news_content\">$text</span><br><br>
    ";
}

function show_news($items, $n) {
    if ($n > count($items)) {
        $n = count($items);
    }
    for ($i=0; $i<$n; $i++) {
        $date = null;
        if (isset($items[$i][2])) $date = $items[$i][2];
        news_item($items[$i][0], $items[$i][1], $date);
    }
}

function show_old_news($items, $n) {
    $tot = count($items);
    for ($i=$n; $i<count($items); $i++) {
        $j = $tot-$i;
        echo "<a name=$j></a>\n";
        news_item($items[$i][0], $items[$i][1]);
    }
}

?>
