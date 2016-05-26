angular.module('app.services')
    .service('ProjectFile', ['$resource', 'Url', 'appConfig', function($resource, Url, appConfig) {
        var url = appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectFile);
        return $resource(url, {
            update: {
                method: 'PUT'
            }
        });
    }]);