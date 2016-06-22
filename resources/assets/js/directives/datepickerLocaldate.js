angular.module('app.directives')
    .directive('datepickerLocaldate',
        ['$parse', function ($parse) {
            console.log('xxxxxx');
            return {
                restrict: 'A',
                require: ['ngModel'],
                link: function (scope, element, attr, ctrls) {
                    var ngModelController = ctrls[0];

                    console.log('ngModelController ', ngModelController);

                    // called with a JavaScript Date object when picked from the datepicker
                    ngModelController.$parsers.push(function (viewValue) {


                        // undo the timezone adjustment we did during the formatting
                        viewValue.setMinutes(viewValue.getMinutes() - viewValue.getTimezoneOffset());
                        // we just want a local date in ISO format
                        return viewValue.toISOString().substring(0, 10);
                    });

                    // called with a 'yyyy-mm-dd' string to format
                    ngModelController.$formatters.push(function (modelValue) {

                        if (!modelValue) {
                            return undefined;
                        }
                        // date constructor will apply timezone deviations from UTC (i.e. if locale is behind UTC 'dt' will be one day behind)
                        var dt = new Date(modelValue);
                        // 'undo' the timezone offset again (so we end up on the original date again)
                        dt.setMinutes(dt.getMinutes() - dt.getTimezoneOffset());

                        console.log('dt: ', dt);

                        return dt;
                    });
                }
            };
        }]
    );