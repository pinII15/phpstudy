
<?php
//1 传入页码
 $page=$_GET['p'];

 $host='localhost';
 $username='root';
 $password='1997615';
 $db='db1';
 $pageSize=10;
 $showpage=5;
 $conn=new mysqli($host,$username,$password,$db);
 if(!$conn){
     echo "数据库连接失败";
     exit;
 }


 $sql="SELECT * FROM page LIMIT " . ($page-1)*$pageSize . ",10";
 $result=mysqli_query($conn,$sql);
echo "<table border=1 cellspacing='0' width='40%'>";
echo "<tr> <td>id</td><td>name</td></tr>";
 while($row=mysqli_fetch_assoc($result)){
    echo "<tr>";
     echo "<td>{$row['id']}</td>";
     echo "<td>{$row['name']}</td>";
     echo "</tr>";

 }
 echo "</table>";
 //获取数据总数
$total_sql="SELECT COUNT(*) FROM page";
$total_result=mysqli_fetch_array(mysqli_query($conn,$total_sql));
$total=$total_result[0];
//计算页数
$total_pages=ceil($total/$pageSize);
$conn->close();
//分页显示
$page_banner="";
//计算偏移量
$pageoffset=($showpage-1)/2;

if($page>1){
    $page_banner .="<a href='".$_SERVER["PHP_SELF"]."?p=1'>首页</a>";
    $page_banner .="<a href='".$_SERVER["PHP_SELF"]."?p=".($page-1)."'>上一页</a>";
}
//初始化数据
$start=1;
$end=$total_pages;
//显示页码
if($total_pages>$showpage){
    if($page>$pageoffset+1){
        $page_banner .="...";
    }
    if($page>$pageoffset){
        $start=$page-$pageoffset;
        $end=$total_pages>$page+$pageoffset?$page+$pageoffset:$total_pages;
    }else{
        $start=1;
        $end=$total_pages>$showpage?$showpage:$total_pages;
    }
    if($page+$pageoffset>$total_pages){
        $start=$start-($page+$pageoffset-$end);
    }
}
for($i=$start;$i<=$end;$i++){
    $page_banner .="<a href='".$_SERVER["PHP_SELF"]."?p=".$i."'>{$i}</a>";
}
if($total_pages>$showpage&&$total_pages>$page+$pageoffset){
    $page_banner .="...";
}
if($page<$total_pages)
{$page_banner .="<a href='".$_SERVER["PHP_SELF"]."?p=".($page+1)."'>下一页</a>";
$page_banner .="<a href='".$_SERVER["PHP_SELF"]."?p=".($total_pages)."'>尾页</a>";}
$page_banner .="共{$total_pages}页,";
$page_banner .="<form action='mypage.php' method='get'>";
$page_banner .="到第<input type='text' size='2' name='p'>页";
$page_banner .="<input type='submit' value='确定'>";
$page_banner .="</form>";
echo $page_banner;