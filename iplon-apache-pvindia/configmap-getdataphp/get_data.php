<?php

$file_name = $_FILES['file']['name'];
$file = $_FILES['file']['tmp_name'];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];

include('/var/www/html/get_data_variable.php');

function fname2nr($f_name){
$f_nr=explode("_", $f_name);
$y=$f_nr[0];
$x=number_format($f_nr[0],0,"",""); 
return $x;
}
$vor_igate_id = fname2nr($file_name);
$file_log_dir = "/var/log/httpd";

function pingDomain($domain, $port){
   $starttime = microtime(true);
   $file      = fsockopen ($domain, $port, $errno, $errstr, 3);
   $stoptime  = microtime(true);
   $status    = 0;

   if (!$file) $status = -1;  // Site is down
   else {
       fclose($file);
       $status = ($stoptime - $starttime) * 1000;
       $status = floor($status);
   }
   return $status;
}

$pattern1 = "/_ALL_/i";
$pattern2 = "/.bz2/i";
$pattern3 = "/.gz$/i";
$pattern4 = "/.gz/i";
$pattern5 = "/.csv/i";

$datum_heute = date('dmy');
$date_string = date('Y-m-d');
$tmp = "/storage/pack";
if (!is_dir($tmp)) {
    mkdir($tmp, 0777);
}

if (!is_dir($tmp . "/" . $vor_igate_id)) {
    mkdir($tmp . "/" . $vor_igate_id, 0777);
}

$command = "echo \"" . date("Y-m-d_H-i-s") . " received file: >" . $file_name . "< id: " . $vor_igate_id . "\" >> " . $file_log_dir . "/incoming.log";
system($command);
if ($file_name == "" || is_null($file_name)) {
    $command = "echo \"No file_name size: ".$file_size." type:".$file_type."\" >> " . $file_log_dir . "/incoming.log";
    system($command);
    return;
}
$tmp_file = $tmp . "/" . $vor_igate_id . "/" . $file_name;

