var URL = "http://devaslab.com";

app.controller('IncidenteController', function(dataFactory, $scope, $http) {
 
    $scope.form = {};
    $scope.data = [];
    $scope.totalItems = 0;
    $scope.currentPage = 1;

    function getResultsPage(pageNumber) {
        dataFactory.httpRequest(URL + '/api/public/incidentes/pagina/' + pageNumber).then(function(data) {
            $scope.data = data.data;
            $scope.totalItems = data.total;
        });
    }

    getResultsPage(1);

    $scope.pageChanged = function(newPage) {
        $scope.currentPage = newPage;
        getResultsPage(newPage);
    };

    $scope.add = function() {
        $scope.form = {};
        angular.element('#add-data').modal('show');
    };

    $scope.saveAdd = function() {
        dataFactory.httpRequest(URL + '/api/public/incidentes', 'POST', {}, $scope.form).then(function(data) {
            $scope.data.push(data.data);
            $scope.totalItems = data.total;
            $scope.addItem.$setUntouched();
            angular.element('#add-data').modal('hide');
        });
    };

    $scope.edit = function(id) {
        dataFactory.httpRequest(URL + '/api/public/incidentes/' + id).then(function(data) {
            $scope.form = data;
            angular.element('#edit-data').modal('show');
        });
    };

    $scope.saveEdit = function() {
        dataFactory.httpRequest(URL + '/api/public/incidentes/' + $scope.form.id, 'PUT', {}, $scope.form).then(function(data) {
            angular.element('#edit-data').modal('hide');
            $scope.data = helperModifyTable($scope.data, data.id, data);
        });
    };

    $scope.remove = function(item, index) {
        var modal_delete = angular.element('#delete-data');
        
        modal_delete.data('id', item.id);
        modal_delete.data('index', index);
        modal_delete.modal('show');

        console.log($scope.currentPage);
    };

    $scope.removeAction = function() {
        var modal_delete = angular.element('#delete-data'),
            id = modal_delete.data('id'),
            index = modal_delete.data('index');

        dataFactory.httpRequest(URL + '/api/public/incidentes/' + id, 'DELETE').then(function(data) {
            $scope.data.splice(index, 1);
            $scope.totalItems = data.total;
            
            modal_delete.modal('hide');

            getResultsPage($scope.currentPage);
        });
    };
   
});