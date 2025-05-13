<?php 
// $uploadDirectory = 'uploads/';

// // Create the upload directory if it doesn't exist
// if (!is_dir($uploadDirectory)) {
//     mkdir($uploadDirectory, 0777, true);
// }

// // Check if the file has been uploaded
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imageFile'])) {
//     $file = $_FILES['imageFile'];
//     $fileName = basename($file['name']);
//     $fileTmpName = $file['tmp_name'];
//     $fileSize = $file['size'];
//     $fileError = $file['error'];

//     // Define allowed file types
//     $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
//     // Check if the file type is allowed
//     if (in_array($file['type'], $allowedTypes)) {
//         if ($fileError === 0) {
//             if ($fileSize < 5000000) { // 5 MB limit
//                 $fileDestination = $uploadDirectory . $fileName;

//                 // Move the uploaded file to the destination directory
//                 if (move_uploaded_file($fileTmpName, $fileDestination)) {
//                     echo "File uploaded successfully: <a href='$fileDestination'>$fileName</a>";
//                 } else {
//                     echo "Error moving the file.";
//                 }
//             } else {
//                 echo "File size exceeds the limit of 5 MB.";
//             }
//         } else {
//             echo "Error uploading the file.";
//         }
//     } else {
//         echo "Invalid file type. Only JPG, PNG, and GIF are allowed.";
//     }
// } else {
//     echo "No file uploaded.";
// }

?>