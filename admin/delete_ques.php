<?php
$conn = mysqli_connect("localhost", "root", "", "datadiendan");
if (!$conn) die("Kết nối thất bại: " . mysqli_connect_error());

$id = $_GET['id'];
$sql = "DELETE FROM questions WHERE ID_Ques = $id";
mysqli_query($conn, $sql);
header("Location: admin.php");
exit;
?>