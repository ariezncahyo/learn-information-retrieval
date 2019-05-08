<html>
    <h2>Input Berita Baru</h2>
    <form method="GET">
        <label>Berita: <textarea name="query" id="query" cols="30" rows="10"></textarea></label>
        <input type="submit" name="submit" id="submit" value="Check">
    </form>
</html>

<?php
    if(isset($_GET['query'])){
        $query = explode(" ", $_GET['query']);
        $kategori = array();

        echo "<p>Query: ".$_GET['query']."</p>";

        /*
        foreach($query as $val){
            echo $val."<br>";
        }
        */

        $conn = new mysqli("localhost", "root", "", "berita");
        if($conn->connect_error){
            die("Connection failed: ".$conn->connect_error);
        }

        // Mengambil Kategori Unique dari Database
        $sql = "SELECT DISTINCT kategori FROM `news`";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $kategori[] = $row["kategori"];
            }
        } 

        /*
        foreach($kategori as $val){
            echo $val."<br>";
        }
        */

        // Meng-token query input user
        $tokenized = array();
        for ($i = 0; $i < sizeof($query); $i++) {

            if (!array_key_exists($i + 1, $query)) {
                $bigram = "";
            } else {
                $bigram = $query[$i] . " " . $query[$i + 1];
            }
    
            if (!array_key_exists($i + 2, $query)) {
                $trigram = "";
            } else {
                $trigram = $query[$i] . " " . $query[$i + 1] . " " . $query[$i + 2];
            }
    
            //unigram
            if($query[$i] != ""){
                $tokenized[] = $query[$i];
            }
            //bigram
            /*
            if($query[$i] != ""){
                $tokenized[] = $bigram;
            }
            */
            //trigram
            /*
            if($query[$i] != ""){
                $tokenized[] = $trigram;
            }
            */
        }

        /*
        foreach($tokenized as $val){
            if($val != ""){
                echo $val."<br>";
            }
        }
        */

        $naive = array();
        foreach($kategori as $kat_idx => $kat_val){
            //Query Jumlah Kategori
            $jumlah_kategori = 0;
            $sql = "SELECT COUNT(*) as hasil FROM `news` where kategori='$kat_val'";
            $result = $conn->query($sql);
            $prob_token = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $jumlah_kategori = $row["hasil"];
                }
            } 
            $probability_pembilang = 1;
            $probability_penyebut = 1;
            foreach($tokenized as $token_idx => $token_val){
                if($token_val != ""){
                    //Query Probability Berdasarkan Term dan Kategori
                    $sql = "SELECT COUNT(*) as hasil FROM `news` where data_bersih LIKE '%$token_val%' AND kategori='$kat_val'";
                    $result = $conn->query($sql);
                    $prob_token = 0;
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $prob_token = $row["hasil"];
                            $probability_pembilang *= $prob_token;
                            $probability_penyebut *= $jumlah_kategori;
                        }
                    } 
                    echo "P($token_val | $kat_val) = $prob_token/$jumlah_kategori <br>";
                }
            }
            echo "P(".$_GET['query']." | $kat_val) = $probability_pembilang / $probability_penyebut<br>";
            $naive[$kat_val] = $probability_pembilang / $probability_penyebut;
            echo "<br>";
        }

        $prediksi = max($naive);
        foreach($naive as $index => $value){
            if($value == $prediksi){
                echo "Hasil Prediksi dari berita baru adalah ".$index;
            }
        }

        $conn->close();
    }
?>