
myApp.config(function($stateProvider,$locationProvider,$urlRouterProvider) {
     $stateProvider.state('expenses',{
         url:'/expenses',
          views:{
                '': {  templateUrl: "Templates/expenses/expensesh.html",
                       controller:"ExpHomeController" }          
         }
     }).state('expenses.getexp',{
         url:'/get',
         views:{
              'childmain@expenses': {     templateUrl: "Templates/expenses/getexp.html",
                                        controller:"GetExpController"  }       
         }
     }).state('expenses.addexp',{
         url:'/add',
         views:{
              'childmain@expenses': {     templateUrl: "Templates/expenses/addexp.html",
                                        controller:"AddExpController"  }       
         }
     }).state('expenses.updexp',{
         url:'/update',
         views:{
              'childmain@expenses': {     templateUrl: "Templates/expenses/updexp.html",
                                        controller:"UpdExpController"  }       
         }
     }).state('expenses.remexp',{
         url:'/remove',
         views:{
              'childmain@expenses': {     templateUrl: "Templates/expenses/remexp.html",
                                        controller:"RemExpController"  }       
         }
     }).state('expenses.comexp',{
         url:'/common',
         views:{
              'childmain@expenses': {     templateUrl: "Templates/expenses/comexp.html",
                                        controller:"ComExpController"  }       
         }
     })
     $locationProvider.html5Mode(true);
     })
        .controller("ExpHomeController", function ($scope,$GetRequestedData) {
               $scope.getBaseExpData=function(){
                  $http({
                                method : "GET",
                                url : "php/expenses/groupbexp.php",
                            }).then(function mySuccess(response) {
                                $scope.expData=response.data.ExpInformation;
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);
                            });
                        }
                          
          }) 
        .controller("AddExpController", function ($scope,$http) {
              $scope.addexpenses=function(){
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
        .controller("UpdExpController", function ($scope,$http) {
              $scope.updexpenses=function(){
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
        .controller("GetExpController", function ($scope,$http) {
              $scope.getExpenses=function(){
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
        .controller("RemExpController", function ($scope,$http) {
              $scope.getExpenses=function(){
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
        .controller("ComExpController", function ($scope,$http) {
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
                            Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);;
                        });
                }
            $scope.GetCommonExpenses=function(monthId){
                $scope.month=monthId;
                  $http({
                                method : "POST",
                                url : "php/expenses/getcomexp.php",
                                data: {MonthId:monthId, GroupId:  $scope.groupId }
                            }).then(function mySuccess(response) {
                                $scope.CExp=response.data.CommonList;
                            }, function myError(response) {
                                Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);
                            });
                        }
                            
            $scope.AddCommonExpenses=function(){
                $http({
                            method : "POST",
                            url : "php/expenses/addcomexp.php",
                            data: {MonthId:$scope.month, GroupId:$scope.groupId,RoomRent:$scope.CExp.RoomRent, LightBill:$scope.CExp.LightBill,Internet:$scope.CExp.Internet}
                        }).then(function mySuccess(response) {
                           Materialize.toast(response.data.Message, 2000);
                        }, function myError(response) {
                            Materialize.toast(response.data.ErrorInfo.ErrorMessage, 2000);
                        });
                  }
                            
          }) 