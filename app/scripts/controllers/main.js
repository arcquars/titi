'use strict';

/**
 * @ngdoc function
 * @name mioApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the mioApp
 */
angular.module('mioApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karmaxx'
    ];
  });
