<!DOCTYPE html>
<html lan="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@ViewData["Title"]</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <style>
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
      display: none !important;
    }
  </style>
</head>


<!--
  INITIALIZE THE APP
  = [ng-app] The name of the AngularJS application to use.
  = [ng-controller] The name of the AngularJS controller function, which handles the model data.
-->
<body ng-app="AuthCodeFlowTutorial">
  <div class="container" ng-controller="ConstituentCtrl" ng-cloak>
    <h1>PHP Authorization Code Flow Tutorial - SKY API</h1>
    <p class="lead">The following is a demonstration of the authorization code flow within SKY API, implemented using <a href="https://secure.php.net/" target="_blank">PHP</a>.</p>
    <div class="content" ng-show="isReady">

      <!--
        LOGIN
        = This section is hidden if the session has NOT been authenticated.
      -->
      <div ng-if="!isAuthenticated">
        <a href="/auth/login" class="btn btn-primary">Log in</a>
      </div>


      <!--
        CONSTITUENT DATA
        = This section is only visible when the session has been authenticated and
        = appropriate constituent data has been returned.
        = AngularJS uses a templating engine similar to HandlebarsJS to output model data.
      -->
      <div ng-if="isAuthenticated">
        <div class="well">
          <h3>Constituent: {{ constituent.name }}</h3>
          <p>
            See <a href="https://developer.sky.blackbaud.com/constituent-entity-reference#Constituent" target="_blank">Constituent</a>
            within the Blackbaud SKY API contact reference for a full listing of properties.
          </p>
        </div>
        <p ng-if="::constituent.error" ng-bind="::constituent.error" class="alert alert-danger"></p>
        <div ng-if="::constituent.id" class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Key</th>
                <th>Value</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>id</td>
                <td>{{ constituent.id }}</td>
              </tr>
              <tr>
                <td>type</td>
                <td>{{ constituent.type }}</td>
              </tr>
              <tr>
                <td>lookup_id</td>
                <td>{{ constituent.lookup_id }}</td>
              </tr>
              <tr>
                <td>first</td>
                <td>{{ constituent.first }}</td>
              </tr>
              <tr>
                <td>last</td>
                <td>{{ constituent.last }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p>
          <button ng-click="logout()" class="btn btn-primary">Log out</button>
          <button ng-click="refreshToken()" class="btn btn-primary">Refresh Access Token</button>
        </p>
        <div ng-if="tokenResponse">
          <h4>Token Response:</h4>
          <pre ng-bind="tokenResponse | json"></pre>
        </div>
      </div>
    </div>


    <div class="lead" ng-hide="isReady">Loading...</div>
  </div>

  <!--
    SCRIPTS
    = Data is retrieved from Sky API via an AngularJS application.
  -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
  <script>
      (function (angular) {
          'use strict';

          angular.module('AuthCodeFlowTutorial', [])
              .controller('ConstituentCtrl', function ($scope, $http) {

                  // Check user access token.
                  $http.get('/auth/authenticated').then(function (res) {
                      $scope.isAuthenticated = res.data.authenticated;
                      if ($scope.isAuthenticated === false) {
                          $scope.isReady = true;
                          return;
                      }

                      // Access token is valid. Fetch constituent record.
                      $http.get('/api/constituents/280').then(function (res) {
                          $scope.constituent = res.data.constituent;
                          $scope.isReady = true;
                      });
                  });

                  $scope.logout = function () {
                    $http.post('/auth/logout').then(function(res) {
                      window.location.reload();
                    })
                  }
                  // Manually refresh access token.
                  $scope.refreshToken = function () {
                      $http.get('/auth/refresh-token').then(function (res) {
                          console.log(res);
                          $scope.tokenResponse = res.data;
                      });
                  };
              });
      })(window.angular);
  </script>
</body>
</html>
