<?php
class Text_Functions {

  public static function check_link_youtube($str) {
    if(preg_match('/youtube.com/',$str))
      return preg_replace('/https:\/\/(.*?)(\w+).com\/watch\?v=/','',$str);
    else
      echo '<script>alert("Not a valid youtube link!!")</script>';
      return false;
  }

  public static function link_highlighter($text)
  {
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    // The Text you want to filter for urls
    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {
           // make the urls hyper links
           return preg_replace($reg_exUrl, "<a href='$url[0]'>$url[0]</a> ", $text);
    } else {
         // if no urls in the text just return the text
         return $text;
    }
  }

  public static function html_decodes($str)
  {
    $str = trim($str);
    $str = htmlspecialchars($str);
    $str = Text_Functions::link_highlighter($str);
    $str = preg_replace('#&lt;(/?[bi])&gt;#', '<$1>', $str);
    $str = preg_replace('#&lt;(/?[ii])&gt;#', '<$1>', $str);
    return $str;
  }
}
?>
