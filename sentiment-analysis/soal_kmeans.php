<?php
    require_once __DIR__ . '/vendor/autoload.php';

    use Phpml\FeatureExtraction\TokenCountVectorizer;
    use Phpml\FeatureExtraction\TfIdfTransformer;
    use Phpml\Tokenization\WhitespaceTokenizer;
    use Phpml\Clustering\KMeans;

	$conn = new mysqli("localhost", "root", "", "berita");
    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }

    $sql = "SELECT data_bersih FROM news";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $dataBersihs = array();
        while($row = $result->fetch_assoc()) {
            $dataBersihs[] = $row["data_bersih"];
        }
        $sample_data = $dataBersihs;

        $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
        $tf->fit($sample_data);
        $tf->transform($sample_data);
        $vocabulary = $tf->getVocabulary();

        $tfidf = new TfIdfTransformer($sample_data);
        $tfidf->transform($sample_data);

        $kmeans = new KMeans(5);
        $hasil = $kmeans->cluster($sample_data);

        echo "<b><u>Hasil Clustering</u></b><br><br>";
        
        echo "<b><u>Bentuk Tabel</u></b><br><br>";
        echo "<table border='1'>";
        foreach($hasil as $cluster => $doc){
            $term = array_search(max($sample_data[$cluster]), $sample_data[$cluster]);
            echo "<tr><th align='center'>Cluster ".$vocabulary[$term]."</th>";
            foreach($doc as $key => $value){
                echo "<td>Berita-".$key."</td>";
            }
            echo "</tr>";
        }
    } 
    
    $conn->close();
?>
