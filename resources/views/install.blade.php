<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("fonts/icomoon/style.css") }}">

    <link rel="stylesheet" href="{{ asset("css/owl.carousel.min.css") }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">

    <title>Login #2</title>
  </head>
  <body>


  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('https://ontop.vn/wp-content/uploads/2021/03/cover-ontop.vn-Notability-Feature-1536x864.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-9">
            <h3>Login to </h3>
            <p class="mb-4">Please enter your Shopify URL</p>
            <form action="{{ URL::to('/install') }}" method="post">
                @csrf
              <div class="form-group first">
                <input name="store_merchant" style="width: 25rem;" type="text" class="form-control" placeholder="Store name ..." size="5">
                <div style="right: 15px;
                        width: fit-content;
                        position: absolute;
                        top: 90px;
                    }" class="form-control"><p style="
                        margin-top: 10px;
                        color:black;
                        font-weight:600;
                    ">.myshopify.com</p>
                </div>
              </div>


              <input type="submit" value="Log In" class="btn btn-block btn-primary">
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>



    <script src="{{ asset("js/jquery-3.3.1.min.js") }}"></script>
    <script src="{{ asset("js/popper.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("js/main.js") }}"></script>
  </body>
</html>
