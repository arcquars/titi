'use strict';

describe('Controller: TitiCtrl', function () {

  // load the controller's module
  beforeEach(module('mioApp'));

  var TitiCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    TitiCtrl = $controller('TitiCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
