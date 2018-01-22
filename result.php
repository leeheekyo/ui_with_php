<html>
<meta charset="utf-8">

<?php

$json_p = '{
  "type": "hbar",
  "font-family": "Arial",
  "title": {
    "text": "물고기 분류 결과",
    "font-family": "Arial",
    "background-color": "none",
    "font-color": "#A4A4A4",
    "font-size": "16px"
  },
  "labels": [{
    "text": "종류",
    "font-size": "10px",
    "font-color": "#9d9d9d",
    "x": "130",
    "y": "20%"
  }, {
    "text": "확률",
    "font-size": "10px",
    "font-color": "#9d9d9d",
    "x": "180",
    "y": "20%"
  }],
  "plot": {
    "bars-overlap": "100%",
    "borderRadius": 8,
    "hover-state": {
      "visible": false
    },
    "animation": {
      "delay": 100,
      "effect": 3,
      "speed": "500",
      "method": "0",
      "sequence": "3"
    }
  },
  "plotarea": {
    "margin": "60px 20px 20px 180px"
  },
  "scale-x": {
    "line-color": "none",
    "values": ["Tuna", "Batoidea", "Shark"],
    "tick": {
      "visible": false
    },
    "guide": {
      "visible": false
    },
    "item": {
      "font-size": "14px",
      "padding-right": "20px",
      "auto-align": true,
      "rules": [{
        "rule": "%i==0",
        "font-color": "#6FA6DF"
      }, {
        "rule": "%i==1",
        "font-color": "#A0BE4A"
      }, {
        "rule": "%i==2",
        "font-color": "#FA8452"
      }, {
        "rule": "%i==3",
        "font-color": "#FCAE48"
      }, {
        "rule": "%i==4",
        "font-color": "#FCCC65"
      }]
    }
  },
  "scale-y": {
    "visible": false,
    "guide": {
      "visible": false
    }
  },
  "series": [{
    "values": [30, 30, 30],
    "bar-width": "40px",
    "background-color": "#f2f2f2",
    "border-color": "#e8e3e3",
    "border-width": 2,
    "fill-angle": 90,
    "tooltip": {
      "visible": false
    }
  }, {
    "values": [10, 15, 13],
    "bar-width": "32px",
    "max-trackers": 0,
    "value-box": {
      "placement": "top-out",
      "text": "%v",
      "decimals": 0,
      "font-color": "#A4A4A4",
      "font-size": "0px",
      "alpha": 0.6
    },
    "rules": [{
      "rule": "%i==0",
      "background-color": "#6FA6DF"
    }, {
      "rule": "%i==1",
      "background-color": "#A0BE4A"
    }, {
      "rule": "%i==2",
      "background-color": "#FA8452"
    }, {
      "rule": "%i==3",
      "background-color": "#FCAE48"
    }, {
      "rule": "%i==4",
      "background-color": "#FCCC65"
    }]
  }]
}';

$specific = [];
$specific['Shark'] = [
'Carcharhiniformes',
'Heterodontiformes',
'Hexanchiformes',
'Lamniformes',
'Orectolobiformes',
'Pristiformes',
'Squaliformes',
'Squatiniformes'
];
$specific['Batoidea'] = [
'Dasyatiformes',
'Myliobatiformes',
'Rajiformes',
'Rhinobatiformes',
'Torpediniformes'
];
$specific['Tuna'] = [
'Albacore tuna',
'Atlantic bluefin tuna',
'Bigeye tuna',
'Blackfin tuna',
'Bullet tuna',
'Frigate tuna',
'Little tunny',
'Longtail tuna',
'Mackerel tuna',
'Pacific bluefin tuna',
'Skipjack tuna',
'Slender tuna',
'Southern bluefin tuna',
'Yellowfin tuna'
];

$json_a = json_decode($json_p, true);
$json_a2 = json_decode($json_p, true);
$json_a2['title']['text']='상세 분류 결과';

//file read
$filename = "result.txt";
$file = fopen( $filename, "r" );

while( $file == false ) {
    usleep(100000);
    $filename = "result.txt";
    $file = fopen( $filename, "r" );
    //echo ( "Error in opening file" );
    //exit();
}

$filesize = filesize( $filename );
$filetext = fread( $file, $filesize );

