<?php
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '12345678';
   $dbname='anhbinh';
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   $hientai= date('H');
   $hientai= intval($hientai);
   $node=array("node1","node2","node3","node4");
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   if(! $conn )
   {
      die('Không thể kết nối: ' . mysqli_error());
   }
   $i=0;  

   $sql = "SELECT * from hourtemp where hour>$hientai";
   $retval = mysqli_query( $conn,$sql );
   
   if(!$retval )
   {
      die('Không thể lấy dữ liệu hourtemp: ' . mysqli_error());
   }
   while( $row=mysqli_fetch_row($retval))
   {
        $gio[$i]= $row[0];
	$node1_temp[$i]=$row[1];
	$node2_temp[$i]=$row[2];
	$node3_temp[$i]=$row[3];
	$node4_temp[$i]=$row[4];
	$i++;
   }
  $sql = "SELECT * from hourtemp where hour<=$hientai";
   $retval = mysqli_query( $conn,$sql );
   
   if(!$retval )
   {
      die('Không thể lấy dữ liệu hourtemp 2: ' . mysqli_error());
   }
   while( $row=mysqli_fetch_row($retval))
   {
        $gio[$i]= $row[0]; 
	$node1_temp[$i]=$row[1];
	$node2_temp[$i]=$row[2];
	$node3_temp[$i]=$row[3];
	$node4_temp[$i]=$row[4];
	$i++;
   }
  $now=date('Y-m-d');
  $date = date_create($now);
date_sub($date, date_interval_create_from_date_string('30 days'));
$date=date_format($date, 'Y-m-d');  
$i=0;
 $sql = "SELECT * from daytemp where ngay>='$date'";
$retval = mysqli_query( $conn,$sql);
   
   if(!$retval )
   {
      die('Không thể lấy dữ liệu hou: ' . mysqli_error());
   }
   while( $row=mysqli_fetch_row($retval))
   {
	   $ngay[$i]=$row[0];
	   $day_temp1[$i]=$row[1];
	   $day_temp2[$i]=$row[2];
           $day_temp3[$i]=$row[3]; 
	   $day_temp4[$i]=$row[4];
	   $i=$i+1;
   }
   mysqli_close($conn);
 
?>
<?php
    function js_str($s) {
        if (!is_numeric($s)) {
            return '"' . addcslashes($s, "\0..\37\"\\") . '"';
        } else {
            return addcslashes($s, "\0..\37\"\\");
        }
    }

    function js_array($array) {
        $temp = array_map('js_str', $array);
        return '[' . implode(', ', $temp) . ']';
    }
?>



<html lang="en">
<head>
  <title>Giám sát nhiệt độ </title>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV88jBFeBcQ48Br29qN4NNKUtu9xs2YpA&callback=initMap"></script>
  <meta charset="utf-8" />
  <script src='Chart.min.js'></script>
 <script src='jquery-3.3.1.min.js'></script>
<script src='highcharts.js'></script>
</head>
<body text="red">
<p align="center" style="font-size: 32px">HỆ THỐNG GIÁM SÁT NHIỆT ĐỘ</p>
<div id="map" style="min-width: 310px; height: 700px; margin: 0 auto"></div>
<script type="text/javascript">
    //phan nay sua
    function showUser1(str) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content1").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getdata_anhbinh.php?q="+str,true);
        xmlhttp.send();
       }
    function showUser2(str) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content2").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getdata_anhbinh.php?q="+str,true);
        xmlhttp.send();
       }

       function showUser3(str) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content3").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getdata_anhbinh.php?q="+str,true);
        xmlhttp.send();
       }
       function showUser4(str) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content4").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getdata_anhbinh.php?q="+str,true);
        xmlhttp.send();
       }


     var locations = [
      [ 21.029, 105.8017375, 4],
      [21.0346223, 105.7501382, 5],
      [21.0761507,105.7775738 , 3],
      [21.065151, 105.826497, 2],
      [ 21.074816,105.794144 , 1]
    ];

     var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(21.04654, 105.7860),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var infowindow = new google.maps.InfoWindow()
    var marker1,marker2,marker3,marker4, i;

