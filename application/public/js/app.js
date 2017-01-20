/**
 * Created by pgalo on 20/01/2017.
 */

var app = new angular.module('app', ['ngRoute']);
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/', {
        controller: 'mainController',
        templateUrl: 'templates/main.html'
    }).when('/usuarios', {
        controller: 'userController',
        templateUrl: 'templates/user.html'
    }).when('/comentarios', {
        controller: 'commentController',
        templateUrl: 'templates/comment.html'
    }).when('/tags', {
        controller: 'tagController',
        templateUrl: 'templates/tag.html'
    }).when('/login', {
        controller: 'loginController',
        templateUrl: 'templates/login.html'
    }).otherwise({redirectTo: '/'});
}]);

//Notificacoes
function notifyOk(message) {
    $('.bottom-right').notify({
        message: {text: message}
    }).show();
}
function notifyError(error) {
    message = "";
    if (error.data != null)
        if (error.data.message != null)
            message += error.data.message;
    if (message == "")
        if (error.statusText != null)
            message = "Error: " + error.statusText;
    if (message == "")
        if (typeof error == "string")
            message = error;
    $('.bottom-right').notify({
        message: {text: message},
        type: 'danger',
    }).show();
    $('#loading').css('display', 'none');
}


app.controller('mainController', function ($scope, $http) {
    $scope.posts = [];
    $scope.$on('$viewContentLoaded', function () {
        $http.get("/posts/last/3").then(function (response) {
            $scope.posts = response.data;
        }, function (response) {
            notifyError(response)
        });
    });
});

app.controller('menuController', function ($scope, $http) {
    $scope.tags = [];
    $scope.comments = [];
    console.log('view');
    $http.get("/menuinfo").then(function (response) {
//console.log(response);
        $scope.tags = response.data[0];
        $scope.comments = response.data[1];
    }, function (response) {
        notifyError(response.statusText);
    });
});

app.config(function($httpProvider) {
    $httpProvider.interceptors.push(
        function($q, $rootScope) {
            return {
                'request': function(config) {
                    $rootScope.$broadcast('loading-started');
                    return config || $q.when(config);
                },
                'response': function(response) {
                    $rootScope.$broadcast('loading-complete');
                    return response || $q.when(response);
                }
            };
        });
});
app.controller('userController',function ($scope,$http) {
    $scope.users = [];
    $scope.$on('$viewContentLoaded', function(){
        $http.get("/users/posts").then(function(response){
            $scope.users = response.data;
        },function(response){
            notifyError(response)
        });
    });
});

app.controller('commentController',function ($scope,$http) {
    $scope.comments = [];
    $scope.$on('$viewContentLoaded', function(){
        $http.get("/comments").then(function(response){
            $scope.comments = response.data;
        },function(response){
            notifyError(response)
        });
    });
});

app.controller('tagController',function ($scope,$http) {
    $scope.tags = [];
    $scope.$on('$viewContentLoaded', function(){
        $http.get("/tags/posts").then(function(response){
            $scope.tags = response.data;
        },function(response){
            notifyError(response)
        });
    });
});
