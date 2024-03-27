



  

<div class="login-box h-40 sm:h-60 min-h-16 container  py-20  items-center">
      
  <h2>Login</h2>
  <form>
  <span></span>
      <span></span>
      <span></span>
      <span></span>
    <div class="user-box">
      <input type="text" name="" required="<?php echo $Coupon; ?>" id="coupon-code-text">
      <label>Coupon</label>
    </div>
    
    <a href="#" onClick="copyCoupon()">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Copy Coupon
    </a>
  </form>
</div>
<div class="h-20 sm:h-24 container mx-auto py-4 flex items-center">
    <p class="text-green-500 text-sm opacity-0 transition duration-300 ease-in-out" id="copied-message">Copied!</p>
  </div>


<script>
function copyCoupon() {
  var copyText = document.getElementById("coupon-code-text");
  navigator.clipboard.writeText(copyText.textContent);
  document.getElementById("copied-message").classList.remove("opacity-0");
  setTimeout(function() {
    document.getElementById("copied-message").classList.add("opacity-0");
  }, 2000); // Hide message after 2 seconds
}
</script>