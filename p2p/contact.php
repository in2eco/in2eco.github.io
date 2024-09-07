<ul id="contact-container">
  <?php $contacts=findContactFromUsername($_GET["username"]);
    foreach ($contacts as $key=>$contact):
      if($key=="instagram" && isset($contact)):
        echo "<li><a href='https://www.instagram.com/".$contact."'><img class='logo' src='files/logo/instagram.png'></a></li>";
      elseif($key=="telegram" && isset($contact)):
        echo "<li><a href='https://t.me/".$contact."'><img class='logo' src='files/logo/telegram.png'></a></li>";
      elseif($key=="email" && isset($contact)):
        echo "<li><a href='mailto:".$contact."'><img class='logo' src='files/logo/email.png'></a></li>";
      elseif($key=="whatsapp" && isset($contact)):
        echo "<li><a href='https://wa.me/".$contact."'><img class='logo' src='files/logo/whatsapp.png'></a></li>";
      endif;
    endforeach;
  ?>
</ul>
