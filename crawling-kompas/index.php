<?php 
	include_once('simple_html_dom.php');
	include_once('proxy.php');

	//if you are using proxy, uncoment syntax below and change the value to your own proxy.
	//$proxy = 'proxy3.ubaya.ac.id:8080';

	//agent value is different on each browser, make sure here: https://www.whatsmyua.info/
	$agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36';

	//change the url for your own crawling target.
	$url = 'https://www.kompas.com/';

	//if you are using proxy, make sure to add the proxy as third argument
	//if your proxy has password, add proxy password as fourth argument
	$result = extract_html($url, $agent);

	$i = 0;
	if($result['code']=='200'){
		$html = new simple_html_dom();
		$html->load($result['message']);

		// I'm using table to show the result, feel free to change the frontend.

		echo "<table border='1'>";
		echo "<tr><th>Tanggal Berita</th><th>Judul Berita</th></tr>";
		foreach($html->find('div[class="article__list clearfix"]') as $berita)
		{
			//feel free to change the value on if based on how many data you want to show.
			if($i > 20) break;
			else
			{
				echo "<tr>";
				$tanggalBerita = $berita->find('div[class="article__date"]', 0)->innertext;
				$judulBerita = $berita->find('a[class="article__link"]', 0)->innertext;
				$linkBerita = $berita->find('a[class="article__link"]', 0)->href;

				echo "<td>".$tanggalBerita."</td>";
				echo '<td><a href="'.$linkBerita.'">'.$judulBerita.'</a></td>';
				echo "</tr>";
			}
			$i++;
		}
		echo "</table>";
	}
 ?>