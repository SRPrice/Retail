var gen = angular.module('gen', []);

gen.filter('classGen', function () {
           return function (item) {
           return item.toClassFilter();
   };
});

gen.controller('GenCtrl', function () {
               this.column = 'Generator';
});



var st = angular.module('St', []);

St.filter('classSt', function () {
           return function (item) {
           return item.toClassFilter();
           };
           });

St.controller('StCtrl', function () {
               this.column = 'State';
               });


var PA = angular.module('PA', []);

PA.filter('classPA', function () {
           return function (item) {
           return item.toClassFilter();
           };
           });

PA.controller('PACtrl', function () {
               this.column = 'ProducingArea';
               });