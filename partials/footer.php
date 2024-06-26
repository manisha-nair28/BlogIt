

<!--================== BEGINNING OF FOOTER =====================-->

<footer>
          
          <div class="footer__socials">
              <a href="https://www.youtube.com/channel/UCInpwqGNe3AF_2oQ1VdCXhg" target="_blank">
                  <i class="uil uil-youtube"></i>
              </a>

              <a href="https://github.com/manisha-nair28" target="_blank">
                  <i class="uil uil-github"></i>
              </a>

              <a href="https://x.com/Nisha_ya_?t=SAie2pLcDekffeo_6tFG6A&s=08" target="_blank">
                  <i class="uil uil-twitter"></i>
              </a>

              <a href="https://www.instagram.com/manishaa_nair_/?utm_source=ig_web_button_share_sheet" target="_blank">
                  <i class="uil uil-instagram"></i>
              </a>

              <a href="https://medium.com/@manisha-nair" target="_blank">
                  <i class="uil uil-medium-m"></i>
              </a>

              
              <a href="https://manisha-nair28.github.io/" target="_blank">
                  <i class="uil uil-brackets-curly"></i>
              </a>

          </div>

          <div class="container footer__container">
              
              <article>
                  <h4>Categories</h4>


                  <!-- FETCH TOP 5 CATEGORIES FROM DB -->
                  <?php 
                    $category_query = "SELECT * FROM categories LIMIT 5";
                    $category_result = mysqli_query($connection, $category_query);
                  ?>

                  <ul>
                    <?php while($category_row = mysqli_fetch_assoc($category_result)) : ?>
                      <li>
                        <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category_row['id']?>" >
                            <?=$category_row['title']?>
                        </a>
                    </li>
                    <?php endwhile ?>
                  </ul>
              </article>

              <article>
                  <h4>Support</h4>
                  <ul>
                      <li><a href="">Online Support</a></li>
                      <li><a href="">Call</a></li>
                      <li><a href="">Emails</a></li>
                      <li><a href="">Social Support</a></li>
                      <li><a href="">Location</a></li>
                  </ul>
              </article>

              <article>
                  <h4>Blogs</h4>
                  <ul>
                      <li><a href="">Safety</a></li>
                      <li><a href="">Repair</a></li>
                      <li><a href="<?= ROOT_URL ?>blog.php">Recent</a></li>
                      <li><a href="">Popular</a></li>
                      <li><a href="">Categories</a></li>
                  </ul>
              </article>

              <article>
                  <h4>Permalinks</h4>
                  <ul>
                      <li><a href="<?= ROOT_URL ?>">Home</a></li>
                      <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                      <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                      <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                      <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                  </ul>
              </article>
          </div>

          <div class="footer__copyright">
              <small>&copy; 2024 BlogIt! All Rights Reserved.</small>
          </div>
  </footer>

  <!--================== END OF FOOTER =====================-->

     <script src="<?= ROOT_URL ?>/js/main.js"></script>
</body>
</html>
