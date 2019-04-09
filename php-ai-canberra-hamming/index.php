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

    // Menghitung Canberra Distance

    $i = 1;

    echo "<b>Canberra</b><br><br>";
    foreach($sample_data as $isi){

        //Canberra Distance
        if($i != count($sample_data)){

            $a = $sample_data[count($sample_data)-1];
            $b = $isi;

            $distance = 0;
            $count = count($a);

            for ($j = 0; $j < $count; ++$j) {
                $difference = abs($a[$j] - $b[$j]);
                $sum = abs($a[$j] + $b[$j]);

                if($sum == 0){
                    $distance += 0;
                }
                else{
                    $distance += ($difference/$sum);
                }
            }

            $canberraDistance = $distance;
            echo "D".$i." dan Q = ".round($canberraDistance, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    // Menghitung Hamming Distance

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

    echo "<b>Hamming Distance</b><br><br>";
    echo "<table border='1'>";
    echo "<tr><th align='center'></th>";
    foreach($vocabulary as $term){
        echo "<th align='center'>".$term."</th>";
    }
    echo "</tr>";

    $hamming = array();
    $i = 1;

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
    
    $documentIdx = 1;
    $q = $sample_data[count($sample_data)-1];
    foreach($sample_data as $eachIndex){
        echo "<tr>";
        $idx = 0;
        if($documentIdx == count($sample_data)){
            echo "<td>Hamming Q</td>";
        }
        else{
            echo "<td>Hamming D".$documentIdx."</td>";
        }
        $sum = 0;
        foreach($eachIndex as $valueEachTerm){
            $tfBinary = 0;
            if($valueEachTerm > 0){
                $tfBinary = 1;
            }

            $differences = 0;
            if($q[$idx] != $tfBinary){
                $differences = 1;
            }

            echo "<td>".$differences."</td>";

            $sum += $differences;
            $idx++;
        }
        $hamming[] = $sum;
        echo "</tr>";
        $documentIdx++;
    }

    echo "</table><br><br>";

    echo "<b>Hamming Distance</b><br><br>";

    $i = 1;

    foreach($sample_data as $isi){
        
        if($i != count($sample_data)){
            echo "D".$i." dan Q = ".$hamming[$i-1]."<br>";
        }

        $i++;
    }
?>