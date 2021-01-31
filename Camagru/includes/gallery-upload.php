<?php 
if (isset($_POST['submit'])){
    $newFileName = $_POST['filename'];
    if ($_POST['filename']){
        $newFileName = "gallery";
    }else {
        $newFileName = strtolower(str-replace(" ", "-", $newFileName));
    }
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedisc'];

    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    $fileExt = explode(".", $fileName);
    $fileActulExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActulExt, $allowed)){
        if ($fileError === 0){
            if ($fileSize > 2000000){
                $imageFullName = $newFileName . "." . uniqid("", true). "." . $fileActulExt;
                $fileDestination = "img/gallery/". $imageFullName;

                //connecting to databse
                include_once 'connection/conn.php';

                if (empty($imageTitle) || empty($imageDesc)){
                    header("location: ../gallery.php" );
                    exit();
                }else {
                    //see how many rows in table
                    $sql = "SELECT * from gallery";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0){
                        while ($row->$stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row);
                        }
                    }
                }
            }else {
                echo "file too big!.";
                exit();
            }
        }else {
            echo "You had an error!.";
            exit();
        }
    }else {
        echo "You need to upload a proper file type!.";
        exit();
    }
}
?>