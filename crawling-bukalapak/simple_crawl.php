<?php 
	include_once('simple_html_dom.php');
	include_once('proxy.php');

	$query = $_GET['textCari'];

	$url = 'https://www.bukalapak.com/products?utf8=%E2%9C%93&source=navbar&from=omnisearch&search_source=omnisearch_organic&search%5Bhashtag%5D=&search%5Bkeywords%5D=';
	$url = $url.str_replace(" ", "+", $query);

	//if you are using proxy, uncoment syntax below and change the value to your own proxy.
	//$proxy = 'proxy3.ubaya.ac.id:8080';

	//agent value is different on each browser, make sure here: https://www.whatsmyua.info/
	$agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36';	

	//if you are using proxy, make sure to add the proxy as third argument
	//if your proxy has password, add proxy password as fourth argument
	$result = extract_html($url, $agent);

	$i = 0;
	if($result['code']=='200'){
		$html = new simple_html_dom();
		$html->load($result['message']);
		echo "<table border='1'>";
		echo "<tr><th>Nama Barang</th><th>Harga Barang</th><th>Link Resmi</th></tr>";
		foreach($html->find('div[class="product-card"]') as $produk)
		{
			if($i > 10) break;
			else
			{
				echo "<tr>";

				$hargaBarang = $produk->find('div[class="product-price"]', 0)->attr['data-reduced-price'];
				$namaProduk = $produk->find('a[class="product__name line-clamp--2 js-tracker-product-link qa-list"]', 0)->title;
				$linkProduk = $produk->find('a[class="product__name line-clamp--2 js-tracker-product-link qa-list"]', 0)->href;

				echo '<td>'.$namaProduk.'</td>';
				echo "<td>".$hargaBarang."</td>";
				echo '<td><a href="https://www.bukalapak.com'.$linkProduk.'">See Detail</a></td>';
				echo "</tr>";
			}
			$i++;
		}
		echo "</table>";
	}
 ?>