fclose( $file );
unlink('result.txt'); //file remove

//echo ( "File size : $filesize bytes" );
$nfiletext = explode("\n", $filetext);

$c = (int)(count($nfiletext));

$i=0;
$max=0;
foreach($nfiletext as $str){
    $substr = explode(" ", $str);
    $len = count($substr);
    if($len<2){
        break;
    }
    $title = $substr[0];
    $value = (int)$substr[$len-1];
    $len-=1;
    for($j=1; $j<$len; $j++){  //is_number($substr[$i])
        $title= $title . " " . $substr[$j];
    }
    $i+=1;
    if($i%3==1){
        $max=0;
    }
    if($i<=3){
        $json_a['scale-x']['values'][3-$i]=$title;
        $json_a['series'][1]['values'][3-$i]=$value;
        if($value > $max){
            $max = $value;
        }
        if($i%3==0){
            for($j=1;$j<=$max;$j=$j*10) ; 
            if($j!=1) $j=$j/10;
            for($k=$j;$k<=$max;$k=$k+$j) ; 
            for($j=0; $j<3; $j+=1){
                $json_a['series'][0]['values'][$j]=$k;//((int)(($max+1)/10)+1)*10;
            }
        }
    }
    else {
        $json_a2['scale-x']['values'][6-$i]=$title;
        $json_a2['series'][1]['values'][6-$i]=$value;
        if($value > $max){
            $max = $value;
        }
        if($i%3==0){
            for($j=1;$j<=$max;$j=$j*10) ; 
            if($j!=1) $j=$j/10;
            for($k=$j;$k<=$max;$k=$k+$j) ; 
            for($j=0; $j<3; $j+=1){
                $json_a2['series'][0]['values'][$j]=$k;//((int)(($max+1)/10)+1)*10;
            }
        }
    }
}
$json = json_encode($json_a);
if($c>4) {
	$json2 = json_encode($json_a2);
}
else $json2 = "0";

//set real value  << calculate
//$json_a['series'][1]['values'][0]=1;
//$json_a['series'][1]['values'][1]=2;
//$json_a['series'][1]['values'][2]=9;

//$max_val = 9;

//set max value
//for($i=0; $i<3; $i+=1){
//    $json_a['series'][0]['values'][$i]=((int)(($max_val+1)/10)+1)*10;
//}

//set text value << result of first value
//$select_item='Shark';
//for($i=0; $i<3; $i+=1){
//    $json_a2['scale-x']['values'][$i]=$specific[$select_item][$i];
//}

//set real value << calculate
//$json_a2['series'][1]['values'][0]=1;
//$json_a2['series'][1]['values'][1]=2;
//$json_a2['series'][1]['values'][2]=3;

//$max_val = 3;

//set max value
//for($i=0; $i<3; $i+=1){
//    $json_a2['series'][0]['values'][$i]=((int)(($max_val+1)/10)+1)*10;
//}


//$json = json_encode($json_a);
//$json2 = json_encode($json_a2);

?>

<head>
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
  </script>
  <style>
    html,
    body {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
    }
    
    #myChart, #myChart2 {
      height: 220;
      width: 50%;
      min-height: 150px;
    }
    
    #result {
      height: 5%;
      width: 100%;
    }
    
    .zc-ref {
      display: none;
    }

  </style>
  <!-- for file preview -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
</head>

<body>
  <h2 id="result" style="text-align:center; padding-top:10" onclick="location.href = 'index.html'">이미지(변경)</h1>
  <form id="upload" runat="server" method='POST' style="text-align:center" action="tmp.php">
    <fieldset>
    <img id="blah" src="test2.jpg" />
    </fieldset>
  </form>
  <hr />
  <h2 id="result" style="text-align:center;">결과</h1>
  <div style='float:left' id='myChart'></div>
  <div style='float:right' id='myChart2'></div>
<script>
    var myConfig = <?php echo $json; ?>;
    var myConfig2 = <?php echo $json2; ?>;
            zingchart.render({
              id: 'myChart',
              data: myConfig,
              height: "100%",
              width: "100%"
            });
    if(myConfig2!=0){
            zingchart.render({
              id: 'myChart2',
              data: myConfig2,
              height: "100%",
              width: "100%"
            });
    }
</script>
</body>

</html>
