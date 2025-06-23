<?php 
   $link = mysqli_connect("localhost", "root", "") or die("Không mở được kết nối");
   mysqli_select_db($link, "datadiendan") or die("Không mở được cơ sở dữ liệu");
?>