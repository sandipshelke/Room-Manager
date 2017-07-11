var app = angular.module('myApp', []);
app.directive('contenteditable', function() {
    return {
      restrict: 'A',
      require: '?ngModel',
      link: function(scope, element, attr, ngModel) {
        var read;
        if (!ngModel) {
          return;
        }
        ngModel.$render = function() {
          return element.html(ngModel.$viewValue);
        };
        element.bind('blur', function() {
          if (ngModel.$viewValue !== $.trim(element.html())) {
            return scope.$apply(read);
          }
        });
        return read = function() {
          console.log("read()");
          return ngModel.$setViewValue($.trim(element.html()));
        };
      }
   };
});
app.controller('LoginController', function($scope, $http,$location,$timeout) {
    //$scope.PassValidation='((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20})';
    $scope.LoginState="Login";

    $scope.signUp=function() {
        $scope.LoginState="Logging in...";
        $http({
            method: 'POST',
            url: 'php/session/validateuser.php',
             data: { uname: $scope.username ,upass: $scope.password }
            }).then(function successCallback(response) {
                window.location.href = response.data;
            }, function errorCallback(response) {
                Materialize.toast(response.data, 4000);
                 $scope.LoginState="Try again";
            });
       };

       $scope.showHidePassword=function(){
           if($scope.inputType=='password')
               $scope.inputType='text';
           else
              $scope.inputType='password';
       }
       
});

app.controller('RegisterController', function($scope, $http,$location,$timeout) {
    $scope.RegistrationState="Sign-Up";
    $scope.RegisterUser=function() {
        $scope.RegistrationState="Signing..";
        $http({
             method: 'POST',
             url: 'php/session/adduser.php',
             data: { fname: $scope.name,email: $scope.email }
            }).then(function successCallback(response) {
                  Materialize.toast(response.data.Message, 4000);
                  $scope.RegistrationState="Registered"
            }, function errorCallback(response) {
                 Materialize.toast(response.data.Message, 4000);
                 $scope.RegistrationState="Try again"
            });
           
       };
});

app.controller('AddUInfoController', function($scope, $http,$window,$timeout) {
    $scope.MobileNoPatt="^[0-9]{10}";
    $scope.UpdUserInfo=function() {
   $http({
             method: 'POST',
             url: 'php/profile/upduserinfo.php',
             data: { Bdate: $scope.birthDate,Address: $scope.address,Mobile:$scope.mobile,Profession:$scope.profession,AboutMe:$scope.aboutMe,Gender:$scope.gender }
            }).then(function successCallback(response) {
                  Materialize.toast(response.data.Message, 1000);
                  $timeout(function(){$window.location.href = '/Profile.html'},1200);
            }, function errorCallback(response) {
                 Materialize.toast(response.data.Message, 4000)
            });
           
       };
})

app.controller('ProfileController', function($scope, $http) {
    $scope.GetUserInfo=function() {
        $http({
             method: 'GET',
             url: 'php/profile/userprofile.php',
            }).then(function successCallback(response) {
                  $scope.userInfo=response.data;
            }, function errorCallback(response) {
                 Materialize.toast(response.data.Message, 4000)
            });
           
       };
    $scope.UpdUserInfo=function() {
       var obj = {};
       var divItem= $("#Name").siblings();
        for (var i = 0; i < divItem.length; i++) {
            var value = divItem[i].innerHTML;
            var key=divItem[i].id;
            obj[key] = value;
        }
        
        $http({
             method: 'POST',
             url: 'php/profile/upduserinfo.php',
             data:JSON.stringify(obj)
            }).then(function successCallback(response) {
                  Materialize.toast(response.data.Message, 2000)
            }, function errorCallback(response) {
                 Materialize.toast(response.data.Message, 2000)
            });
           
       };
});