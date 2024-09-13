<div class="nk-footer">
    <div class="container-fluid">
       <div class="nk-footer-wrap">
          <div class="nk-footer-copyright"> &copy; 2024 The Rock Resorts | All Rights Reserved.</div>
          <div class="nk-footer-links">
             <ul class="nav nav-sm">
                <li class="nav-item dropup">
                   <a href="#" class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                   <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                        <ul class="language-list">
                           <li><a href="#" class="language-item"><span class="language-name">English</span></a></li>
                        </ul>
                   </div>
                </li>
                <li class="nav-item"><a data-bs-toggle="modal" href="#region" class="nav-link"><em class="icon ni ni-globe"></em><span class="ms-1">Select Region</span></a></li>
             </ul>
          </div>
       </div>
    </div>
</div>
</div>
</div>
</div>

<!-- Bundles of Included plugins -->
<script src="{{url('/admin/assets/js/bundle.js')}}"></script>
<script src="{{url('/admin/assets/js/scripts.js')}}"></script>
<script src="{{url('/admin/assets/js/editors.js')}}"></script>
<script src="{{url('/admin/assets/js/charts/chart-hotel.js')}}"></script>

<script>
    // Get the element
    var previousPageLink = document.getElementById('previous-page-link');
    
    // Check if the element exists
    if (previousPageLink) {
        previousPageLink.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior
        
            // Check if the previous page is available in the history stack
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Optionally do nothing or log to console
                console.log("No previous page available.");
            }
        });
    } else {
        // Element does not exist, do nothing or handle as needed
        console.log("Element 'previous-page-link' not found.");
    }

    $(document).ready(function(){
        // Check if there's a success message in the session
        @if(session('success'))
            NioApp.Toast('{{ session('success') }}', 'success', {position: 'top-right', duration: 5000});
        @elseif(session('error'))
            NioApp.Toast('{{ session('error') }}', 'error', {position: 'top-right', duration: 5000});
        @endif

        // Check if there's an error message in the session
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                NioApp.Toast('{{ $error }}', 'error', {position: 'top-right', duration: 5000});
            @endforeach
        @endif
    });
</script>
</body>
</html>
