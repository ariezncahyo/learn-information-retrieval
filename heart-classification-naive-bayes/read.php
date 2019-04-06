<?php
    function readCSV($sample){
        $file = fopen("datasets/heart.csv", "r");

        $dataset = array();
        $jumlah_datatest = 10;
        $i = 0;
        while($i < $sample){
            $dataset[] = fgetcsv($file, ",");
            $i++;
        }
        fclose($file);
        return $dataset;
    }
    function setDataTraining($dataset){
        $jumlah_attribut = sizeof($dataset[0]);
        $jumlah_record = sizeof($dataset);
        
        $data_train = array();
        $jumlah_data_train = floor($jumlah_record * 0.3);
        $first_and_last_sampling = floor($jumlah_data_train / 2);

        for($i = 0; $i < $first_and_last_sampling; $i++){
            $data_train[] = $dataset[$i];
        }

        for($i = $jumlah_record - 1; $i > ( $jumlah_record - $first_and_last_sampling); $i--){
            $data_train[] = $dataset[$i];
        }

        return $data_train;
    }
?>