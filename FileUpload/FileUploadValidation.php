
<?php
    // define variables and set to empty values
    $uploadErr = "";
    $uploadErrMsg = "";
    $uploadSucc = "";
    $uploadSuccMsg = "";
    $textErr = "";
    $textSucc = "";
    // store the path to your upload directory in a variable
    $uploadDir = "../news/";
    // check if upload directory already exists
    // if it does not exist
    if(!opendir($uploadDir)){
        // create the directory
        mkdir($uploadDir, 0777, true);
    }

    // Use the global SERVER variable to check if it is a post request
    // and also check if the file with the name in your input element from the form is set
    // The global $_FILES will contain all the uploaded file information. 
    // $_FILES is an associative array of items uploaded to the current script via the HTTP POST method.
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])){
        // store the path where you want to upload the file in a variable as string
        //$uploadFile = $uploadDir;
        //$uploadFile .= $_FILES["fileToUpload"]["name"];
        $uploadFile = $uploadDir . basename($_FILES["fileToUpload"]["name"]);
        // dummy variable to check if upload was successful
        $uploadOk = 1;
        // store the filetype (extension) in a variable
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $_FILES["fileToUpload"]["tmp_name"]);
        if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg') {
            $uploadSuccMsg = 'File type ' . $mimetype . ' is allowed';
            $uploadOk = 1;
        } else {
            $uploadErrMsg = 'The source file type ' . $mimetype . ' is not supported';
            $uploadOk = 0;
        }
        
        // Check if file already exists
        // Returns true if the file or directory specified by the argument exists; false otherwise.
        if(file_exists($uploadFile)){
            $uploadErrMsg = "Sorry, File existiert schon in der Ablage.";
            $uploadOk = 0;
        }
        
        // Check file size
        if($_FILES["fileToUpload"]["size"] > 1500000){
            $uploadErrMsg = "Sorry, Ihr File ist zu groß.";
            $uploadOk = 0;
        }
        
        // Allow only specific file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg"){
            $uploadErrMsg = "Sorry, nur JPG & JPEG Fileformate sind erlaubt.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if($uploadOk == 0){
            $uploadErr = "Sorry, Ihr File wurde nicht hochgeladen.";
        } 
        // if everything is ok, try to upload file
        // use the tmp_name to get the uploaded file
        else {
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadFile)){
                // htmlspecialchars: Certain characters have special significance in HTML, 
                // and should be represented by HTML entities if they are to preserve their meanings. 
                // This function returns a string with these conversions made.
                $uploadSucc = "Der File ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " wurde hochgeladen.";

            } else {
                $uploadErr = "Sorry, es gab einen Fehler als Ihr File hochgeladen wurde.";
            }
        }

        if(empty($_POST["news_text"])){ 
            $textErr = "Text zum Newsbeitrag muss angegeben werden."; 
        } else {
            $text = $_POST["news_text"];
            $textSucc = "Text angenommen.";
        }

        if (!empty($uploadSucc) && !empty($textSucc)) {
            // create thumbnails directory 
            $thumbnailDir = "../thumbnails/";
            // check if thumbnail directory already exists
            // if it does not exist
            if(!opendir($thumbnailDir)){
                // create the directory
                mkdir($thumbnailDir, 0777, true);
            }

            // compute the new sizes
            list($width, $height) = getimagesize($uploadFile);
            $newwidth = 720;
            $newheight = 480;

            // load the picture
            $resized_thumbnail = imagecreatetruecolor($newwidth, $newheight);
            $original = imagecreatefromjpeg($uploadFile);

            // resize the picture
            imagecopyresized($resized_thumbnail, $original, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            // save the image into the thumbnail folder
            $thumbnailFile = $thumbnailDir . basename($_FILES["fileToUpload"]["name"]);
            imagejpeg($resized_thumbnail, $thumbnailFile);

            // free up memory
            imagedestroy($resized_thumbnail);

            
            // after all data is declared to be correct:
            // INSERT into DB with Prepared Statements
            $sql = "INSERT INTO `newsbeitraege` (`user_id`, `text`, `bildpfad`, `timestamp`) VALUES (?, ?, ?, ?)";
            $stmt = $conn -> prepare($sql);

            // Change the line below to your timezone
            date_default_timezone_set('Europe/Berlin');
            $timestamp = date('Y-m-d h:i:s a', time());
            $stmt -> bind_param("isss", $admin_id, $text, $thumbnailFile, $timestamp);

            $stmt -> execute();
            $stmt -> close();
            $conn -> close();
        }
    }
?>


