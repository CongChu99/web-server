<?php
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '12345678';
   $dbname='luanvan';
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   $hientai= date('Y-m-d');
// Lay du lieu tung node
for($i=0;$i<3;$i++) 
{
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   $node=array("node1","node2","node3");
   if(! $conn )
   {
      die('Không thể kết nối: ' . mysqli_error());
   }
   

   $sql = "SELECT * from $node[$i]";
   $retval = mysqli_query( $conn,$sql );
   
   if(!$retval )
   {
      die('Không thể lấy dữ liệu: ' . mysqli_error());
   }
   $flag=0;
   $x=0;
 while( $row=mysqli_fetch_row($retval))
 {
	if($row[0] == $hientai) $flag=1;
	if($flag==1) 
	{
	if($i==0)
	{
	$node1_t[$x]=$row[3];
	$node1_r[$x]=$row[2];
	$ngay1_x[$x]=$row[0];
	}
	if($i==1)
	{
	$node2_t[$x]=$row[3];
	$node2_r[$x]=$row[2];
	$ngay2_x[$x]=$row[0];
	}
	if($i==2)
	{
	$node3_t[$x]=$row[3];
	$node3_r[$x]=$row[2];
	$ngay3_x[$x]=$row[0];
	}
	$x++;

	}
 }
   mysqli_close($conn);


}


//Lay du lieu nhiet do luong mua qua 1 nam
for($i=1;$i<=6;$i++) 
{
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   if(! $conn )
   {
      die('Không thể kết nối: ' . mysqli_error());
   }
 
   if ($i%2==0)
	{
	$j=$i/2;
   	$sql = "SELECT * FROM nhietdo$j ";
	}
   else 
	{
	$j=($i-1)/2+1;
	$sql = "SELECT * FROM luongmua$j ";
	}

   $retval = mysqli_query($conn,$sql);
   if(! $retval )
   {
      die('Không thể lấy dữ liệu: ' . mysqli_error());
   }
$nam=date('Y');
$nam=$nam-1;
$thang=date('m');
$flag=0;
  if($i%2!=0) 
{ 
 while($row=mysqli_fetch_row($retval))
{
	if ($row[0]==$nam) $flag=1;
	if ($flag==1) 
	{
	for ($k=1;$k<=12;$k++)  $luongmua[($i+1)/2][$k]=$row[$k];
	$row=mysqli_fetch_row($retval);
	for ($k=1;$k<=12;$k++) 
	$luongmua[($i+1)/2][$k+12]=$row[$k];
	break;
	}
}
}
else
{ $flag=0;
while($row=mysqli_fetch_row($retval))
{
	if ($row[0]==$nam) $flag=1;
	if ($flag==1) 
	{
	for ($k=1;$k<=12;$k++)  $nhietdo[$i/2][$k]=$row[$k];
	$row=mysqli_fetch_row($retval);
	for ($k=1;$k<=12;$k++) 
	$nhietdo[$i/2][$k+12]=$row[$k];
	break;
	}
}
}
   mysqli_close($conn);
}
// dua du lieu ra mang
$thang=$thang-1;
$thang+=1;
	for ($k=$thang;$k<$thang+12;$k++)
	{	
	$j=$k-$thang;
	$luongmua1[$j]=$luongmua[1][$k];
	$luongmua2[$j]=$luongmua[2][$k];
	$luongmua3[$j]=$luongmua[3][$k];
	$nhietdo1[$j]=$nhietdo[1][$k];
	$nhietdo2[$j]=$nhietdo[2][$k];
	$nhietdo3[$j]=$nhietdo[3][$k];
	}
	for ($k=$thang;$k<$thang+12;$k++) 
	{
	if($k<=12)
	$ngay[$k-$thang]="$k-$nam";
	else 
	{
	$j=$k-12;
	$f=$nam+1;
	$ngay[$k-$thang]="$j-$f";
	}
	}

// Lay du lieu tu SPI,PE
for ($k=0;$k<2;$k++)
{
$nam=date('Y');
$nam=$nam-1;
$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   if(! $conn )
   {
      die('Không thể kết nối: ' . mysqli_error());
   }

	if ($k==0)
	$sql = "SELECT * FROM SPI";
	else $sql = "SELECT * FROM PE";
   $retval = mysqli_query( $conn, $sql );
   
   if(! $retval )
   {
      die('Không thể lấy dữ liệu PE SPI: ' . mysqli_error());
   }
	$flag=0;
   while($row=mysqli_fetch_row($retval))
	{

	if($row[1]==$nam) $flag=1; 
      //echo $row[2];
      // echo $flag;
	if($flag==1)
	{
	if ($k==0)
	{
       
	for ($i=0;$i<12;$i++) $SPI1[$i]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
        for ($i=0;$i<12;$i++) $SPI2[$i]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $SPI3[$i]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $SPI1[$i+12]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $SPI2[$i+12]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) 
	{	
	$SPI3[$i+12]=$row[$i+2];
	if ($row[$i]!=0){ $chiso=$i-2+12;}
	}
	break;	
	}
	else
	{
        
	for ($i=0;$i<12;$i++) $PE1[$i]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $PE2[$i]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $PE3[$i]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $PE1[$i+12]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) $PE2[$i+12]=$row[$i+2];
	$row=mysqli_fetch_row($retval);
	for ($i=0;$i<12;$i++) 
	{	
	$PE3[$i+12]=$row[$i+2];
	if ($row[$i]!=0) $chiso2=$i-2+12;
	}
	break;	
	}

	}
	
	}
