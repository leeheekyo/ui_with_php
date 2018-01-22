<html>
<style>

.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<body>
<div style="padding-top:20%"> 
<center> 
<div class="loader"></div> 
<h2>Loadding...</h2> 
</center> 
</div>


<?php

   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode($_FILES['image']['name'])));
      
      //$expensions= array("jpeg","jpg","png");
    
      if(empty($file_name)==true){
        echo "<h2>please select your image.</h2>";
        header('Location: index.html');
      }
      
      //if(in_array($file_ext,$expensions)=== false){
      //   $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      //}
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"./test2.jpg");//.$file_name);
	//chmod("test2.jpg",777);
    
        //file excute....
        $command = escapeshellcmd('python3 classification.py');
        $output = shell_exec($command);

        header('Location: result.php');
      }else{
         print_r($errors);
      }
   }



?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
var myVar = setInterval(function(){ myTimer() }, 1000);

function myTimer() {
    var x = document.getElementsByTagName("BUTTON")[0].textContent;
    if(x.length>1){
	location.href="result.php";
    }
}
        $.ajax({
            url:'./result.txt',
            success:function(data){
                $("#div1").html("ok");
                location.href="result.php";
            }
        })
</script>
<script>
function myFunc(){
alert("test");
    location.href="result.php";
}
</script>
<div id="div1" onchange="myFunc()"></div>


</script>
</body>
</html>
