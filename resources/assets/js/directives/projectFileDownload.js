angular.module('app.directives')
    .directive('projectFileDownload',
        ['$resource', '$timeout', 'appConfig', 'ProjectFile', function ($resource, $timeout, appConfig, ProjectFile) {
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
                link: function (scope, element, attr) {
                    var anchor = element.children()[0];

                    scope.$on('salvar-arquivo', function (event, data) {
                        $(anchor).addClass('disabled').text('Loading');

                        $(anchor)
                            .removeClass('disabled')
                            .text('Save File')
                            .attr({
                                href: 'data:application-octet-stream;base64,' + data.file,
                                download: data.name
                            });
                        $timeout(function () {
                            scope.downloadFile = function () {
                            };

                            $(anchor)[0].click();
                        });
                    });
                },
                controller: ['$scope', '$element', '$attrs', function ($scope, $element, $attrs) {
                    $scope.downloadFile = function () {
                        ProjectFile.download({id: $attrs.idProject, idFile: $attrs.idFile}, function (data) {
                            $scope.$emit('salvar-arquivo', data);
                        });
                    };
                }]
            };
        }]
    );