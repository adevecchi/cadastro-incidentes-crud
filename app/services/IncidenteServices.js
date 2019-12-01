app.factory('dataFactory', function($http) {

    var incidenteService = {

        httpRequest: function(url, method, params, dataPost) {

            var promise,
                parameters = {};

            parameters.url = url;

            if (typeof method == 'undefined') {
                parameters.method = 'GET';
            } else {
                parameters.method = method;
            }

            if (typeof params != 'undefined') {
                parameters.params = params;
            }

            if (typeof dataPost != 'undefined') {
                parameters.data = dataPost;
            }

            promise = $http(parameters).then(
                function (response) {
                    return response.data;
                }, 
                function(response) {
                    console.log(response);
                }
            );

            return promise;
        }
    };

    return incidenteService;
});