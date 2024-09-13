<footer class="footer -type-1 bg-accent-1 text-white">
    <div class="footer__main">
       <div class="container">
          <div class="footer__grid">
             <div class="">
                <h4 class="text-30 fw-500 text-white">About Us</h4>
                <div class="text-white-60 text-15 lh-17 mt-60 md:mt-20">
                   Discover The Rock Resort on Aur Island,
                   where luxury harmonizes with the untouched
                   splendor of nature's masterpiece.
                </div>
             </div>
             <div class="">
                <h4 class="text-30 fw-500 text-white">Contact</h4>
                <div class="y-gap-15 text-15 text-white-60 mt-60">
                   <div class="">
                      <a class="d-block text-15 " href="#">
                      The Rock Resorts, MY Johor Pulau Aur, Teluk Baai, Aur Island, 86800
                      </a>
                   </div>
                   <div class="">
                      <a class="d-block text-15 " href="#">
                      enquiry@therockresorts.com
                      </a>
                   </div>
                   <div class="">
                      <a class="d-block text-15 " href="#">
                      +61 3 8376 6284
                      </a>
                   </div>
                </div>
             </div>

             <div class="">
                <h4 class="text-30 fw-500 text-white">Links</h4>
                <div class="row x-gap-50 y-gap-15">
                   <div class="col-sm-6">
                      <div class="y-gap-15 text-15 text-white-60 mt-60 md:mt-20">
                         <a class="d-block" href="#">
                         About Rock Resort
                         </a>
                         <a class="d-block" href="#">
                         Our Rooms
                         </a>
                         <a class="d-block" href="#">
                         Restaurant &amp; Bar
                         </a>
                         <a class="d-block" href="#">
                         Spa &amp; Wellness
                         </a>
                         <a class="d-block" href="#">
                         Contact
                         </a>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="y-gap-15 text-15 text-white-60 mt-60 md:mt-20">
                         <a class="d-block" href="#">
                         Privacy Policy
                         </a>
                         <a class="d-block" href="#">
                         Terms &amp; Conditions
                         </a>
                         <a class="d-block" href="#">
                         Get Directions
                         </a>
                      </div>
                   </div>
                </div>
             </div>

             <div class="">
                <h4 class="text-30 fw-500 text-white">Newsletter Sign Up</h4>
                <p class="text-15 text-white-60 mt-60 md:mt-20">Sign up for our news, deals and special offers.</p>
                <div class="footer__newsletter mt-30">
                   <input type="Email" placeholder="Your email address">
                   <button><i class="icon-arrow-right text-white text-20"></i></button>
                </div>
             </div>
          </div>
       </div>
    </div>

    <div class="footer__bottom">
       <div class="container">
          <div class="row y-gap-30 justify-between md:justify-center items-center">
             <div class="col-md-auto">
                <div class="text-15 text-center">Copyright © 2024 The Rock Resort | All rights reserved | Made with ♥ <a target="_blank" href="https://Vynzio.co">Vynzio.co</a></div>
             </div>
             <div class="col-md-auto">
                <div class="footer__bottom_center">
                   <div class="d-flex justify-center">
                      <img src="{{ asset('img/general/logo-white.svg') }}" alt="logo">
                   </div>
                </div>
             </div>
             <div class="col-md-auto">
                <div class="row x-gap-25 y-gap-10 items-center justify-center">
                   <div class="col-auto">
                      <a href="#" class="d-block text-white-60">
                      <i class="icon-facebook text-11"></i>
                      </a>
                   </div>
                   <div class="col-auto">
                      <a href="#" class="d-block text-white-60">
                      <i class="icon-twitter text-11"></i>
                      </a>
                   </div>
                   <div class="col-auto">
                      <a href="#" class="d-block text-white-60">
                      <i class="icon-instagram text-11"></i>
                      </a>
                   </div>
                   <div class="col-auto">
                      <a href="#" class="d-block text-white-60">
                      <i class="icon-linkedin text-11"></i>
                      </a>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</footer>
</main>
<script>
    function showNotification(type, message) {
        const notification = document.getElementById(type + "-notification");
        notification.querySelector("#" + type + "-message").textContent = message;

        // Apply slideInRight animation
        notification.style.animation = "slideInRight 0.5s forwards";

        // Setup to hide the notification after it slides in and stays for a duration
        setTimeout(() => {
            notification.style.animation = "slideOutRight 0.5s forwards";
        }, 5000); // Example: Start hiding after 5 seconds
    }

   // Check for success and error messages in the session
   @if (session('success'))
       showNotification('success', '{{ session('success') }}');
   @endif
   @if (session('error'))
       showNotification('error', '{{ session('error') }}');
   @endif
   // Check for validation errors and display them
   @if($errors->any())
       showNotification('error', '{{ $errors->first() }}');
   @endif
</script>

<!-- JavaScript -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAz77U5XQuEME6TpftaMdX0bBelQxXRlM"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
<script src="{{url('js/dist/markerclusterer.min.js')}}" defer></script>
<script src="{{url('js/vendors.js')}}" defer></script>
<script src="{{url('js/main.js')}}" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the flatpickr input and minimum duration inputs exist
        if (document.querySelector("#checkInCheckOut") && document.getElementById('minDurationDays') && document.getElementById('minDurationNights')) {
            const minDays = parseInt(document.getElementById('minDurationDays').value, 10);
            const minNights = parseInt(document.getElementById('minDurationNights').value, 10);

            flatpickr("#checkInCheckOut", {
                mode: "range",
                minDate: "today",
                dateFormat: "Y-m-d",
                onClose: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        const startDate = selectedDates[0];
                        const endDate = selectedDates[1];
                        const days = Math.ceil((endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end date in the count
                        const nights = days - 1;

                        // Check if the selected range meets the minimum requirements
                        if (days < minDays || nights < minNights) {
                            alert(`Please select a minimum duration of ${minDays} days and ${minNights} nights.`);
                            document.getElementById('checkInCheckOut').value = ''; // Reset the input
                            document.getElementById('daysNights').textContent = '';
                        } else {
                            document.getElementById('daysNights').textContent = `${days} Days, ${nights} Nights`;
                        }
                    }
                }
            });
        } else {
            // If the element or min duration inputs are not found, log a warning in the console
            console.warn("Date picker or minimum duration elements not found!");
        }
    });
    </script>
</body>
</html>
