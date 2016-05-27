angular.module('app.directives')
    .directive('projectFileDownload',
        ['$resource', 'appConfig', 'ProjectFile', function ($resource, appConfig, ProjectFile) {
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
                link: function(scope, element, attr) {

                },
                controller: ['$scope', '$element', '$attrs', function($scope, $element, $attrs) {
                    $scope.downloadFile = function() {
                        var anchor = $element.children()[0];

                        $(anchor).addClass('disabled').text('Loading');

                        ProjectFile.download({id: $attrs.idProject, idFile: $attrs.idFile}, function(data) {

                        })
                    };
                }]
            };
        }]
    );

