angular.module('app.controllers')
    .controller('ProjectMemberEditController', ['$scope', '$location', '$routeParams', 'ProjectMember', 'Project', 'User',
        function ($scope, $location, $routeParams, ProjectMember, Project, User) {
        $scope.projectMember = ProjectMember.get({id: $routeParams.id, idMember: $routeParams.idMember}, function(data) {
            // $scope.memberSelected = data.client.data[0];
        });

        $scope.project = Project.get({id: $routeParams.id});

        $scope.save = function () {
            if ($scope.form.$valid) {
                $scope.projectMember.member_id = $scope.memberSelected.id;

                ProjectMember.update({id: $routeParams.id, idMember: $routeParams.idMember}, $scope.projectMember).$promise.then(function (response) {
                    if (response.error === true) {
                        console.log(response.message.status);
                    } else {
                        $location.path('/project/' + $routeParams.id + '/member');
                    }
                }, function(response) {
                    console.log('ERROR ' + response.status + ': ', response.statusText);
                });
            }
        };

        $scope.formatName = function (model) {
            if (model) {
                return model.name;
            }

            return '';
        };

        $scope.getMembers = function (name) {
            return User.query({
                search: name,
                searchFields: 'name:like'
            }).$promise;
        };

        $scope.selectMember = function (item) {
            $scope.project.member_id = item.id;
        };

    }]);