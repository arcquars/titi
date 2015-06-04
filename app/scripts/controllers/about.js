'use strict';

/**
 * @ngdoc function
 * @name mioApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the mioApp
 */
angular.module('mioApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
