<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="boot/css/bootstrap.css">
    <script src="boot/js/jquery-3.6.0.min.js"></script>
    <script src="boot/js/bootstrap.bundle.js"></script>
    <title>Main_View</title>
</head>
<body>
    <h1>Hi </h1>
     <form action="Home" method="post">
        Name     : <input type="text" name="email" placeholder="Enter the Email here"><br>
        Password : <input type="password" name="name" placeholder="Enter the Password here"><br>
        <input type="Submit" value="Submit">
     </form>  
     <div><?php 
           if(isset($values))
           {
               echo "<table border='1' cellpadding='25%'>
               <tr><th>Email</th><th>Name</th>";
               foreach($values as $row)
               {
                   echo "<tr>
                   <td>$row[email]</td>
                   <td>$row[name]</td>
                   </tr>";
               }
               echo "</table>";

           }    
     ?>
     </div>
</body>
</html>