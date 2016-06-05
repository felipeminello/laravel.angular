angular.module('app.controllers')
    .controller('ProjectFileNewController',
        [
            '$scope', '$location', '$routeParams', 'appConfig', 'Url', 'ProjectFile', 'Project', 'Upload',
            function ($scope, $location, $routeParams, appConfig, Url, ProjectFile, Project, Upload) {
            
        $scope.projectFile = new ProjectFile();
        $scope.projectFile.project_id = $routeParams.id;

        $scope.project = Project.get({id: $routeParams.id});

        $scope.projects = Project.query();

        var url = appConfig.baseUrl + Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
                        id: $routeParams.id,
                        idFile: ''
                    });

        $scope.save = function () {
            if ($scope.form.$valid) {

                

                Upload.upload({
                    url: url,
                    data: {
                        name: $scope.projectFile.name,
                        description: $scope.projectFile.description,
                        file: $scope.projectFile.file
                    }

                }).then(function (resp) {
                    console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);

                    $location.path(Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
                        id: $routeParams.id,
                        idFile: ''
                    }));
                }, function (resp) {
                    console.log('Error status: ' + resp.status);
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                });

/*
                $scope.projectFile.$save({id: $routeParams.id}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/files');
                });
*/
            }
        }
    }]);