if ($vor_igate_id == 0) {
    echo "Originalname: " . $file_name;
    echo "case 1";
}elseif(preg_match($pattern1, $file_name)) { //TAR Test
    $command = "echo \"" . date("Y-m-d_H-i-s") . " received file: " . $file_name . "\" >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
    system($command);
    copy($file, $tmp_file);
    if (file_exists($tmp_file)) {
        print "Originalname: " . $file_name . "<br>";
        print "case 2";
        if (preg_match($pattern2, $file_name)) {
        print " unzipping... "; 

            $isExcluded = 0;
            foreach ($microgridlakeasia_one as $id1){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id1){
                $isExcluded=1;
                break;
              }
            }
            foreach ($smallutilitylakeasia as $id2){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id2){
                $isExcluded=2;
                break;
              }
            }
            foreach ($largeutilitylakeasia as $id3){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id3){
                $isExcluded=3;
                break;
              }
            }
            foreach ($microgridlakeafrica as $id4){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id4){
                $isExcluded=4;
                break;
              }
            }
            foreach ($microgridlakeamerica as $id5){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id5){
                $isExcluded=5;
                break;
              }
            }
            foreach ($ampluslakeasia as $id6){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id6){
                $isExcluded=6;
                break;
              }
            }
            foreach ($iplonlakeasia as $id7){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id7){
                $isExcluded=7;
                break;
              }
            }
            foreach ($arraymeter as $id8){
              if (substr( "".$vor_igate_id, 0, 8 ) === $id8){
                $isExcluded=8;
                break;
              }
            }
            foreach ($microgridlakeasia_two as $id9){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id9){
                $isExcluded=9;
                break;
              }
            }
            foreach ($microgridlakeasia_three as $id10){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id10){
                $isExcluded=10;
                break;
              }
            }
            foreach ($microgridlakeasia_four as $id11){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id11){
                $isExcluded=11;
                break;
              }
            }
            foreach ($microgridlakeasia_five as $id12){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id12){
                $isExcluded=12;
                break;
              }
            }
            foreach ($microgridlakeasia_six as $id13){
              if (substr( "".$vor_igate_id, 0, 4 ) === $id13){
                $isExcluded=13;
                break;
              }
            }

            if ($isExcluded == 1){
                if (!is_dir("/storage/microgridlakeasiaone/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeasiaone/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiaone/csv-to-microgridlakeasiaone/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiaone/csv-to-microgridlakeasiaone/";
                system($command);
            }elseif ($isExcluded == 2){
                if (!is_dir("/storage/smallutilitylakeasia/logs/" . $date_string)) {
                    mkdir("/storage/smallutilitylakeasia/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/sulasia/csv-to-smallutilitylakeasia/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/sulasia/csv-to-smallutilitylakeasia/";
                system($command);
            }elseif ($isExcluded == 3){
                if (!is_dir("/storage/largeutilitylakeasia/logs/" . $date_string)) {
                    mkdir("/storage/largeutilitylakeasia/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                 system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/lulasia/csv-to-largeutilitylakeasia/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/lulasia/csv-to-largeutilitylakeasia/";
                system($command);
            }elseif ($isExcluded == 4){
                if (!is_dir("/storage/microgridlakeafrica/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeafrica/logs/" . $date_string, 0777);
                }
  
                if (!is_dir("/storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglafrica/csv-to-microgridlakeafrica/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglafrica/csv-to-microgridlakeafrica/";
                system($command);
            }elseif ($isExcluded == 5){
                if (!is_dir("/storage/microgridlakeamerica/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeamerica/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglamerica/csv-to-microgridlakeamerica/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglamerica/csv-to-microgridlakeamerica/";
                system($command);
            }elseif ($isExcluded == 6){
                if (!is_dir("/storage/ampluslakeasia/logs/" . $date_string)) {
                    mkdir("/storage/ampluslakeasia/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/amplasia/csv-to-ampluslakeasia/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/amplasia/csv-to-ampluslakeasia/";
                system($command);
            }elseif ($isExcluded == 7){
                if (!is_dir("/storage/iplonlakeasia/logs/" . $date_string)) {
                    mkdir("/storage/iplonlakeasia/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/iplasia/csv-to-iplonlakeasia/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/iplasia/csv-to-iplonlakeasia/";
                system($command);
            }elseif ($isExcluded == 8){
                if (!is_dir("/storage/arraymeter/logs/" . $date_string)) {
                    mkdir("/storage/arraymeter/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.unsent /storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglamerica/csv-to-microgridlakeamerica/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglamerica/csv-to-microgridlakeamerica/";
                system($command);
            }elseif ($isExcluded == 9){
                if (!is_dir("/storage/microgridlakeasiatwo/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeasiatwo/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiatwo/csv-to-microgridlakeasiatwo/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiatwo/csv-to-microgridlakeasiatwo/";
                system($command);
            }elseif ($isExcluded == 10){
                if (!is_dir("/storage/microgridlakeasiathree/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeasiathree/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiathree/csv-to-microgridlakeasiathree/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiathree/csv-to-microgridlakeasiathree/";
                system($command);
            }elseif ($isExcluded == 11){
                if (!is_dir("/storage/microgridlakeasiafour/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeasiafour/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiafour/csv-to-microgridlakeasiafour/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiafour/csv-to-microgridlakeasiafour/";
                system($command);
            }elseif ($isExcluded == 12){
                if (!is_dir("/storage/microgridlakeasiafive/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeasiafive/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiafive/csv-to-microgridlakeasiafive/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiafive/csv-to-microgridlakeasiafive/";
                system($command);
            }elseif ($isExcluded == 13){
                if (!is_dir("/storage/microgridlakeasiasix/logs/" . $date_string)) {
                    mkdir("/storage/microgridlakeasiasix/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);
                $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiasix/csv-to-microgridlakeasiasix/";
                system($command);

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiasix/csv-to-microgridlakeasiasix/";
                system($command);
            }else {
                if (!is_dir("/storage/other/logs/" . $date_string)) {
                    mkdir("/storage/other/logs/" . $date_string, 0777);
                }

                if (!is_dir("/storage/other/logs/" . $date_string . "/" . $vor_igate_id)) {
                    mkdir("/storage/other/logs/" . $date_string . "/" . $vor_igate_id, 0777);
                }

                $command = "cd /storage/pack/" . $vor_igate_id . " && mv * /storage/other/logs/" . $date_string . "/" . $vor_igate_id . "/";
                system($command);
            }
            unlink($tmp_file);
        }
    }
}elseif(preg_match($pattern5, $file_name)) { //csv Test
    $command = "echo \"" . date("Y-m-d_H-i-s") . " received file: " . $file_name . "\" >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
    system($command);
    copy($file, $tmp_file);
    if (file_exists($tmp_file)) {
        print "Originalname: " . $file_name . "<br>";
        print "case 3";
        print " csv file received... ";

        $isExcluded = 0;
        foreach ($microgridlakeasia_one as $id1){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id1){
            $isExcluded=1;
            break;
          }
        }
        foreach ($smallutilitylakeasia as $id2){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id2){
            $isExcluded=2;
            break;
          }
        }
        foreach ($largeutilitylakeasia as $id3){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id3){
            $isExcluded=3;
            break;
          }
        }
        foreach ($microgridlakeafrica as $id4){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id4){
            $isExcluded=4;
            break;
          }
        }
        foreach ($microgridlakeamerica as $id5){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id5){
            $isExcluded=5;
            break;
          }
        }
        foreach ($ampluslakeasia as $id6){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id6){
            $isExcluded=6;
            break;
          }
        }
        foreach ($iplonlakeasia as $id7){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id7){
            $isExcluded=7;
            break;
          }
        }
        foreach ($arraymeter as $id8){
          if (substr( "".$vor_igate_id, 0, 8 ) === $id8){
            $isExcluded=8;
            break;
          }
        }
        foreach ($microgridlakeasia_two as $id9){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id9){
            $isExcluded=9;
            break;
          }
        }
        foreach ($microgridlakeasia_three as $id10){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id10){
            $isExcluded=10;
            break;
          }
        }
        foreach ($microgridlakeasia_four as $id11){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id11){
            $isExcluded=11;
            break;
          }
        }
        foreach ($microgridlakeasia_five as $id12){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id12){
            $isExcluded=12;
            break;
          }
        }
        foreach ($microgridlakeasia_six as $id13){
          if (substr( "".$vor_igate_id, 0, 4 ) === $id13){
            $isExcluded=13;
            break;
          }
        }

        if ($isExcluded == 1){
            if (!is_dir("/storage/microgridlakeasiaone/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeasiaone/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiaone/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiaone/csv-to-microgridlakeasiaone/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiaone/csv-to-microgridlakeasiaone/";
            system($command);
        }elseif ($isExcluded == 2){
            if (!is_dir("/storage/smallutilitylakeasia/logs/" . $date_string)) {
                mkdir("/storage/smallutilitylakeasia/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/smallutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/sulasia/csv-to-smallutilitylakeasia/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/sulasia/csv-to-smallutilitylakeasia/";
            system($command);
        }elseif ($isExcluded == 3){
            if (!is_dir("/storage/largeutilitylakeasia/logs/" . $date_string)) {
                mkdir("/storage/largeutilitylakeasia/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/largeutilitylakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/lulasia/csv-to-largeutilitylakeasia/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/lulasia/csv-to-largeutilitylakeasia/";
            system($command);
        }elseif ($isExcluded == 4){
            if (!is_dir("/storage/microgridlakeafrica/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeafrica/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeafrica/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglafrica/csv-to-microgridlakeafrica/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglafrica/csv-to-microgridlakeafrica/";
            system($command);
        }elseif ($isExcluded == 5){
            if (!is_dir("/storage/microgridlakeamerica/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeamerica/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);
            
            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeamerica/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglamerica/csv-to-microgridlakeamerica/";
            system($command);
          
            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglamerica/csv-to-microgridlakeamerica/";
            system($command);
        }elseif ($isExcluded == 6){
            if (!is_dir("/storage/ampluslakeasia/logs/" . $date_string)) {
                mkdir("/storage/ampluslakeasia/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);
            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/ampluslakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/amplasia/csv-to-ampluslakeasia/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/amplasia/csv-to-ampluslakeasia/";
            system($command);
        }elseif ($isExcluded == 7){
            if (!is_dir("/storage/iplonlakeasia/logs/" . $date_string)) {
                mkdir("/storage/iplonlakeasia/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);
            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/iplonlakeasia/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/iplasia/csv-to-iplonlakeasia/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/iplasia/csv-to-iplonlakeasia/";
            system($command);
        }elseif ($isExcluded == 8){
            if (!is_dir("/storage/arraymeter/logs/" . $date_string)) {
                mkdir("/storage/arraymeter/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && tar -vxjf " . $file_name . " >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);
            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.unsent /storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/arraymeter/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglamerica/csv-to-microgridlakeamerica/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglamerica/csv-to-microgridlakeamerica/";
            system($command);
        }elseif ($isExcluded == 9){
            if (!is_dir("/storage/microgridlakeasiatwo/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeasiatwo/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiatwo/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiatwo/csv-to-microgridlakeasiatwo/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiatwo/csv-to-microgridlakeasiatwo/";
            system($command);
        }elseif ($isExcluded == 10){
            if (!is_dir("/storage/microgridlakeasiathree/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeasiathree/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiathree/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiathree/csv-to-microgridlakeasiathree/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiathree/csv-to-microgridlakeasiathree/";
            system($command);
        }elseif ($isExcluded == 11){
            if (!is_dir("/storage/microgridlakeasiafour/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeasiafour/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiafour/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiafour/csv-to-microgridlakeasiafour/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiafour/csv-to-microgridlakeasiafour/";
            system($command);
        }elseif ($isExcluded == 12){
            if (!is_dir("/storage/microgridlakeasiafive/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeasiafive/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiafive/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiafive/csv-to-microgridlakeasiafive/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiafive/csv-to-microgridlakeasiafive/";
            system($command);
        }elseif ($isExcluded == 13){
            if (!is_dir("/storage/microgridlakeasiasix/logs/" . $date_string)) {
                mkdir("/storage/microgridlakeasiasix/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id)) {
                mkdir("/storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && wc -l * >> " . $file_log_dir . "/" . $vor_igate_id . ".log";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv.unsent /storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && cp *.csv /storage/microgridlakeasiasix/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv.unsent /data/mglasiasix/csv-to-microgridlakeasiasix/";
            system($command);

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv *.csv /data/mglasiasix/csv-to-microgridlakeasiasix/";
            system($command);
        }else {
            if (!is_dir("/storage/other/logs/" . $date_string)) {
               mkdir("/storage/other/logs/" . $date_string, 0777);
            }

            if (!is_dir("/storage/other/logs/" . $date_string . "/" . $vor_igate_id)) {
               mkdir("/storage/other/logs/" . $date_string . "/" . $vor_igate_id, 0777);
            }

            $command = "cd /storage/pack/" . $vor_igate_id . " && mv * /storage/other/logs/" . $date_string . "/" . $vor_igate_id . "/";
            system($command);
        }
        unlink($tmp_file);
    }
}else {//Datei 
    copy($file, $tmp_file);
    if (file_exists($tmp_file)) {
        print "Originalname: " . $file_name;
        if(preg_match($pattern3, $tmp_file)) {
            print " unzipping... ";
            print "case 4";
            $command = "/usr/bin/gunzip " . $tmp_file;
            system($command);
        }
        $curl_filename=preg_replace($pattern4,"", $tmp_file );
    } else {
        echo "�bertragung fehlgeschlagen";
    }
}//Datei

?>
