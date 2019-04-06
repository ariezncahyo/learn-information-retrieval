<?php
    include_once('read.php');

    $query = array(57,1,0,110,201,0,1,126,1,1.5,1,0,1,1);

    $dataset = readCSV(60);
    $data_training = setDataTraining($dataset);
    
    $classification = array();

    $jumlah_c0 = 0;
    $jumlah_c1 = 0;

    for($i = 0; $i < sizeof($data_training); $i++){
        for($j = 0; $j < sizeof($data_training[$i]) - 1; $j++){
            $jumlah_attributes = sizeof($data_training[$i]) - 1;
            if($data_training[$i][$jumlah_attributes]==1){
                $classification[1][$j][] = $data_training[$i][$j];
                $jumlah_c1++;
            }
            else{
                $classification[0][$j][] = $data_training[$i][$j];
                $jumlah_c0++;
            }
        }
    }

    $posterior_probability = array();

    $posterior_probability[] = ($jumlah_c0/($jumlah_c0+$jumlah_c1));
    $posterior_probability[] = ($jumlah_c1/($jumlah_c0+$jumlah_c1));

    // 0 => mean
    // 1 => std
    // Hitung rata-rata
    $naive = array();
    for($i = 0; $i < sizeof($classification); $i++){
        for($j = 0; $j < sizeof($classification[$i]); $j++){
            $arraySizeEachFeatures = sizeof($classification[$i][$j]);
            $jumlah = 0;
            for($y = 1; $y < $arraySizeEachFeatures; $y++){
                $parseInt = (int)$classification[$i][$j][$y];
                $jumlah+= $parseInt;
            }
            $naive[$i][$j]["rata"] = $jumlah/$arraySizeEachFeatures; 
        }
    }

    // Hitung STD
    for($i = 0; $i < sizeof($classification); $i++){
        for($j = 0; $j < sizeof($classification[$i]); $j++){
            $arraySizeEachFeatures = sizeof($classification[$i][$j]);
            $jumlah = 0;
            for($y = 1; $y < $arraySizeEachFeatures; $y++){
                $parseInt = (int)$classification[$i][$j][$y];
                $jumlah+= (($parseInt - $naive[$i][$j]["rata"])**2);
            }
            $naive[$i][$j]["std"] = ($jumlah/(sizeof($classification[$i][$j])))**(0.5); 
        }
    }
    //Hitung Probability Density untuk tiap fitur untuk tiap class berdasarkan query.
    $probability_density = array();
    for($i = 0; $i < (sizeof($query) - 1); $i++){
        //hitung kelas 0
        $penyebut_c0 = 0;
        if((2*($naive[0][$i]["std"])**2) != 0){
            $penyebut_c0 = -($query[$i]*($naive[0][$i]["rata"])**2)/(2*($naive[0][$i]["std"])**2);
        }
        $euler_c0 = exp($penyebut_c0);
        $pembilang_c0 = 0;
        if(((((2*(22/7)))**(1/2))*$naive[0][$i]["std"]) != 0){
            $pembilang_c0 = 1/((((2*(22/7)))**(1/2))*$naive[0][$i]["std"]);
        }
        $probability_density[0][$i] = $euler_c0 * $pembilang_c0;

        //hitung kelas 1
        $penyebut_c1 = 0;
        if((2*($naive[1][$i]["std"])**2) != 0){
            -($query[$i]*($naive[1][$i]["rata"])**2)/(2*($naive[1][$i]["std"])**2);
        }
        $euler_c1 = exp($penyebut_c1);
        $pembilang_c1 = 0;
        if(((((2*(22/7)))**(1/2))*$naive[1][$i]["std"]) != 0){
            $pembilang_c1 = 1/((((2*(22/7)))**(1/2))*$naive[1][$i]["std"]);
        }
        $probability_density[1][$i] = $euler_c1 * $pembilang_c1;
    }

    //print_r($naive);
    //print_r($probability_density);
    $naive_query_result = array();
    for($i = 0; $i < sizeof($probability_density); $i++){
        $notasi_pi = 1;
        for($j = 0; $j < sizeof($probability_density[$i]); $j++){
            //echo $probability_density[$i][$j]."<br>";

            //personal modification to avoid 0 values
            $prob_density = $probability_density[$i][$j];
            if($probability_density[$i][$j] == 0){
                $prob_density = 1;
            }

            $notasi_pi *= $prob_density;
        }
        $notasi_pi *= $posterior_probability[$i];
        $naive_query_result[] = $notasi_pi;
    }
    echo "Input: ";
    print_r($query);
    echo "<br>";

    echo "Output: ";
    print_r($naive_query_result);
    echo "<br>";

    $class = 0;
    if($naive_query_result[1] > $naive_query_result[0]){
        $class = 1;
    }
    echo "Query termasuk class ke-".$class;

    //echo sizeof($naive[1]);
?>