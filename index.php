<!DOCTYPE html>
<html lang="en" ng-app="redditApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A site to list small software development opportunities from several sources">
    <meta name="author" content="Murrion">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
    <script src="js/app.js"></script>
    <title>DevJobs - A single page app to show small dev opportunities</title>
    <link href="css/template.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Dev Jobs</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

<div class="container" ng-controller="forhireController">

    <div class="container-fluid">

        <div class="row">
            <h1>A list of new software development opportunities from several sources</h1>
        </div>

        <div class="row" ng-repeat="post in mydata |orderBy:'-score'">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><span class="label label-primary">{{post.score}}</span> {{post.title}}
                        <small><a href="http://reddit.com/u/{{post.author}}" target="_blank">{{post.author}}</a> at
                            {{post.created}}
                        </small>
                    </h4>
                </div>
                <div class="panel-body">
                    {{post.text}} <br/>
                    <a href="{{post.url}}" target="_blank" class="btn btn-success btn-xs">Open</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        Developed by
        <a href="https://twitter.com/murrion">@murrion</a> | Source code available on <a
            href="https://github.com/murrion/devjobs.xyz">Github</a>
    </div>

    <br/>

</div>
<!-- container -->

<?php require_once('analytics.php'); ?>
</body>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
      integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
      crossorigin="anonymous">

</html>
