<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="boot/css/bootstrap.css">
    <script src="boot/js/jquery-3.6.0.min.js"></script>
     <script src="boot/js/bootstrap.bundle.js"></script>
    <title>SignUp Bootstrap</title>
</head>
<body class="bg-dark">
<div class="container d-flex justify-content-center" style="margin-top: 15%">
 <div class="col-md-4 jumbotron shadow-lg bg-dark">  
   <div class="alert alert-danger">Fill all the text boxes</div>
     <form method="post" action="SignUp" autocomplete="off">
        <div class="form-group">
        <input type="text" name="email" placeholder="Enter Email here" class="form-control">
        </div>
        
        <br>
        <div class="form-group">
         <input type="Password" name="password" placeholder="Enter Password here" class="form-control">
        </div>  
        
        <br>
        <div class="form-group">
         <input type="submit" value="Signup" class="form-control btn btn-primary btn-block">
        </div>
        <a href="Home"><p class="text-right text-white">Already have account?</p></a>
     </form>

    
 </div>

</div
</body>
</html>