var thu1='<div id="content1"><p></p></div>';
var thu2='<div id="content2"><p></p></div>';
var thu3='<div id="content3"><p></p></div>';
var thu4='<div id="content4"><p></p></div>';
 
      marker1 = new google.maps.Marker({

        position: new google.maps.LatLng(locations[0][0], locations[0][1]),

        map: map

      });
      marker2 = new google.maps.Marker({

        position: new google.maps.LatLng(locations[1][0], locations[1][1]),

        map: map

      });

      marker3 = new google.maps.Marker({

        position: new google.maps.LatLng(locations[2][0], locations[2][1]),

        map: map

      });
     marker4 = new google.maps.Marker({

        position: new google.maps.LatLng(locations[3][0], locations[3][1]),

        map: map

      });

      google.maps.event.addListener(marker1, 'click', (function(marker1, i) {

        return function() {

          infowindow.setContent(thu1);

          infowindow.open(map, marker1);
         showUser1(1);
          setInterval (showUser1,250,1);     
        }

      })(marker1, i));
      google.maps.event.addListener(marker2, 'click', (function(marker2, i) {

        return function() {

          infowindow.setContent(thu2);

          infowindow.open(map, marker2);
         showUser2(2);
         setInterval (showUser2,250,2);
        
        }

      })(marker2, i));
      google.maps.event.addListener(marker3, 'click', (function(marker3, i) {

        return function() {

          infowindow.setContent(thu3);

          infowindow.open(map, marker3);
         showUser3(3);
      
        setInterval (showUser3,250,3);     
        }

      })(marker3, i));
google.maps.event.addListener(marker4, 'click', (function(marker4, i) {

        return function() {

          infowindow.setContent(thu4);

          infowindow.open(map, marker4);
         showUser4(4);
          setInterval (showUser4,250,4);     
        }

      })(marker4, i));


 </script>

 <div id="chart2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
var trucx=<?php echo js_array($gio); ?>;
var i=0;
var ten="Nhiệt độ 24 giờ gần nhất";
var chartxx="chart2";
var nhietdo1= <?php echo js_array($node1_temp); ?>;
var nhietdo2= <?php echo js_array($node2_temp); ?>;
var nhietdo3= <?php echo js_array($node3_temp); ?>;
var nhietdo4= <?php echo js_array($node4_temp); ?>;
Highcharts.chart(chartxx, {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: ten
    },
	    xAxis: [{
	    title:{text:'Giờ'},
        categories: trucx,
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Nhiệt độ',
            style: {
                color: Highcharts.getOptions().colors[1]
        }
    }}],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
},
    series: [ {
        name: 'node 1',
        type: 'spline',
        data: nhietdo1,
        tooltip: {
            valueSuffix: '°C'
        }
    }, {
    name: 'node 2',
        type: 'spline',
        data: nhietdo2,
        tooltip: {
            valueSuffix: '°C'
        }
    },  {
    name: 'node 3',
        type: 'spline',
        data: nhietdo3,
        tooltip: {
            valueSuffix: '°C'
        }
    },  {
    name: 'node 4',
        type: 'spline',
        data: nhietdo4,
        tooltip: {
            valueSuffix: '°C'
        }
    }  ]
});

</script>

 <div id="chart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
var trucx=<?php echo js_array($ngay); ?>;
var i=0;
var ten="Nhiệt độ 30 ngày gần nhất";
var chartxx="chart3";
var nhietdo1= <?php echo js_array($day_temp1); ?>;
var nhietdo2= <?php echo js_array($day_temp2); ?>;
var nhietdo3= <?php echo js_array($day_temp3); ?>;
var nhietdo4= <?php echo js_array($day_temp4); ?>;
Highcharts.chart(chartxx, {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: ten
    },
	    xAxis: [{
	    title:{text:'Ngày'},
        categories: trucx,
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Nhiệt độ',
            style: {
                color: Highcharts.getOptions().colors[1]
        }
    }}],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
},
    series: [ {
        name: 'node 1',
        type: 'spline',
        data: nhietdo1,
        tooltip: {
            valueSuffix: '°C'
        }
    }, {
    name: 'node 2',
        type: 'spline',
        data: nhietdo2,
        tooltip: {
            valueSuffix: '°C'
        }
    },  {
    name: 'node 3',
        type: 'spline',
        data: nhietdo3,
        tooltip: {
            valueSuffix: '°C'
        }
    },  {
    name: 'node 4',
        type: 'spline',
        data: nhietdo4,
        tooltip: {
            valueSuffix: '°C'
        }
    }  ]
});

</script>

</body>

</html>


