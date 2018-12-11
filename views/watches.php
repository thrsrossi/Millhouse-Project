<?php
session_start();
include '../classes/call.php';
if(!$user->isLoggedIn()) {
  $user->redirect('login.php');
}
?>

<?php include '../includes/head.php'; ?>
<body>
  <?php include '../includes/header.php'; ?>

  <main class="container-fluid">
    <div class="row justify-content-center">

         <section class="col-12 col-md-9 blogpost-section">

          <div class="row mr-0 ml-0">

            <div class="col-12 card-columns count pr-0 pl-0">
      
           <?php

           /* NUMBER OF POSTS DISPLAYED IN MAIN BLOG */

           $number_of_posts = 12;
           $category_id = 1;
           $category_posts = $posts->getLatestCategoryPosts($category_id, $number_of_posts);
           include '../includes/views_foreach.php'; ?>
           </div>
          </div>
         </section>

         <!-- ASIDE SECTION WITH ARTICLE CATERGORIES -->

         <aside class="col-12 col-md-3 index-sidebar">

          <?php include '../includes/index_sidebar_blog_posts.php'; ?>

        </aside>

      </div>

</main>

<?php include '../includes/footer.php'; ?>

<?php include '../includes/javascript_tag.php'; ?>

</body>

</html>
