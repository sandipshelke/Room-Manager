var myApp = angular.module('myApp', ['ui.router','ui.materialize']).config(function($sceProvider) {
     $sceProvider.enabled(true);
});
myApp.factory("$GetRequestedData",function($http){
    return{
        processRequest:function (RequestMethod,PageUrl,RequestData) {
            $http({
                  
                    method : RequestMethod,
                    url : PageUrl,
                    data: {RequestData}
                    }).then(function mySuccess(response) {
                     return response.data;
                    }, function myError(response) {
                    return response.statusText;
               });
        }
    }
});

myApp.config(function($stateProvider,$locationProvider,$urlRouterProvider) {
     $stateProvider.state('group',{
         url:'/group',
          views:{
                '': {  templateUrl: "Templates/group/grouph.html",
                       controller:"grpHomeController" }          
         }
     }).state('group.create',{
         url:'/create',
         views:{
              'childmain@group': {     templateUrl: "Templates/group/creategroup.html",
                                        controller:"createController"  }       
         }
     }).state('group.update',{
         url:'/update',
         views:{
              'childmain@group': {  templateUrl: "Templates/group/updgroup.html",
                                    controller:"updateController" }
         }
     }).state('group.leave',{
         url:'/leave',
         views:{
              'childmain@group': { templateUrl: "Templates/group/leavegrp.html",
                                   controller:"leaveController"  }
         }
     }).state('group.active',{
         url:'/active',
         views:{
              'childmain@group': {  templateUrl: "Templates/group/activegroup.html",
                                    controller:"activeController"   }
         }
     }).state('group.remove',{
         url:'/remove',
         views:{
              'childmain@group': { templateUrl: "Templates/group/removegrp.html",
                                   controller:"removeController"  }
         }
     })
     /*.state('default', {
        controller: 'headerController',
        templateUrl: 'http://www.rmanager.com/rmanager.com/dashboard.html',
        url:''
     })
     $urlRouterProvider.otherwise('/default')*/
     $locationProvider.html5Mode(true);
     })
        .controller("grpHomeController", function ($scope,$GetRequestedData) {
               $scope.response=$GetRequestedData.processRequest("POST","php/group/grpHomeCont.php")      
          }) 
        .controller("createController", function ($scope,$http,$timeout) {
              $scope.createGrp=function(){
                  $http({
                                method : "POST",
                                url : "php/group/creategrp.php",
                                data: { GroupName:$scope.gname,GroupType:$scope.gtype,AdminEmail:$scope.gemail,GroupDisc:$scope.gdisc }
                            }).then(function mySuccess(response) {
                                Materialize.toast(response.data.Message, 2000);
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo, 2000);
                            });
                        }
                            
          }) 
        .controller("updateController", function ($scope,$http) {
     
             $scope.getGroups=function(){
                $http({
                            method : "GET",
                            url : "php/group/activegroups.php",
                        })
                        .then(function mySuccess(response) {
                            $scope.Groups = response.data.ActiveList;
                        }, function myError(response) {
                            $scope.error = response.statusText;
                        });
                }
             $scope.getGroupInfo=function(groupId){
                $scope.GroupToUpdate=groupId;
                $http({
                            method : "POST",
                            url : "php/group/activegroups.php",
                            data: { GroupId:groupId}
                        })
                        .then(function mySuccess(response) {
                            $scope.GroupData = response.data.ActiveList[0];
                        }, function myError(response) {
                            $scope.error = response.statusText;
                        });
                }

             $scope.updateGrp=function(){
                  $http({
                                method : "POST",
                                url : "php/group/updategroup.php",
                                data: {GroupId:$scope.GroupToUpdate,GroupName:$scope.GroupData.GroupName, AdminEmail:$scope.GroupData.AdminEmail,GroupDisc:$scope.GroupData.GroupDisc }
                            }).then(function mySuccess(response) {
                                 Materialize.toast(response.data.Message, 2000);
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo, 2000);
                            });
             }
         }) 

        .controller("leaveController", function ($scope, $http) { 
            $scope.setActionId=function(GroupId) {
               $scope.groupId=GroupId;
            }
            $scope.getGroups=function(){
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
            $scope.removeGroup=function(){
                $http({
                            method : "POST",
                            url : "php/group/leavegroup.php",
                            data: {GroupId:$scope.groupId}
                        })
                        .then(function mySuccess(response) {
                            Materialize.toast(response.data.Message, 2000);
                        }, function myError(response) {
                            Materialize.toast(response.data.ErrorInfo, 2000);
                        });
                 }
         })

        .controller("activeController", function ($scope, $http) { 
                                
          $scope.getGroups=function(){
               $scope.showMember=false;
                $http({
                            method : "GET",
                            url : "php/group/activegroups.php"
                        })
                        .then(function mySuccess(response) {
                            $scope.ActiveList = response.data.ActiveList;
                        }, function myError(response) {
                            Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);;
                        });
                }
          $scope.getMembers=function(SelectedGroupId){
                $scope.showMember=true;
                $http({
                            method : "POST",
                            url : "php/group/getmembers.php",
                            data: { GroupId:SelectedGroupId }
                        })
                        .then(function mySuccess(response) {
                            $scope.Members = response.data.MemberList;
                        }, function myError(response) {
                            $scope.error = response.statusText;
                        });
                }     
                
          })

        .controller("removeController", function ($scope, $http,$timeout) { 
            $scope.setActionId=function(GroupId) {
             $scope.groupId=GroupId;
            }
            $scope.getGroups=function(){
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
            $scope.removeGroup=function(){
                $http({
                            method : "POST",
                            url : "php/group/removegroup.php",
                            data: {GroupId:$scope.groupId}
                        })
                        .then(function mySuccess(response) {
                            Materialize.toast(response.data.Message, 2000);
                            var index = $scope.Groups.indexOf($scope.groupId);
                            $scope.Groups.splice(index, 1);
                        }, function myError(response) {
                            Materialize.toast(response.data.ErrorInfo, 2000);
                        });
                 }
             })                
            
        .controller('headerController',function($scope,$interval) {
         });

