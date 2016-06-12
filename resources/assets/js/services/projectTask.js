angular.module('app.services')
    .service('ProjectTask', ['$resource', '$filter', 'Url', 'appConfig', function ($resource, $filter, Url, appConfig) {
        function transformData(data) {
            if (angular.isObject(data) && data.hasOwnProperty('due_date')) {
                var o = angular.copy(data);

                o.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd HH:mm:ss');
                o.start_date = $filter('date')(data.start_date, 'yyyy-MM-dd HH:mm:ss');

                return appConfig.utils.transformRequest(o);
            }

            return data;
        }

        var url = appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectTask);
        return $resource(url, {
                id: '@id',
                idTask: '@idTask'
            },
            {
                get: {
                    method: 'GET',
                    transformResponse: function (data, headers) {
                        var o = appConfig.utils.transformResponse(data, headers);

                        if (angular.isObject(o)) {
                            if (o[0]) {
                                o = o[0];
                            }

                            if (o.hasOwnProperty('due_date'))
                            {
                                var date = o.due_date.substring(0, 10);
                                var arrayDate = date.split('-');

                                var time = o.due_date.substring(11, 19);
                                var arrayTime = time.split(':');

                                o.due_date = new Date(arrayDate[0], (parseInt(arrayDate[1]) - 1), arrayDate[2], arrayTime[0], arrayTime[1], arrayTime[2]);
                            }

                            if (o.hasOwnProperty('start_date'))
                            {
                                var date = o.start_date.substring(0, 10);
                                var arrayDate = date.split('-');

                                var time = o.start_date.substring(11, 19);
                                var arrayTime = time.split(':');

                                o.start_date = new Date(arrayDate[0], (parseInt(arrayDate[1]) - 1), arrayDate[2], arrayTime[0], arrayTime[1], arrayTime[2]);
                            }
                        }

                        return o;
                    }
                },
                update: {
                    method: 'PUT',
                    transformRequest: transformData
                },
                save: {
                    method: 'POST',
                    transformRequest: transformData
                }
            }
        );
    }]);