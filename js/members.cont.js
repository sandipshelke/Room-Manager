myApp.config(function($stateProvider,$locationProvider,$urlRouterProvider) {
     $stateProvider.state('members',{
         url:'/members',
          views:{
                '': {  templateUrl: "Templates/members/memberh.html",
                       controller:"memHomeController" }          
         }
     }).state('members.addmem',{
         url:'/add',
         views:{
              'childmain@members': {     templateUrl: "Templates/members/addmem.html",
                                        controller:"addmemController"  }       
         }
     }).state('members.allmem',{
         url:'/all',
         views:{
              'childmain@members': {     templateUrl: "Templates/members/getmem.html",
                                        controller:"getmemController"  }       
         }
     }).state('members.remmem',{
         url:'/remove',
         views:{
              'childmain@members': {     templateUrl: "Templates/members/removemem.html",
                                        controller:"remmemController"  }       
         }
     })
     $locationProvider.html5Mode(true);
     })
        .controller("memHomeController", function ($scope,$GetRequestedData) {
               $scope.response=$GetRequestedData.processRequest("POST","php/group/grpHomeCont.php")      
          }) 
        .controller("addmemController", function ($scope,$http,$timeout) {
            $scope.setActionId=function(GroupId) {
               $scope.groupId=GroupId;
             }
            $scope.getGroups=function(){
                $scope.showMember=false;
                    $http({
                                method : "GET",
                                url : "php/group/activegroups.php"
                            })
                            .then(function mySuccess(response) {
                                $scope.Groups = response.data.ActiveList;
                            }, function myError(response) {
                                $scope.error = response.statusText;
                            });
             }
            $scope.AddMember=function(){
                  $http({
                                method : "POST",
                                url : "php/session/adduser.php",
                                data: {GroupId:$scope.groupId, fname:$scope.fname,email:$scope.email }
                            }).then(function mySuccess(response) {
                                Materialize.toast(response.data.Message, 2000);
                            }, function myError(response) {
                                Materialize.toast(response.data.Message, 2000);
                            });
                        }
                          
         })
        .controller("getmemController", function ($scope,$http,$timeout) {
            $scope.isResLoaded=false;
            $scope.setActionId=function(GroupId) {
               $scope.groupId=GroupId;
             }
            $scope.getGroups=function(){
                $scope.showMember=false;
                    $http({
                                method : "GET",
                                url : "php/group/activegroups.php"
                            })
                            .then(function mySuccess(response) {
                                $scope.Groups = response.data.ActiveList;
                            }, function myError(response) {
                                $scope.error = response.statusText;
                            });
             }
            $scope.GetMember=function(){
                  $http({
                                method : "POST",
                                url : "php/members/getmembers.php",
                                data: {GroupId:$scope.groupId}
                            }).then(function mySuccess(response) {
                                $scope.Users=response.data.MemberList;
                                $scope.isResLoaded=true;
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);
                            });
                        }
            $scope.updateMember=function()
            { }         
         })
        .controller("remmemController", function ($scope,$http,$timeout) {
            $scope.setActionId=function(GroupId) {
               $scope.groupId=GroupId;
             }
            $scope.getGroups=function(){
                $scope.showMember=false;
                    $http({
                                method : "GET",
                                url : "php/group/activegroups.php"
                            })
                            .then(function mySuccess(response) {
                                $scope.Groups = response.data.ActiveList;
                            }, function myError(response) {
                                $scope.error = response.statusText;
                            });
             }
            $scope.GetMember=function(){
                  $http({
                                method : "POST",
                                url : "php/members/getmembers.php",
                                data: {GroupId:$scope.groupId}
                            }).then(function mySuccess(response) {
                                $scope.Users=response.data.MemberList;
                                $scope.isResLoaded=true;
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);
                            });
                        }
            $scope.RemoveMember=function(){
                  $http({
                                method : "POST",
                                url : "php/members/removemem.php",
                                data: {MemberId:$scope.groupId}
                            }).then(function mySuccess(response) {
                                Materialize.toast(response.data.Message, 2000);
                                var index = $scope.Users.indexOf($scope.groupId);
                                $scope.Users.splice(index, 1);
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);
                            });
                        }
                          
         });