<?

$count = 1;
$json_pages = 0;
$html = "";

get_json();

function get_json(){

	global $json_pages,$count,$html;
	echo($count);
	$result = file_get_contents("http://api.dribbble.com/players/capek/shots/likes?page=".$count);
	$json =  json_decode($result);var_dump($json);
	
	$json_pages = $json->pages;
	
	$json_shots = $json->shots;
	
	if($count == 1)
	{
		$html .= '<html><head></head><body><ul class="dribbble_list">'."\n";
	}
	$html .= create_html_elements($json_shots);
	
	if($count < $json_pages)
	{
		$count++;
		get_json();
		
	}
	else if($count == $json_pages)
	{

		$html .= '</ul></body></html>';
		$file = fopen("result.html",w);
		fwrite($file,$html);
		fclose($file);

	}
		


}

function create_html_elements($json_shots){

	for ( $i = 0; $i < count($json_shots); $i++ ) {

	$name = $json_shots[$i] -> player -> name;
	$url = $json_shots[$i] -> short_url;
	$thumb_url = $json_shots[$i] -> image_teaser_url;

	$html .= '  <li>'."\n".'    <ul class="pickup">'."\n";
	$html .='      <li class="name">by ' . $name . '</li>'."\n";
	$html .='      <li class="thumb"><a href="' . $url . '">' . '<img src="' . $thumb_url . '" />' . '</a></li>'."\n";
	$html .='    </ul>'."\n".'  </li>'."\n";
	
	}
	
	return $html;
}
