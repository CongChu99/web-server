
<!DOCTYPE html> <html> <head> <style> table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);
$diadiem=array("Cầu Giấy","Phương Canh","Học viện tài chính");
$node=array("node1","node2","node3");

$con = mysqli_connect('localhost','root','12345678','luanvan');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
$hientai= date('Y-m-d');

//mysqli_select_db($con,"ajax_demo");
$i=$q-1;
$sql="SELECT * FROM $node[$i] where ngaythang='".$hientai."'";
//echo $sql;
$result = mysqli_query($con,$sql);

//echo "ngay".$hientai;
while($row = mysqli_fetch_array($result)) {
    echo "<p>Địa điểm: " . $diadiem[$i] . "</p>";
    echo "<p>Ngày: " . $row[0] . "</p>";
    echo "<p>Nhiệt độ: " . $row[1] . "</p>";
    echo "<p>Lượng mưa: " . $row[2] . "</p>";
}
//echo "<p> hihihihi</p>";
$nam=date('Y');
//echo $nam;
$thang_hientai=date('m');
$thang_hientai= (int)$thang_hientai;
$thang_hientai=$thang_hientai-1;
if ($thang_hientai==0) {$thang_hientai=12; $nam=$nam-1;}
$thang_hientai=(string)$thang_hientai;
//echo $thang_hientai;
$sql="SELECT thang$thang_hientai FROM PE where nam='".$nam."' AND node='".$q."'";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
    $PE=$row[0];
//echo "<p>PE: " . $row[0] . "</p>";
}
$sql="SELECT thang$thang_hientai FROM SPI where nam='".$nam."' AND node='".$q."'";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
  $SPI=$row[0]; 
// echo "<p>SPI: " . $row[0] . "</p>";
}
$sql="SELECT J FROM J where ngay='".$hientai."' AND node='".$q."'";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
    $J=$row[0];   
//echo "<p>J: " . $row[0] . "hihii $SPI_kl[$i]</p>";
}

if ($J>=60) $J_kl ="Rất ẩm";
if ($J<60&&$J>=30) $J_kl ="Ẩm";
if ($J<30&&$J>=20) $J_kl ="Bắt đầu hạn";
if ($J<20&&$J>=5) $J_kl ="Hạn nặng";
if ($J<5) $J_kl="Hạn rất nặng";
if ($PE>128) $PE_kl="Rất ẩm";
if ($PE>=100&&$PE<128) $PE_kl="Ẩm";
if ($PE>=64&&$PE<100) $PE_kl="Ẩm cận ẩm";
if ($PE>=32&&$PE<64) $PE_kl="Khô cận ẩm";
if ($PE>=16&&$PE<32) $PE_kl="Bán khô cằn";
if ($PE<16) $PE_kl="Khô cằn";
if ($SPI>2) $SPI_kl="Quá ẩm ướt";
if ($SPI>=1.5&&$SPI<2) $SPI_kl="Rất ẩm";
if ($SPI>=1&&$SPI<1.49) $SPI_kl="Ẩm vừa phải";
if ($SPI>=-1&&$SPI<0.99) $SPI_kl="Gần trung bình";
if ($SPI>=-1.5&&$SPI<-1.) $SPI_kl="Hơi khô hạn";
if ($SPI>=-2&&$SPI<-1.5) $SPI_kl="Hạn nặng";
if ($SPI<=-2) $SPI_kl="Hạn cực nặng";


echo "<p>SPI: " . $SPI . " - " .$SPI_kl ." </p>";
echo "<p>PE: " . $PE . "  - " .$PE_kl ."</p>";
echo "<p>J: " . $J . " - " .$J_kl ."</p>";
mysqli_close($con);

?>
</body>
</html> 
