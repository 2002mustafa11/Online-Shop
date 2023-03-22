<?php include 'config.php';
//$co=mysqli_query($con, "SELECT * FROM `users` ORDER BY `users`.`id` ASC");
// $co->num_rows;
$row=mysqli_query($con, "SELECT `id` FROM `users` ");
//mysqli_num_rows();
//print_r(mysqli_fetch_all($row)) ;


?>





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>عربة التسوق</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   <?php
   
      while($u_id=mysqli_fetch_assoc($row)){ 
         $id=$u_id['id'];

         

         $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$id' ") or die('query failed');
   $grand_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      // print_r(mysqli_fetch_all( mysqli_query($con, "SELECT * FROM `users`  WHERE `id` = '$id' ")));
   ?>
<div class="container">
<div class="shopping-cart">

   <table>
   <thead>
      <?php 
      $select=mysqli_query($con, "SELECT * FROM `users`  WHERE `id` = '$id' ") ;
      $data=mysqli_fetch_all($select);
      echo 'الاسم:'.$data[0][1].'<br>';
      echo 'عنوان:'.$data[0][2].'<br>';
      echo 'رقم الهاتف:'.$data[0][3];
      ?>
   </thead>
      <thead>
         <th>id</th>
         <th>الصورة</th>
         <th>الاسم</th>
         <th>السعر</th>
         <th>العدد</th>
         <th>السعر الكلي</th>
         
         
      </thead>
      <tbody>
      <?php
      
        
      /*
         $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$id' ") or die('query failed');
         $grand_total = 0;
         */
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
               

      ?>
      
         <tr>
         <td><h2><?php print_r($id);?> </h2></td>
            <td><img src="<?php echo $fetch_cart['image']; ?>" height="75" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td><?php echo $fetch_cart['price']; ?>$ </td>
            <td> <?php echo $fetch_cart['quantity']; ?></td>
            <td><?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>$</td>
         </tr>
      <?php
         $grand_total += $sub_total;
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">العربة فارغة</td></tr>';}
        
         
         
      ?>
      <tr class="table-bottom">
      <td colspan="2">لإجمالي :</td>
         <td colspan="3">المبلغ الإجمالي :</td>
         <td><?php echo $grand_total; ?>$</td>
      
         <td>
         <a href="ordar.php?delete_all=<?php echo $id?>" onclick="return confirm('حذف كل المنتجات من العربة?');" class="delete-btn ">حذف الكل</a>
         </td>
      </tr>
      <?php } }
      
        if(isset($_GET['delete_all'])){
         $d_id=$_GET['delete_all'];
         mysqli_query($con, "DELETE FROM `cart` WHERE user_id = '$d_id'") or die('query failed');
         header('location:ordar.php');
         }
      ?>
   </tbody> 
   </table>



</div>

</div>

</body>
</html>