-- <!-- Footer -->
 {{-- footer --}}
 {{-- <footer class="footer">
    <div class="footer-left col-md-4 col-sm-6">
        <h3> mForum</h3> <p class="about"><span>mForum’s mission is to share and grow the world’s knowledge. Not all knowledge can be written down, but much of that which can be, still isn't. It remains in people’s heads or only accessible if you know the right people.</span>
      </p>
    </div>
    <div class="footer-center col-md-4 col-sm-6">
      <div>
        <i class="fa fa-map-marker"></i>
        <p><span>91 spring board, gopala krishna complex
  Pin Code:560025</span> Bengaluru,Karnataka, INDIA</p>
      </div>
      <div>
        <i class="fa fa-phone"></i>
        <p>+91 9716xxxxx,+91 88xxxxxx</p>
      </div>
      <div>
        <i class="fa fa-envelope"></i>
        <p><a href="#"> xxxxxx@gmail.com</a></p>
      </div>
    </div>
    <div class="footer-right col-md-4 col-sm-6">
      <b>mForum</b>
      <p class="menu">
        <a href="project_constr.html"> Home</a>
        <a href="p2ani.html"> About us</a>
        <a href="p2ani.html">Career</a>
        <a href="#">Signup</a>
        <a href="#">Contact us</a>
      </p>
      <p class="name">mForum &Copyrigt: 2022</p>
    </div>
  </footer>
 --}}
 {{-- <section class="container-fluid footer_section" style="text-align: center">
    <p><a href="">mForum</a> | <a href="contact-us">About us</a></p>
    <p>
      Copyright &copy; 2022 All Rights Reserved By
      <a href="https://html.design/">mForum</a>
    </p>
  </section> --}}





    <div style=" position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background: linear-gradient(to left, #4facfe 0%, #00f2fe 100%) !important;

    color: black;
    text-align: center;">
      <p> Copyright &copy; 2022 All Rights Reserved By
        <a href="{{ URL::to('contact-us') }}">mForum</a>
        <span class="float-right" style="margin-right:30px; "><a href="#" style="color: black">contact-us</a> | <a href="#" style="color: black">about-us</a></span>
    </p>
    </div>

  <style>
      footer {
position: fixed;
left: 0;
bottom: 0;
width: 100%;

color: black;
text-align: center;
}
  </style>
  @if (Session::has('status'))
  <script>
      swal("Successfully Question Added!", "Well done", "success")
  </script>
  @endif
  <script type="text/javascript">
      var route = "{{ url('autocomplete-search') }}";
      $('#search').typeahead({
          source: function(query, process) {
              return $.get(route, {
                  query: query
              }, function(data) {
                  return process(data);
              });
          },
          minLength: 3,
          autoSelect: false
      });
  </script>

  <script type="text/javascript">
      $(document).ready(function() {
          let template = null;
          $('.modal').on('show.bs.modal', function(event) {
              template = $(this).html();
          });

          $('.modal').on('hidden.bs.modal', function(e) {
              $(this).html(template);
          });
      });
  </script>

  <script>
      function validateForm() {
          document.getElementById("error").innerHTML = "";
          document.getElementById("err").innerHTML = "";
          let x = document.forms["myForm"]["require"].value;
          let y = document.forms["myForm"]["desc"].value;
          if (x == '') {
              document.getElementById("error").innerHTML = "Field is required";
              return false;
          } else if (y == '') {
              document.getElementById("err").innerHTML = "Field is required";
              return false;
          } else {
              return true;
          }
      }
  </script>

  </body>
  </html>