mysqli_close($conn);
}
//for ($i=0;$i<12;$i++) echo$PE2[$i];
for($i=1;$i<=24;$i++) 
{
if ($i<=12)
{
$muaSPI[$i-1]=$i; $thangPE[$i-1]=$i;
}
else {$muaSPI[$i-1]=$i-12; $thangPE[$i-1]=$i-12;}
}
$muaSPI=array_slice($muaSPI,$chiso-11,12);
$thangPE=array_slice($thangPE,$chiso2-11,12);
$SPI1=array_slice($SPI1,$chiso-11,12);
$SPI2=array_slice($SPI2,$chiso-11,12);
$SPI3=array_slice($SPI3,$chiso-11,12);
$PE1=array_slice($PE1,$chiso2-11,12);
$PE2=array_slice($PE2,$chiso2-11,12);
$PE3=array_slice($PE3,$chiso2-11,12);
//echo $PE1[3];
//xong SPI; LAY J

for($k=1;$k<=3;$k++)
{
$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   if(! $conn )
   {
      die('Không thể kết nối: ' . mysqli_error());
   }
 $sql = "SELECT * FROM J where node=$k";

   $retval = mysqli_query( $conn,$sql );
   if(! $retval )
   {
      die('Không thể lấy dữ liệu J: ' . mysqli_error());
   }
	$flag=0;
   while($row=mysqli_fetch_row($retval))
	{
	if ($k==1)
	{ $J1[$flag]=$row[2];
	$ngay1[$flag]=$row[0];
	$flag++;
	}
	if ($k==2)
	{ $J2[$flag]=$row[2];
	$ngay2[$flag]=$row[0];
	$flag++;
	}
	if ($k==3)
	{ $J3[$flag]=$row[2];
	$ngay3[$flag]=$row[0];
	$flag++;
	}
	}
}
 
$J1=array_slice($J1,count($J1)-30,30);
$ngay1=array_slice($ngay1,count($ngay1)-30,30);
$J2=array_slice($J2,count($J2)-30,30);
$ngay2=array_slice($ngay2,count($ngay2)-30,30);
$J3=array_slice($J3,count($J3)-30,30);
$ngay3=array_slice($ngay3,count($ngay3)-30,30);
$node1=count($node1_t)-1;
$node2=count($node2_t)-1;
$node3=count($node3_t)-1; 
$Jindex=count($J1)-1;
$SPIindex=count($SPI1)-1;
$PEindex=count($PE1)-1;
$J[0]=$J1[$Jindex];
$J[1]=$J2[$Jindex];
$J[2]=$J3[$Jindex];
$PE[0]=$PE1[$PEindex];
$PE[1]=$PE2[$PEindex];
$PE[2]=$PE3[$PEindex];
$SPI[0]=$SPI1[$SPIindex];
$SPI[1]=$SPI2[$SPIindex];
$SPI[2]=$SPI3[$SPIindex];
for ($i=0;$i<3;$i++)
{
if ($J[$i]>=60) $J_kl[$i] ="Rất ẩm";
if ($J[$i]<60&&$J[$i]>=30) $J_kl[$i] ="Ẩm";
if ($J[$i]<30&&$J[$i]>=20) $J_kl[$i] ="Bắt đầu hạn";
if ($J[$i]<20&&$J[$i]>=5) $J_kl[$i] ="Hạn nặng";
if ($J[$i]<5) $J_kl[$i]="Hạn rất nặng";
if ($PE[$i]>128) $PE_kl[$i]="Rất ẩm";
if ($PE[$i]>=100&&$PE[$i]<128) $PE_kl[$i]="Ẩm";
if ($PE[$i]>=64&&$PE[$i]<100) $PE_kl[$i]="Ẩm cận ẩm";
if ($PE[$i]>=32&&$PE[$i]<64) $PE_kl[$i]="Khô cận ẩm";
if ($PE[$i]>=16&&$PE[$i]<32) $PE_kl[$i]="Bán khô cằn";
if ($PE[$i]<16) $PE_kl[$i]="Khô cằn";
if ($SPI[$i]>2) $SPI_kl[$i]="Quá ẩm ướt";
if ($SPI[$i]>=1.5&&$SPI[$i]<2) $SPI_kl[$i]="Rất ẩm";
if ($SPI[$i]>=1&&$SPI[$i]<1.49) $SPI_kl[$i]="Ẩm vừa phải";
if ($SPI[$i]>=-1&&$SPI[$i]<0.99) $SPI_kl[$i]="Gần trung bình";
if ($SPI[$i]>=-1.5&&$SPI[$i]<-1.) $SPI_kl[$i]="Hơi khô hạn";
if ($SPI[$i]>=-2&&$SPI[$i]<-1.5) $SPI_kl[$i]="Hạn nặng";
if ($SPI[$i]<=-2) $SPI_kl[$i]="Hạn cực nặng";
}
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
  <title>Cảnh báo hạn hán</title>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV88jBFeBcQ48Br29qN4NNKUtu9xs2YpA&callback=initMap"></script>
  <meta charset="utf-8" />
  <script src='Chart.min.js'></script>
 <script src='jquery-3.3.1.min.js'></script>
