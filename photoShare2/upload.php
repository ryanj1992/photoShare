<?php
session_start();
include_once '../dbconnect.php';

$id = "?id=" . $_SESSION['userSession'];
$id2 = $_SESSION['userSession'];
$price = strip_tags($_POST['price']);
$metaData = strip_tags($_POST['metaData']);


use Aws\S3\Exception\S3Exception;

require 'app/start.php';

if (isset($_FILES['file'])) {

    $file = $_FILES['file'];

    // File Details
    $name = $file['name'];
    $tmp_name = $file['tmp_name'];

    $extension = explode('.', $name);
    $extension = strtolower(end($extension));

    // Temp Details
    $key = md5(uniqid());
    $tmp_file_name = "{$key}.{$extension}";
    $tmp_file_path = "files/{$tmp_file_name}";

    if ((($extension == "gif")
            || ($extension == "jpeg")
            || ($extension == "jpg")
            || ($extension == "png")))
    {
        move_uploaded_file($tmp_name, $tmp_file_path);

        try {

            $result = $s3->putObject([
                'Bucket' => $config['s3']['bucket'],
                'Key' => "uploads/$id/$name",
                'Body' => fopen($tmp_file_path, 'rb'),
                'ACL' => 'public-read'
            ]);

            //Remove Files
            unlink($tmp_file_path);

        } catch (S3Exception $e) {
            die ("There was an error uploading that file");
        }
        $url = $result['ObjectURL'];
        $sql = "INSERT INTO photos (imageURL, user_id, title, price, metaData)
                VALUES ('$url', '$id2', '$name', '$price', '$metaData')";

        if (mysqli_query($DBcon, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($DBcon);
        }

        mysqli_close($DBcon);

        header("location:../profile.php$id");
    } else {
        //Incorrect format error message
        echo "<h1>Invaild Format, Please go back and try again!</h1>";
    }
}

?>
