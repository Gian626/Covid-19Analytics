<?php 
  class DataHandler{
    public function getLabels($data){
      $labels = "[";
      $counter = 0;
      foreach($data as $row){
        foreach($row as $key=>$value){
          if($key == "data"){
            $date = explode(" ", $value)[0];
            if($counter == sizeof($data)-1){
              $labels = "$labels '$date']";
            }else {
              $labels = "$labels '$date',";
            }
          }
        }
        $counter++;
      }
      return $labels;
    }

    public function getBorderColor($data, $color){
      $borderColor = "[";
      $counter = 0;
      foreach($data as $row){
        if($counter == sizeof($data)-1){
          $borderColor = "$borderColor '$color']";
        }else {
          $borderColor = "$borderColor '$color',";
        }
        
        $counter++;
      }
      return $borderColor;
    }

    public function getValues($data, $searchKey){
      $values = "[";
      $counter = 0;
      foreach($data as $row){
        foreach($row as $key=>$value){
          if($key == $searchKey){
            if($counter == sizeof($data)-1){
              $values = "$values $value]";
            }else {
              $values = "$values $value,";
            }
          }
        }
        $counter++;
      }
      return $values;
    }

    public function getConfig($data, $configs){
      $labels = $this->getLabels($data);
      $datasets = "[";
      $counter = 0;
      foreach($configs as $key=>$value){
        $datasets = "
          $datasets 
          {
            label: '$key',
            data: {$this->getValues($data, $value["key"])},
            backgroundColor: [
              'rgba(255, 255, 255, 0.1)',
            ],
            borderColor: {$this->getBorderColor($data, $value["borderColor"])},
            borderWidth: 1
          }
        ";
        if($counter == sizeof($configs)-1){
          $datasets = "$datasets]";
        }else{
          $datasets = "$datasets,";
        }
        $counter++;
      }
      return "
        {
          type: 'line',
          data: {
            labels: $labels,
            datasets: $datasets
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        }
      ";
    }
  }
?>