'use strict';

/**
 * @ngdoc overview
 * @name mioApp
 * @description
 * # mioApp
 *
 * Main module of the application.
 */
angular
  .module('mioApp', [
    'ngAnimate',
    'ngAria',
    'ngCookies',
    'ngMessages',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/titi', {
        templateUrl: 'views/titi.html',
        controller: 'TitiCtrl'
      })
      .when('/pruebba', {
        templateUrl: 'views/prueba.html',
        controller: 'PruebaCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
