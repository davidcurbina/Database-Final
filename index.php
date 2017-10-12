<html>
<head>
    <title>
        CINEPHILIA
    </title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=init"></script>
    
</head>
<body>
    <div class="col-lg-12 col-sm-12">
        <div class="card hovercard" style="margin-top:0px">
            <div class="card-background">
                <img class="card-bkimg" alt="" src="bgImage.png">
            </div>
            <div class="useravatar">
            </div>
            <div class="card-info"> <h1 style="font-family:-webkit-pictograph;font-weight:500;color:white;font-size:80">CINEPHILIA</h1>
            </div>
        </div>
        <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" id="popular" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <div class="hidden-xs">Most Popular</div>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" id="directors" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
                    <div class="hidden-xs">Top Directors</div>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" id="actors" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    <div class="hidden-xs">Top Actors</div>
                </button>
            </div>
             <div class="btn-group" role="group">
                <button type="button" id="search" class="btn btn-default" href="#tab4" data-toggle="tab"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <div class="hidden-xs">Search</div>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" id="genres" class="btn btn-default" href="#tab5" data-toggle="tab"><span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                    <div class="hidden-xs">Genres</div>
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" id="timeline" class="btn btn-default" href="#tab6" data-toggle="tab"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                    <div class="hidden-xs">User Timeline</div>
                </button>
            </div>
        </div>
        <div style="padding:5px;">
            Items to Display: <input id="itemsDisplayed" type="text" value="10"/><button id="limitBtn" class="btn-danger">Submit</button>
        </div>
        <div class="well">
            <h1 id="limitNumber"></h1>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
            </div>
            <div class="tab-pane fade in" id="tab2">
                
            </div>
            <div class="tab-pane fade in" id="tab3">
                <div style="padding:5px;">
                    Minimum Movies: <input id="minMoviesA" type="text" value="10"/><button id="limitBtn" class="btn-danger">Submit</button>
                </div>
            </div>
            <div class="tab-pane fade in" id="tab4">
                <div class="container">
                    <div class="dropdown" style="margin-top:0px;float:left;">
                        <button id="filterBtn" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Filter By:
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a onclick="setSearch('tag')">Tags</a></li>
                            <li><a onclick="setSearch('title')">Title</a></li>
                            <li><a onclick="setSearch('director')">Director</a></li>
                            <li><a onclick="setSearch('actor')">Actor</a></li>
                        </ul>
                    </div>
                    <h3 id="filterText" style="margin-top:10px; float:left;padding-left:5px;display:none"></h3>
                    
                    <div class="form-group"  style="width:50%; float:left; margin-right:10px">
                      <input id ="searchTerm" type="text" class="form-control">
                    </div>
                    <button id ="searchBtn" class="btn btn-default">Search</button>
                    
                    <div id="searchResults">
                        
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="tab5">
                <div class="container">
                    <?php
                        $servername = "localhost:8889";
                        $username = "admin";
                        $password = "admin";
                        $database = "moviedatabase";

                        //ini_set('display_errors', 1);
                        //ini_set('display_startup_errors', 1);
                        //error_reporting(E_ALL);

                        // Create connection
                        $mysqli = new mysqli($servername, $username, $password,$database);
                        mysqli_set_charset( $mysqli, 'utf8');
                        // Check connection
                        if ($mysqli->connect_error) {
                            die("Connection failed: ");
                        } else {
                            //echo "Connection Successful\n";
                        }

                    $genreResults = $mysqli->query("select distinct genre from movie_genres;");
                    if (!$genreResults) {
                        echo "Error Connecting";
                    } else {
                        while ($Row = $genreResults->fetch_assoc()) {
                            echo "<div><a href=\"javascript:;\" onclick= \"searchGenre('".rtrim($Row["genre"])."')\"><h2 style=\"background:dimgrey;width:31%;color:white;float:left;margin-right:20px; padding:20px;\">".$Row["genre"]."</h2></div></a>";
                        }
                    }
                    ?>
                    <div id="genreResults">
                    </div>
                </div>
              </div>
              <div class="tab-pane fade in" id="tab6">
                <div style="padding:5px;">
                    User ID: <input id="userID" type="text" value=""/>
                </div>
                <div id="userData">
                </div>
            </div>
          </div>
     </div>
</body>
</html>