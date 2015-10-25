angular.module('redditApp', [])

    .controller('forhireController', function ($scope, $http) {
        $http.get('getcontent.php').then(function(response){
            $scope.mydata = response.data;
        })
    });