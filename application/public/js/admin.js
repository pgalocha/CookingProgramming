/**
 * Created by pgalo on 23/01/2017.
 */

app.config(['$routeProvider',function($routeProvider){
    $routeProvider.
    when('/',{controller:'adminController',
        templateUrl:'templates/admin/admin.html'}).
    when('/post',{controller:'postController',
        templateUrl:'templates/admin/post.html'}).
    when('/tag',{controller:'tagController',
        templateUrl:'templates/admin/tag.html'}).
    when('/comment',{controller:'commentController',
        templateUrl:'templates/admin/comment.html'}).
    when('/user',{controller:'userController',
        templateUrl:'templates/admin/user.html'}).
    when('/profile',{controller:'profileController',
        templateUrl:'templates/admin/profile.html'}).
    when('/logout',{controller:'logoutController',
        templateUrl:'templates/logout.html'}).
    otherwise({redirectTo:'/'});
}]);


app.controller('adminController',
    function ($scope,$http,$rootScope,$location) {
        $scope.$on('$viewContentLoaded', function(){
//Verifica se usuário está logado.
            $http.get("/login").then(function(response){
                if (response.data.id){
                    $rootScope.authuser = response.data;
                }else{
                    window.location.assign('index.html');
                }
            },function(response){
                notifyError(response);
            });
        });
    });
app.controller('postController',function ($scope,login) {
    login.check();
});

app.controller('tagController',
    function ($scope,$resource,login) {
       // login.check();
//Título da página
        $scope.title = "Tag";

//Array de objetos
        $scope.rows = null;
//Um objeto
        $scope.row = null;
//Resource Tag
        var Tag = $resource("tags/:id");

        $scope.$on('$viewContentLoaded', function(){
            $scope.loadAll();
        });
        $scope.loadAll = function(){
            $scope.row = null;
            $scope.title = "Tags";
            Tag.query(function(data){
                $scope.rows = data;
            },function(response){
                notifyError(response);
            });
        }
        $scope.getById = function($id){
            Tag.get({id:$id},function(data){
                $scope.title = "Tag: " + data.title;
                $scope.row = data;
            },function(data){
                notifyError(data);
            });
        }
        $scope.createNew = function(){
            $scope.row = {title:""};
        }
        $scope.save = function(){
            if ($scope.form.$invalid) {
                notifyError("Valores inválidos");
                return;
            }
            Tag.save($scope.row,function(data){
                notifyOk(data.title + " salvo com sucesso");
                $scope.loadAll();

            },function(data){
                notifyError(data);
            });
        }
    });
app.controller('commentController',function ($scope) {
    login.check();
//Array de posts
    $scope.posts = null;
//post selecionado
    $scope.post = null;
//Array de objetos
    $scope.rows = null;
//Um objeto
    $scope.row = null;
//Resource
    var Comment = $resource("comments/:id",{},{
        getByPost: {url:'/comments/post/:id',
            method:'GET',isArray:true}
    });
//Resource
    var Post = $resource("posts/:id",{},{
        getTitles: {url:'/posts/getTitles',
            method:'GET',isArray:true}
    });
    $scope.$on('$viewContentLoaded', function(){
        $scope.loadAllPosts();
    });
    $scope.loadAllPosts = function(){
        Post.getTitles(function(data){
            $scope.posts = data;
        });
    }
    $scope.selectPost = function($post){
        $scope.post = $post;
        $scope.row = null;
        Comment.getByPost({id:$post.id},function(data){
            $scope.rows = data;
        });
    }
    $scope.selectComment = function($comment){
        $scope.row = $comment;
    }
    $scope.save = function(){
        if ($scope.form.$invalid) {
            notifyError("Valores inválidos");
            return;
        }
        Comment.save($scope.row,function(data){
            notifyOk("Comentário salvo com sucesso");
            $scope.selectPost($scope.post);
        },function(data){
            notifyError(data);
        });
    }

});
app.controller('userController',function ($scope) {
});
app.controller('profileController',function ($scope) {
});
app.controller('logoutController',function ($scope) {
});
