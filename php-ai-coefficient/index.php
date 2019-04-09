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

    echo "<b>SIMILARITY BASED ON DISTANCE</b><br><br>";

    function diceCoefficient(array $a, array $b, float $alpha=0.5): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $wkq_wkj = 0;
        $wkq_kuadrat = 0;
        $wkj_kuadrat = 0;

        foreach ($a as $i => $val) {
            $wkq_wkj += ($val * $b[$i]);
            $wkq_kuadrat += ($val ** 2);
            $wkj_kuadrat += ($b[$i] ** 2);
        }

        $coefficient = $wkq_wkj / ($alpha * $wkq_kuadrat + (1 - $alpha) * $wkj_kuadrat);

        return sqrt((float) $coefficient);
    }

    // Menghitung Dice Coefficient

    $i = 1;

    echo "<b>Dice</b><br><br>";

    foreach($sample_data as $isi){
        //Euclidean Distance
        if($i != count($sample_data)){
            $diceCoefficient = diceCoefficient($sample_data[count($sample_data)-1], $isi, 0.7);
            echo "D".$i." dan Q = ".round($diceCoefficient, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    function jaccardCoefficient(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $wkq_wkj = 0;
        $wkq_kuadrat = 0;
        $wkj_kuadrat = 0;

        foreach ($a as $i => $val) {
            $wkq_wkj += ($val * $b[$i]);
            $wkq_kuadrat += ($val ** 2);
            $wkj_kuadrat += ($b[$i] ** 2);
        }

        $coefficient = $wkq_wkj / ($wkq_kuadrat + $wkj_kuadrat - $wkq_wkj);

        return sqrt((float) $coefficient);
    }

    // Menghitung Jaccard

    $i = 1;

    echo "<b>Jaccard</b><br><br>";
    foreach($sample_data as $isi){

        //Jaccard Distance
        if($i != count($sample_data)){
            $jaccardCoeffficient = jaccardCoefficient($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($jaccardCoeffficient, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    function overlapCoefficient(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $wkq_wkj = 0;
        $wkq_kuadrat = 0;
        $wkj_kuadrat = 0;

        foreach ($a as $i => $val) {
            $wkq_wkj += ($val * $b[$i]);
            $wkq_kuadrat += ($val ** 2);
            $wkj_kuadrat += ($b[$i] ** 2);
        }

        $coefficient = $wkq_wkj / $wkj_kuadrat;
        if($wkq_kuadrat < $wkj_kuadrat){
            $coefficient = $wkq_wkj / $wkq_kuadrat;
        }

        return sqrt((float) $coefficient);
    }

    // Menghitung Overlap

    $i = 1;

    echo "<b>Overlap</b><br><br>";
    foreach($sample_data as $isi){

        //Overlap Coefficient
        if($i != count($sample_data)){
            $overlapCoefficient = overlapCoefficient($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($overlapCoefficient, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    function cosineCoefficient(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $wkq_wkj = 0;
        $wkq_kuadrat = 0;
        $wkj_kuadrat = 0;

        foreach ($a as $i => $val) {
            $wkq_wkj += ($val * $b[$i]);
            $wkq_kuadrat += ($val ** 2);
            $wkj_kuadrat += ($b[$i] ** 2);
        }

        $coefficient = $wkq_wkj / (($wkq_kuadrat * $wkj_kuadrat) ** 0.5);

        return sqrt((float) $coefficient);
    }

    // Menghitung Cosine

    $i = 1;

    echo "<b>Cosine</b><br><br>";
    foreach($sample_data as $isi){

        //Cosine Coefficient
        if($i != count($sample_data)){
            $cosineCoefficient = cosineCoefficient($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($cosineCoefficient, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";

    function asymmetricCoefficient(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $min_wkq_wkj = 0;
        $wkq = 0;

        foreach ($a as $i => $val) {
            $min = $val;
            if($b[$i] < $val){
                $min = $b[$i];
            }
            $min_wkq_wkj += $min;
            $wkq += $val;
        }

        $coefficient = $min_wkq_wkj / $wkq;

        return sqrt((float) $coefficient);
    }

    // Menghitung Asymmetric

    $i = 1;

    echo "<b>Asymmetric</b><br><br>";
    foreach($sample_data as $isi){

        //Asymmetric Coefficient
        if($i != count($sample_data)){
            $asymmetricCoefficient = asymmetricCoefficient($sample_data[count($sample_data)-1], $isi);
            echo "D".$i." dan Q = ".round($asymmetricCoefficient, 2)."<br>";
        }

        $i++;
    }

    echo "<br><br>";
?>