<section class="content">
  <h3>View Our Map Location</h3>
  <div id="the_map">
    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=1641+SW+8th+Street,+Miami+FL+33135&amp;sll=35.101934,-95.712891&amp;sspn=57.724754,79.013672&amp;ie=UTF8&amp;hq=&amp;hnear=1641+SW+8th+St,+Miami,+Miami-Dade,+Florida+33135&amp;t=m&amp;z=14&amp;ll=25.765871,-80.221783&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=1641+SW+8th+Street,+Miami+FL+33135&amp;sll=35.101934,-95.712891&amp;sspn=57.724754,79.013672&amp;ie=UTF8&amp;hq=&amp;hnear=1641+SW+8th+St,+Miami,+Miami-Dade,+Florida+33135&amp;t=m&amp;z=14&amp;ll=25.765871,-80.221783" style="color:#0000FF;text-align:left">View Larger Map</a></small>
  </div>
  <div style="clear:both; display:block; height:40px"></div>
  <h3>Please use the form below to get in touch with us.</h3>
  <p>1641 SW 8th Street, Miami FL 33135<br><br>
        Tel: 786-398-9358<br>
        Email: <a href="mailto:info@domainname.com">wildvaporinc@gmail.com</a></p>
  <form action="<?php echo $this->url('/home/contact'); ?>" method="post" id="contact-form" class="contactForm">
    <div id="note">
      <?php
        if (isset($errors) && count($errors)) {
          echo '<div class="checkout_errors">';
          echo '<h4>You have the following errors. Please, check your data and try again.</h4>';
          $i = 0;
          foreach ($errors as $k => $v) {
            $i = $i + 1;
            $str = (is_array($v)) ? implode('|', $v) : $v;
            echo '<span class="dropcap">'.$i.'</span>';
            echo '<p>'.$str.'</p>';
          }
          echo '</div><br />';
        }

        $name = $email = $website = $message = null;
        if (isset($_SESSION['slim.flash']['data']['name'])) { $name = $_SESSION['slim.flash']['data']['name']; }
        if (isset($_SESSION['slim.flash']['data']['email'])) { $email = $_SESSION['slim.flash']['data']['email']; }
        if (isset($_SESSION['slim.flash']['data']['website'])) { $website = $_SESSION['slim.flash']['data']['website']; }
        if (isset($_SESSION['slim.flash']['data']['message'])) { $message = $_SESSION['slim.flash']['data']['message']; }
      ?>
    </div>
    <p>
      <input type="text" name="name" placeholder="Your Name" <?php if (isset($name)) { echo "value=$name"; } ?>>
      &nbsp;
      <input type="text" name="email" placeholder="Your Email" <?php if (isset($email)) { echo "value=$email"; } ?>>
      &nbsp;
      <input type="text" name="website" placeholder="Your Website" <?php if (isset($website)) { echo "value=$website"; } ?>>
    </p>
    <p>
      <textarea name="message" rows="10" cols="20"><?php echo (isset($message)) ? $message : 'Your Message'; ?></textarea>
    </p>
    <p>
      <input type="submit" name="submit" class="submit" value="Send Message">
    </p>
  </form>
</section>

