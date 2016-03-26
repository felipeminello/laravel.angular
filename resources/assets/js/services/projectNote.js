angular.module('app.services')
    .service('ProjectNote', ['$resource', 'appConfig', function($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:id/note/:idNote', { id: '@id', idNote: '@idNote' }, {
            update: {
                method: 'PUT'
            },
            query: {
                method: 'GET',
                isArray: true,
                transformResponse: function(data, headers) {
                    var dataJson = JSON.parse(data);

                    dataJson = dataJson.data;

                    return dataJson;
                }
            },
            get: {
                method: 'GET',
                isArray: false,
                transformResponse: function(data, headers) {
                    var dataJson = JSON.parse(data);

                    dataJson = dataJson.data;

                    return dataJson[0];
                }
            }
        });
    }]);