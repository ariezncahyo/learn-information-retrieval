<?php
include_once 'simple_html_dom.php';
include_once 'proxy.php';
include "libchart/classes/libchart.php";

require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Clustering\KMeans;
use Phpml\Classification\KNearestneighbors;

//change the url value into your crawling target
$url = 'https://www.kompas.com/';

//if you are using proxy, uncoment syntax below and change the value to your own proxy.
//$proxy = 'proxy3.ubaya.ac.id:8080';

//agent value is different on each browser, make sure here: https://www.whatsmyua.info/
$agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36';

//if you are using proxy, make sure to add the proxy as third argument
//if your proxy has password, add proxy password as fourth argument
$result = extract_html($url, $agent);

$i = 0;
if ($result['code'] == '200') {

    $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
    $stemmer = $stemmerFactory->createStemmer();

    $stopWordFactory = new \Sastrawi\StopWordRemover\StopWordremoverFactory();
    $stopWord = $stopWordFactory->createStopWordRemover();

    $html = new simple_html_dom();
    $html->load($result['message']);
    echo "<table border='1'>";
    echo "<tr><th>Tanggal Berita</th><th>Judul Berita</th><th>Hasil Preprocessing Judul</th><th>Hasil StopWord</th></tr>";

    $result = "";
    foreach ($html->find('div[class="article__list clearfix"]') as $berita) {
        if ($i > 0) {
            break;
        } else {
            echo "<tr>";
            $tanggalBerita = $berita->find('div[class="article__date"]', 0)->innertext;
            $judulBerita = $berita->find('a[class="article__link"]', 0)->innertext;
            $linkBerita = $berita->find('a[class="article__link"]', 0)->href;
            $preprocessing = $stemmer->stem($judulBerita);
            $stopWordProcessing = $stopWord->remove($preprocessing);
            $result = $stopWordProcessing;

            echo "<td>" . $tanggalBerita . "</td>";
            echo '<td><a href="' . $linkBerita . '">' . $judulBerita . '</a></td>';
            echo "<td>" . $preprocessing . "</td>";
            echo "<td>" . $stopWordProcessing . "</td>";
            echo "</tr>";
        }
        $i++;
    }
    echo "</table>";
    echo "<br><br>";
    echo "<table border='1'>";
    echo "<tr>
				<th>Unigram</th>
				<th>Bigram</th>
				<th>Trigram</th>
			</tr>";
    $katas = explode(" ", $result);
    for ($i = 0; $i < sizeof($katas); $i++) {

        if (!array_key_exists($i + 1, $katas)) {
            $bigram = "";
        } else {
            $bigram = $katas[$i] . " " . $katas[$i + 1];
        }

        if (!array_key_exists($i + 2, $katas)) {
            $trigram = "";
        } else {
            $trigram = $katas[$i] . " " . $katas[$i + 1] . " " . $katas[$i + 2];
        }

        //unigram
        echo "<tr>";
        echo "<td>" . $katas[$i] . "</td>";

        //bigram
        echo "<td>" . $bigram . "</td>";

        //trigram
        echo "<td>" . $trigram . "</td>";

        echo "</tr>";
    }
    echo "</table>";
}

$samples = [
    'Doc1' => [0.66, 4.02],
    'Doc2' => [0.31, 1.82],
    'Doc3' => [0.49, 2.59],
    'Doc4' => [0.50, 2.69],
    'Doc5' => [0.51, 2.81],
    'Doc6' => [0.65, 4.64],
    'Doc7' => [0.72, 3.87],
    'Doc8' => [1.62, 9.64],
    'Doc9' => [1.13, 7.06],
    'Doc10' => [0.61, 3.29],
    'Doc11' => [0.48, 2.90],
    'Doc12' => [5.59, 3.11]
];
$kmeans = new KMeans(3);
$hasil = $kmeans->cluster($samples);

echo "<b><u>Hasil Clustering</u></b><br><br>";
echo "<b><u>Bentuk Array</u></b><br>";
print_r($hasil);

echo "<br><br><b><u>Bentuk Tabel</u></b><br><br>";
echo "<table border='1'>";

$chart = new PieChart(500, 250);

$dataSet = new XYDataSet();

foreach($hasil as $cluster => $doc){
    echo "<tr><th align='center'>Cluster ".$cluster."</th>";

    $dataSet->addPoint(new Point("Cluster ".$cluster." (".count($doc).")", count($doc)));

    foreach($doc as $key => $value){
        echo "<td>".$key."</td>";
    }
    echo "</tr>";
}
echo "</table>";
$chart->setDataSet($dataSet);
$chart->setTitle("Hasil Clustering");
$chart->render("clustering.png");
echo "<img src='clustering.png'>";


/*
$dataSet->addPoint(new Point("Mozilla Firefox (80)", 80));
$dataSet->addPoint(new Point("Konqueror (75)", 75));
$dataSet->addPoint(new Point("Other (50)", 50));
$chart->setDataSet($dataSet);

$chart->setTitle("User agents for www.example.com");
$chart->render("demo3.png");
echo "<img src='demo3.png'>";
*/
?>