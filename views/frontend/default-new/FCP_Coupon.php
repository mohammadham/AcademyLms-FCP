
<div class="flex container grid grid-cols-2">
<div class="flex-auto " id="coupon-code-text"><?php echo $Coupon; ?> </div>
<div class="flex-auto ">
<button class="transition delay-150 duration-300 ease-in-out bg-black hover:bg-white text-white hover:text-black  " onClick=" myFunction()" >Copy Code</button>
</div>

</div>


<script>
function myFunction() {
  // Get the text field
  var copyText = document.getElementById("coupon-code-text");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
} 
</script>