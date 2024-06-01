var app = angular.module('myApp', []);
//Angular Navbar for technologies demo.
app.controller('TabController', function($scope) {
    $scope.currentTab = 'TeacherRecord';
    $scope.changeTab = function(tabId) {
        $scope.currentTab = tabId;
    };
});

//jQuery search bar for every tab inside Navbar. 
$(document).ready(function(){
    $("#searchButton").click(function(){
        var value = $("#searchInput").val().toLowerCase();
        $("#teacherTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});