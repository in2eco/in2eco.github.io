<ul id="contact-container">
  <?php $contacts=findContactFromUsername($_GET["username"]);
    foreach ($contacts as $key=>$contact):
      if($key=="instagram" && isset($contact) && $contact!=''):
        echo "<li><a href='https://www.instagram.com/".$contact."'><img class='logo' src='files/logo/instagram.png'></a></li>";
      elseif($key=="telegram" && isset($contact) && $contact!=''):
        echo "<li><a href='https://t.me/".$contact."'><img class='logo' src='files/logo/telegram.png'></a></li>";
      elseif($key=="email" && isset($contact) && $contact!=''):
        echo "<li><a href='mailto:".$contact."'><img class='logo' src='files/logo/email.png'></a></li>";
      elseif($key=="whatsapp" && isset($contact) && $contact!=''):
        echo "<li><a href='https://wa.me/".$contact."'><img class='logo' src='files/logo/whatsapp.png'></a></li>";
      endif;
    endforeach;
  ?>
</ul>
<button id="update-contact-button" onclick="showContactForm()">Update Contact</button>
<!-- FORM FOR UPDATING CONTACT -->
<div id="contact-form-container" style="display:none;">
    <form id="contact-form" method="POST">
        <input type="hidden" name="contact-action" id="contact-action">
        <label>Instagram <input id="form-instagram-contact" type="text" name="instagram" placeholder="nomadlife"></label><br>
        <label>Telegram <input id="form-telegram-contact" type="text" name="telegram" placeholder="nomadlife"></label><br>
        <label>Email <input id="form-email-contact" type="text" name="email" placeholder="name@example.com"></label><br>
        <label>Whatsapp <input id="form-whatsapp-contact" type="text" name="whatsapp" placeholder="91987654321"></label><br>
        <button type="submit">Save</button>
        <button type="button" onclick="hideContactForm()">Cancel</button>
    </form>
</div>
<script>
  function showContactForm(){
    $('#contact-form-container').show();
    <?php $contact = findContactFromUsername($_GET["username"]);?>
    $('#form-instagram-contact').val("<?=$contact["instagram"]?>");
    $('#form-email-contact').val("<?=$contact["email"]?>");
    $('#form-telegram-contact').val("<?=$contact["telegram"]?>");
    $('#form-whatsapp-contact').val("<?=$contact["whatsapp"]?>");
    $('#contact-action').val("update");
  }
  function hideContactForm()
  {
    $('#contact-form-container').hide();
  }
</script>
