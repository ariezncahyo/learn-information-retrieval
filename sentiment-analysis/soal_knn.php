<html>
    <h1>INPUT BERITA BARU</h1>
    <form method="POST">
        <p><input type="text" name="berita" id="berita" style="width:400px;height:200px;"></p>
        <input type="submit" name="submit">
    </form>
</html>

<?php
    require_once __DIR__ . '/vendor/autoload.php';

    use Phpml\FeatureExtraction\TokenCountVectorizer;
    use Phpml\FeatureExtraction\TfIdfTransformer;
    use Phpml\Tokenization\WhitespaceTokenizer;
    use Phpml\Classification\KNearestneighbors;
    use Phpml\Math\Distance\Minkowski;

    if(isset($_POST["submit"])){
        $query = $_POST["berita"];

        $conn = new mysqli("localhost", "root", "", "berita");
        if($conn->connect_error){
            die("Connection failed: ".$conn->connect_error);
        }

        $data_bersihs = array();
        $kategoris = array();

        $sql = "SELECT data_bersih, kategori FROM news";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $dataBersihs[] = $row["data_bersih"];
                $kategoris[] = $row["kategori"];
            }

            echo "<br><br><b><u>Data Training KNN</u></b><br><br>";
            echo "<table border='1'>";
            echo "<tr><th align='center'></th>";
            
            $sample_data = $dataBersihs;
            $sample_data[] = $query;

            $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
            $tf->fit($sample_data);
            $tf->transform($sample_data);
            $vocabulary = $tf->getVocabulary();
    
            $tfidf = new TfIdfTransformer($sample_data);
            $tfidf->transform($sample_data);

            $samples = $sample_data;
            $query = $samples[(count($samples) - 1)];
            //array_splice($samples, (count($samples) - 1), 1);
            $labels = $kategoris;

            for($i = 0; $i < count($samples[0]); $i++){
                echo "<th align='center'>".$vocabulary[$i]."</th>";
                //echo "<th align='center'>Term ".($i+1)."</th>";
            }
            echo "<th align='center'>Kategori</th></tr>";
            
            $i = 1;
            foreach($samples as $doc => $term){
                echo "<tr><th align='center'>Berita-".($i-1)."</th>";
                foreach ($term as $value){
                    echo "<td>".$value."</td>";
                }
                if($i == count($samples)){
                    echo "<td></td>";
                }
                else{
                    echo "<td>".$labels[$i-1]."</td>";
                }
                echo "</tr>";
                $i++;
            }
            echo "</table><br>";

            array_splice($samples, (count($samples) - 1), 1);
            
            $data_baru = $query;
            $classifier = new KNearestneighbors($k = 11, new Minkowski($lambda = 1));
            $classifier->train($samples, $labels);

            $hasil = $classifier->predict($query);
            echo "<h2><b>Hasil Prediksi Kategori Berita Baru adalah ".$hasil."</b></h2>";
        } 

        $conn->close();
    }
?>