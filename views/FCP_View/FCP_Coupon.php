



  

<div class="fcp-box h-40 sm:h-60 min-h-16 container   pt-100 pb-100 items-center" style="margin:auto;">
      

  <form class="container items-center">

    
    <a href="#" onClick="copyCoupon()" >
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Copy Coupon
    </a>
  </form>
</div>
<div class="h-20 sm:h-24 container mx-auto py-4 flex items-center" id="copied-message" hidden>
    <p class="text-green-500 text-sm opacity-0 transition duration-300 ease-in-out" >Copied!</p>
  </div>


<script>
function copyCoupon() {
  var copyText = document.getElementById("coupon-code-text");
  if (copyText != null) {

    navigator.clipboard.writeText(copyText.textContent);
  }
    document.getElementById("copied-message").hidden = false;
    setTimeout(function() {
      document.getElementById("copied-message").hidden = true;
    }, 2000); // Hide message after 2 seconds
  
}
</script>