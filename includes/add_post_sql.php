<?php
session_start();
// //connecting to database
include '../classes/call.php';

//save input to varible
$title = $_POST["title"];
$description = strip_tags($_POST["description"]);
$user_name = $_SESSION["username"];
$image = $_FILES["image"];
$category = $_POST["category"];
$post_date = date("Y/m/d");



if(empty($title) || empty($description) || empty($image) || empty($category))
{
  header('Location: ../views/add_post.php?error= Fill in all fields, please!');
} else 
  {

    if ((strlen($title)) <= 100) 
    {
      $temporary_location = $image["tmp_name"];
      $new_location = "../images/" . $image["name"];
      $upload_ok = move_uploaded_file($temporary_location, $new_location);

        if($upload_ok)
        {
            $posts->addPost($title, $description, $new_location, $user_name, $category, $post_date);
            // redirect
            $user->redirect('../index.php');
    
        } else
          {
            header('Location: ../views/add_post.php?error= Select a picture, please!');
          }


    } else 
      {
        header('Location: ../views/add_post.php?error= The title cannot be longer than 100 characters, please try again.');
      }
      
}
