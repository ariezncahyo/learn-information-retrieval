<?php
    require_once __DIR__.'/vendor/autoload.php';

    use Phpml\FeatureExtraction\TokenCountVectorizer;
    use Phpml\Tokenization\WhitespaceTokenizer;
    use Phpml\FeatureExtraction\TfIdfTransformer;

    use Phpml\Math\Distance\Euclidean;
    use Phpml\Math\Distance\Minkowski;
    use Phpml\Math\Distance\Chebyshev;

    $sample_data = [
        'dolar naik harga naik hasil turun',
        'harga naik harus gaji naik',
        'premium tidak pengaruh dolar',
        'harga laptop naik',
        'naik harga'
    ];

    $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
    $tf->fit($sample_data);
    $tf->transform($sample_data);
    $vocabulary = $tf->getVocabulary();
    $i = 1;

    // Menghitung Term Frequency (TF)
    echo "<b>TERM FREQUENCY</b><br><br>";
    echo "<table border='1'>";
    echo "<tr><th align='center'></th>";
    foreach($vocabulary as $term){
        echo "<th align='center'>".$term."</th>";
    }
    echo "</tr>";

    foreach($sample_data as $isi){
        if($i == count($sample_data)){
            echo "<tr><td>Q</td>";
        }
        else{
            echo "<tr><td>D".$i."</td>";
        }

        foreach($isi as $item){
            echo "<td>".$item."</td>";
        }

        echo "</tr>";
        $i++;
    }

    echo "</table><br><br>";

    // Menghitung TF-IDF

    $tfidf = new TfIdfTransformer($sample_data);
    $tfidf->transform($sample_data);
    $i = 1;

    echo "<b>TF-IDF</b><br><br>";
    echo "<table border='1'>";
    echo "<tr><th align='center'></th>";
    foreach($vocabulary as $term){
        echo "<th align='center'>".$term."</th>";
    }
    echo "</tr>";

    foreach($sample_data as $isi){
        if($i == count($sample_data)){
            echo "<tr><td>Q</td>";
        }
        else{
            echo "<tr><td>D".$i."</td>";
        }

        foreach($isi as $item){
            echo "<td>".round($item, 1)."</td>";
        }

        echo "</tr>";
        $i++;
    }

    echo "</table><br><br>";

    // Menghitung Euclidean Distance

    $minkowski = new Minkowski(2.0);

    $i = 1;

    echo "<b>SIMILARITY BASED ON DISTANCE</b><br><br>";

    echo "<b>Euclidean</b><br><br>";
    foreach($sample_data as $isi){

        //Euclidean Distance
        if($i != count($sample_data)){
            $euclideanDistance = $minkowski->distance($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($euclideanDistance, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    // Menghitung Manhattan
    
    $minkowski = new Minkowski(1.0);

    $i = 1;

    echo "<b>Manhattan</b><br><br>";
    foreach($sample_data as $isi){

        //Manhattan Distance
        if($i != count($sample_data)){
            $manhattanDistance = $minkowski->distance($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($manhattanDistance, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    // Menghitung Chebyshev
    
    $chebyshev = new Chebyshev();

    $i = 1;

    echo "<b>Chebyshev</b><br><br>";
    foreach($sample_data as $isi){

        //Chebyshev Distance
        if($i != count($sample_data)){
            $chebyshevDistance = $chebyshev->distance($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($chebyshevDistance, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    // Menghitung Minkowski
    
    $minkowski = new Minkowski(2.0);

    $i = 1;

    echo "<b>Minkowski</b><br><br>";
    foreach($sample_data as $isi){

        //Manhattan Distance
        if($i != count($sample_data)){
            $minkowskiDistance = $minkowski->distance($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($minkowskiDistance, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";
?>