<script src='highcharts.js'></script>
</head>
<body text="red">
<p align="center" style="font-size: 32px">HỆ THỐNG CẢNH BÁO HẠN HÁN</p>
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
        xmlhttp.open("GET","getdata.php?q="+str,true);
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
        xmlhttp.open("GET","getdata.php?q="+str,true);
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
        xmlhttp.open("GET","getdata.php?q="+str,true);
        xmlhttp.send();
       }

     var locations = [
      [ 21.029, 105.8017375, 4],
      [21.0346223, 105.7501382, 5],
      [21.0761507,105.7775738 , 3],
      [21.030441 ,105.771142, 2],
      [ 21.074816,105.794144 , 1]
    ];

     var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(21.04654, 105.7860),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var infowindow = new google.maps.InfoWindow()
    var marker1,marker2,marker3, i;

var thu1='<div id="content1"><p></p></div>';
var thu2='<div id="content2"><p></p></div>';
var thu3='<div id="content3"><p></p></div>';

	//thay 2=locations.length
    //for (i = 0; i <3 ; i++) { 
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


 </script>
<div id="txtHint"><b>Person info will be listed here...</b></div>
 <div id="chart2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
 <div id="chart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
 <div id="chart4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
var trucx=<?php echo js_array($ngay); ?>;
var i=0;
for (i=0;i<3;i++)
{
switch(i)
{
	case 0:
	var ten="Nhiệt độ và lượng mưa khu vực Cầu Giấy";
	var chartxx="chart2";
	var luongmua= <?php echo js_array($luongmua1); ?>;
	var nhietdo= <?php echo js_array($nhietdo1); ?>;
	break;
	case 1:
	var ten="Nhiệt độ và lượng mưa khu vực Phương Canh";
	var chartxx='chart3';
	var luongmua= <?php echo js_array($luongmua2); ?>;
	var nhietdo= <?php echo js_array($nhietdo2); ?>;
	break;
	case 2:
	var ten="Nhiệt độ và lượng mưa khu vực Học viện Tài chính";
	var chartxx='chart4';
        var luongmua= <?php echo js_array($luongmua3); ?>;
	var nhietdo= <?php echo js_array($nhietdo3); ?>;
	break;

}
Highcharts.chart(chartxx, {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: ten
    },
    xAxis: [{
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
        }
    }, { // Secondary yAxis
        title: {
            text: 'Lượng mưa',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} mm',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        opposite: true
    }],
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
    series: [{
        name: 'Lượng mưa',
        type: 'column',
        yAxis: 1,
        data: luongmua,
        tooltip: {
            valueSuffix: ' mm'
        }

    }, {
        name: 'Nhiệt độ',
        type: 'spline',
        data: nhietdo,
        tooltip: {
            valueSuffix: '°C'
        }
    }]
});

}//ket thuc vong for
</script>
<div id="chart5" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart6" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart7" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
var i=0;
for (i=0;i<3;i++)
{
switch(i)
{
	case 0:
	var chartx="chart5";
	var tieude="Chỉ số J 30 ngày gần nhất";
	var data1= <?php echo js_array($J1); ?>;
	var data2= <?php echo js_array($J2); ?>;
	var data3= <?php echo js_array($J3); ?>;
	var truc= <?php echo js_array($ngay1); ?>;
	break;
	case 1:
	var chartx='chart6';
	var tieude="Chỉ số PE 12 tháng gần nhất";
	var data1= <?php echo js_array($PE1); ?>;
	var data2= <?php echo js_array($PE2); ?>;
	var data3= <?php echo js_array($PE3); ?>;
	var truc= <?php echo js_array($thangPE); ?>;
	break;
	case 2:
	var tieude="Chỉ số SPI 12 mùa gần nhất";
	var chartx='chart7';
	var data1= <?php echo js_array($SPI1); ?>;
	var data2= <?php echo js_array($SPI2); ?>;
	var data3= <?php echo js_array($SPI3); ?>;
	var truc= <?php echo js_array($muaSPI); ?>;
	break;

}
Highcharts.chart(chartx, {
    chart: {
        type: 'spline'
    },
    title: {
        text: tieude
    },
    xAxis: {
        categories:truc
    },
    yAxis: {
        title: {
            text: 'Chỉ Số'
        },
        labels: {
            formatter: function () {
                return this.value ;
            }
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Cầu Giấy',
        marker: {
            symbol: 'square'
        },
        data: data1


    }, {
        name: 'Phương Canh',
        marker: {
            symbol: 'diamond'
        },
        data: data2
    },
{
        name: 'Học viện Tài chính',
        marker: {
            symbol: 'square'
        },
        data: data3


    }]
});
}
</script>
</body>

</html>


