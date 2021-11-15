
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
$diadiem=array("Cầu Giấy","Phương Canh","Học viện tài chính","Hồ Tây");
$node=array("node1","node2","node3","node4");
date_default_timezone_set('Asia/Ho_Chi_Minh');
$con = mysqli_connect('localhost','root','12345678','anhbinh');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
$hientai= date('Y-m-d');
$gio=date('H:i:s');
$i=$q-1;
$sql="SELECT * FROM $node[$i] where ngay='".$hientai."'";
echo "NODE $q";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
	$ngay=$row[0];
	$nhietdo=$row[2];
}
    echo "<p>Địa điểm: " . $diadiem[$i] . "</p>";
    echo "<p>Ngày: " . $ngay . "</p>";
    echo "<p>Giờ: ".$gio."</p>";
    echo "<p>Nhiệt độ: " . $nhietdo . "</p>";
mysqli_close($con);
?>
</body>
</html> 
