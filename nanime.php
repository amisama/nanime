<?php
function mycurl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;

}//children
$url = "https://nanime.tv/";
$data = mycurl($url);
require 'simple_html_dom.php';

$html = new simple_html_dom();
//load HTML from a string
$html->load($data);
//echo $data;die;
//echo $data;die;
$gambar = $html->find('div[class=col-md-3 content-item]');

foreach ($gambar as $key => $value) {
	$episode = $value->find('div[class=episode]',0)->innertext;
	$status = $value->find('div[class=status]',0)->innertext;
	$gambar = $value->find('img',0)->src;
	$title = $value->find('img',0)->title;
	$results['status'] = 'success';
	$results['creator'] = 'Ami';
	$results['data'][] = array(
		'image' => $gambar,
		'title' => $title,
		'status' => $status,
		'episode' => $episode
	);
}
//var_dump ($gambar);
header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>