angular.module('app.directives')
    .directive('projectFileDownload',
        ['$resource', 'appConfig', 'ProjectFile', function ($resource, appConfig, ProjectFile) {
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
                link: function(scope, element, attr) {

                },
                controller: ['$scope', '$element', '$attrs', '$timeout', function($scope, $element, $attrs, $timeout) {
                    $scope.downloadFile = function() {
                        var anchor = $element.children()[0];

                        $(anchor).addClass('disabled').text('Loading');

                        ProjectFile.download({id: $attrs.idProject, idFile: $attrs.idFile}, function(data) {
                            $(anchor)
                                .removeClass('disabled')
                                .text('Save File')
                                .attr({
                                    href: 'data:application-octet-stream;base64,' + data.file,
                                    download: data.name
                                });
                            $timeout(function() {
                                $scope.downloadFile = function() {};
                                
                                $(anchor)[0].click();
                            });
                        });
                    };
                }]
            };
        }]
    );

