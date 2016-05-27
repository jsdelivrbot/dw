
<html>
  <head>
    <title>Classificação de Restaurantes</title>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-route.js"></script>
    <script src="js/app.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body ng-app="app">
    <div id='main' class="container">
      <nav class="navbar-fluid navbar-default navbar-fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#"> Chirp! </a>
          <p class="navbar-text"> Learn the MEAN stack by building this tiny app</p>
          <p class="navbar-right navbar-text"><a href="#/login">Login</a> or <a href="#/register">Register</a></p>
        </div>
      </nav>
      <div class="col-md-offset-2 col-md-8">
        <div ng-view>
        </div>
      </div>
    </div>
  </body>
</html>
