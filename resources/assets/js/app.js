var app = angular.module('app', ['ngRoute', 'angular-oauth2', 'app.controllers', 'app.filters', 'app.services']);

angular.module('app.controllers', ['ngMessages']);
angular.module('app.filters', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', function () {
    var config = {
        baseUrl: 'http://laravel.angular',
        project: {
            status: [
                { value: '1', label: 'Não iniciado' },
                { value: '2', label: 'Iniciado' },
                { value: '3', label: 'Concluído' }
            ]
        },
        utils: {
            transformResponse: function (data, headers) {
                var headersGetter = headers();

                if (headersGetter['content-type'] == 'application/json') {
                    var dataJson = JSON.parse(data);

                    if (dataJson.hasOwnProperty('data')) {
                        dataJson = dataJson.data;
                    }

                    return dataJson;
                }

                return data;
            }
        }
    };

    return {
        config: config,
        $get: function () {
            return config;
        }
    }
});

app.config(['$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider', function ($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

    $routeProvider
        .when('/login', {
            templateUrl: 'build/views/login.html',
            controller: 'LoginController'
        })
        .when('/home', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeController'
        })
        .when('/clients', {
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListController'
        })
        .when('/clients/new', {
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewController'
        })
        .when('/clients/:id/edit', {
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditController'
        })
        .when('/clients/:id/remove', {
            templateUrl: 'build/views/client/remove.html',
            controller: 'ClientRemoveController'
        })
        .when('/projects', {
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListController'
        })
        .when('/projects/new', {
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewController'
        })
        .when('/projects/:id/edit', {
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditController'
        })
        .when('/projects/:id/remove', {
            templateUrl: 'build/views/project/remove.html',
            controller: 'ProjectRemoveController'
        })
        .when('/project/:id/notes', {
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListController'
        })
        .when('/project/:id/notes/new', {
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewController'
        })
        .when('/project/:id/notes/:idNote/edit', {
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditController'
        })
        .when('/project/:id/notes/:idNote/remove', {
            templateUrl: 'build/views/project-note/remove.html',
            controller: 'ProjectNoteRemoveController'
        })
        .when('/project/:id/notes/:idNote/show', {
            templateUrl: 'build/views/project-note/show.html',
            controller: 'ProjectNoteShowController'
        });

    OAuthProvider.configure({
        baseUrl: appConfigProvider.config.baseUrl,
        clientId: 'appid1',
        clientSecret: 'secret',
        grantPath: 'oauth/access_token'
    });

    OAuthTokenProvider.configure({
        name: 'token',
        options: {
            secure: false
        }
    });

}]);

app.run(['$rootScope', '$window', '$cookieStore', '$http', 'OAuth', function ($rootScope, $window, $cookieStore, $http, OAuth) {
    if ($cookieStore.get('token')) {
        var token = $cookieStore.get('token').access_token;
        $http({
            method: 'GET',
            url: '/user',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }).then(function (response) {
            console.log(response.data);
        });
    }

    $rootScope.$on('oauth:error', function (event, rejection) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('invalid_token' === rejection.data.error) {
            return OAuth.getRefreshToken();
        }

        // Redirect to `/login` with the `error_reason`.
        return $window.location.href = '/auth/login?error_reason=' + rejection.data.error;
    });
}]);