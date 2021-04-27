<?php 
//index.php
$connect = mysqli_connect("127.0.0.1", "root", "", "testing");
$sub_query = "
   SELECT framework, count(*) as no_of_like FROM like_table 
   GROUP BY framework 
   ORDER BY id ASC";
$result = mysqli_query($connect, $sub_query);
$data = array();
while($row = mysqli_fetch_array($result))
{
 $data[] = array(
  'label'  => $row["framework"],
  'value'  => $row["no_of_like"]
 );
}
$data = json_encode($data);
?>


<!DOCTYPE html>
<html>
 <head>
  <title> PHP & MySql Poll System </title>  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" /> 
     
</head>
 <body>
  <br /><br />
  <div class="container" style="width:800px;">
   <h2 align="center">Live Poll System in PHP Mysql using Ajax </h2>
      <br>
   <form method="post" id="like_form">
    <div class="form-group" style="font-size: 15px">
     <label style="font-size: 25px">Who is your favorite author? </label>
     <div class="radio">
      <label><input type="radio" name="framework" value="Miguel de Cervantes" /> Miguel de Cervantes</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="Charles Dickens" /> Charles Dickens</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="J.R.R. Tolkien" /> J.R.R Tolkien</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="Antoine de Saint-Exuper" /> Antoine de Saint-Exuper</label>
     </div>
    </div>
    <div class="form-group">
     <input type="submit" name="love" class="btn btn-info" value="Love" />
    </div>
   </form>
   <div id="chart"></div>
  </div>
 </body>
</html>

<script>

$(document).ready(function(){
 
 var donut_chart = Morris.Donut({
     element: 'chart',
     data: <?php echo $data; ?>
    });
  
 $('#like_form').on('submit', function(event){
  event.preventDefault();
  var checked = $('input[name=framework]:checked', '#like_form').val();
  if(checked == undefined)
  {
   alert("Please Like any Framework");
   return false;
  }
  else
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"action.php",
    method:"POST",
    data:form_data,
    dataType:"json",
    success:function(data)
    {
     $('#like_form')[0].reset();
     donut_chart.setData(data);
    }
   });
  }
 });
});

</script>