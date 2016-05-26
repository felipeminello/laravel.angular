angular.module('app.directives')
    .directive('projectFileDownload',
        ['$resource', 'appConfig', 'ProjectFile', function ($resource, appConfig, ProjectFile) {
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
                link: function(scope, element, attr) {

                },
                controller: ['$scope', '$attrs', function($scope, $attrs) {

                }]
            };
        }]
    );

