<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="boot/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="boot/css/form.css" >
    <script src="boot/js/jquery-3.6.0.min.js"></script>
     <script src="boot/js/bootstrap.bundle.js"></script>
     <title>Email & TCPDF </title>
</head>
<body>
    <div class="row">
    <div class="col-md-6 col-md-offset-3" id="form_container">
        <h2>Contact Us</h2>
        <p>
           Please send your message below. We will get back to you at the earliest!
        </p>
        <form action="./Home" role="form" method="post" id="reused_form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="name">
                        Subject:</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="message">
                        Message:</label>
                    <textarea class="form-control" type="textarea" name="message" id="message" maxlength="6000" rows="7"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="name">
                        Your Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="email">
                        Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <br>
            <div class="row">
                <label for="upload">
                        Upload image from local storage:</label>
                  <input type="file" name="attach[]" multiple>
            </div>
            <br>
            <div class="row">
                <label for="upload">
                        Insert image URL:</label>
                  <input type="text" name="url">
            </div>
            
            <div class="row">
                <div class="col-sm-12 form-group">
                    <button type="submit" class="btn btn-lg btn-default pull-right" >Send →</button>
                </div>
            </div>

        </form>
        <?php if(session()->get('status')) { ?>
        <div id="success_message" style="width:100%; height:100%;  ">
            <h3><?php echo session()->get('status'); } ?></h3>
        </div>
       
    </div>
</div>
<br>
<a href="<?="Home/printpdf" ?>" class="btn btn-primary">Print PDF</a>​

</body>
</html>