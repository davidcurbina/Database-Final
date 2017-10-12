<script type="text/javascript">
    function search(term,id){
           // prepare the request
           var request = gapi.client.youtube.search.list({
                part: "snippet",
                type: "video",
                q: term,
                maxResults: 1
           }); 
           // execute the request
           request.execute(function(response) {
              var results = response.result;
               $("#"+id).attr('src', "https://www.youtube.com/embed/"+results.items[0].id.videoId)
             
              
              resetVideoHeight();
           });
    };

    function resetVideoHeight() {
        $(".video").css("height", $("#results").width() * 9/16);
    }
</script>
<?php
    $servername = "localhost:8889";
    $username = "davidcurbina";
    $password = "Jackass2.";
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
?>
<div class="container">
  <?php // Perform queries 
    $var = $_GET["var"];
    $count = $_GET["count"];
    $term = $_GET["term"];
    $qmin = $_GET["qmin"];
    if($var == "popular" || $var == "genre"){
        if($var == "popular"){
            $results = $mysqli->query("CALL GetResults('".$var."',".$count.",NULL,NULL);");
        } else {
            $results = $mysqli->query("CALL GetResults('".$var."',".$count.",'".$term."',NULL);");
            echo "<h2 id=\"resultText\" style=\"width:100%;float:right\">Results for ".$term."</h2>";
        }
        while ($row = $results->fetch_assoc()) {
            if($var == 'genre'){
                echo "<div class=\"row\" style=\"margin-bottom:10px;background:white; float:right;width:100%\">";
            } else {
                echo "<div class=\"row\" style=\"margin-bottom:10px;background:white;width:100%\">";
            }
            echo "
                <img src=\"".$row["RTPic"]."\" style=\"width:10%; float:left\"/>
                <div style=\"float:left; width:60%; padding-left:15px;\">
                    <div style=\"float:left;width:100%\">
                     <h1 style=\"\">".$row["Title"]."</h1>
                     </br>
                     <h3 style=\"margin-top:0px; margin-right:10px; float:left\">Year:</h3>
                     <h3 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Year"]."</h3>
                     <h3 style=\"margin-top:5px; margin-right:10px; float:left\">Audience Score:</h3>
                     <h1 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Audience Score"]."</h1>
                    </div>
                </div>
                <img src=\"".$row["IMDBPic"]."\" style=\"width:10%; float:right\"/>
            </div>";
        } 
    }else{
        if($qmin == ""){
            $qmin = "NULL";
        }
        $results = $mysqli->query("CALL GetResults('".$var."',".$count.",'".$term."',".$qmin.");");
        if($var == "title" || $var=="director" || $var=="actor" || $var=="tag"){
            echo "<h2>Results for ".$term."</h2>";
            $video = 0;
            while ($row = $results->fetch_assoc()) {
                $video++;
                echo "<div class=\"row\" style=\"margin-bottom:10px;background:white;width:100%\">";

                $mysqli2 = new mysqli($servername, $username, $password,$database);
                    echo"
                    <img src=\"".$row["RTPic"]."\" style=\"width:15%; float:left\"/>
                    <div style=\"float:left; width:60%; padding-left:15px;\">
                        <div style=\"float:left;width:100%\">
                   <h1 style=\"\">".$row["Title"]."</h1>
                     </br>
                     <h3 style=\"margin-top:0px; margin-right:10px; float:left\">Year:</h3>
                     <h3 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Year"]."</h3>
                     <h3 style=\"margin-top:5px; margin-right:10px; float:left\">Audience Score:</h3>
                     <h1 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Audience Score"]."</h1>
                    ";
                if($var == "title"){
                    $tagResults = $mysqli2->query("CALL GetResults('tags',NULL,'".$row["Title"]."',NULL);");
                    if (!$tagResults) {
                        echo "Error Connecting";
                    }elseif($tagResults->num_rows == 0){
                        echo "No tags found";
                    } else {
                        echo "<h3 style=\"flaot:left\" \">Tags</h3>";
                        while ($tagRow = $tagResults->fetch_assoc()) {
                            echo $tagRow["tag"].", ";
                        }
                        mysqli_close($mysqli2);
                    }
                     echo"<script type=\"text/javascript\">
                          search('".$row["Title"]." ".$row["Year"]." Official Trailer','video".$video."');
                        </script>
                        <div style=\"background:black;width:100%\">
                            <iframe id=video".$video." width=\"420\" style=\"margin-left:20%;border:0px\" align=\"center\" height=\"315\" src=\"\">
                            </iframe>
                        </div>";
                    $mysqli2 = new mysqli($servername, $username, $password,$database);
                    $recommendationResults = $mysqli2->query("CALL GetResults('recommended',NULL,'".$row["Title"]."',NULL);");
                    if (!$recommendationResults) {
                        echo "Error Connecting";
                    }elseif($recommendationResults->num_rows == 0){
                        echo "No Recommendations found";
                    } else {
                        echo "<h3 style=\"flaot:left\" \">Recommendations</h3>";
                        while ($recRow = $recommendationResults->fetch_assoc()) {
                            echo "<a href=\"javascript:;\" onclick= \"searchTerm('".rtrim($recRow["title"])."')\"><img src=\"".$recRow["imdbPictureURL"]."\" style=\"width:20%; float:left\"/></a>";
                        }
                        mysqli_close($mysqli2);
                    }
                }
                echo"
                        </div>
                    </div>
                    <img src=\"".$row["IMDBPic"]."\" style=\"width:15%; float:right\"/>
                </div>";
            }
        } else if($var == "directors"){
            echo "  <div style=\"padding:5px;\">
                        Minimum Movies: <input id=\"minMoviesD\" type=\"text\" value=\"".$qmin."\"/>
                    </div>";
            while ($row = $results->fetch_assoc()) {
        echo"
                <div class=\"container\" style=\"margin-bottom:10px;background:white;width:100%\">
                <div style=\"float:left;width:100%\">
                 <h2 style=\"\">".$row["DirectorName"]."</h2>
                 <h4 style=\"margin-top:5px; margin-right:10px; float:left\">Average Audience Score:</h4>
                 <h2 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Avg"]."</h2>
                </div>
            </div>";
            }
        } else if($var == "actors"){
            echo"   <div style=\"padding:5px;\">
                        Minimum Movies: <input id=\"minMoviesA\" type=\"text\" value=\"".$qmin."\"/>
                    </div>";
            while ($row = $results->fetch_assoc()) {
        echo "<div class=\"container\" style=\"margin-bottom:10px;background:white;width:100%\">
                <div style=\"float:left;width:100%\">
                 <h2 style=\"\">".$row["ActorName"]."</h2>
                 <h4 style=\"margin-top:5px; margin-right:10px; float:left\">Average Audience Score:</h4>
                 <h2 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Avg"]."</h2>
                </div>
            </div>";
            }
        } else if($var == "timeline"){
            $mysqli3 = new mysqli($servername, $username, $password,$database);
            $summaryResults = $mysqli3->query("CALL GetResults('summary',NULL,'".$term."',NULL);");
            echo "
                    <script type=\"text/javascript\">

                      // Load the Visualization API and the corechart package.
                      

                      // Set a callback to run when the Google Visualization API is loaded.
                      google.charts.setOnLoadCallback(drawChart);

                      // Callback that creates and populates a data table,
                      // instantiates the pie chart, passes in the data and
                      // draws it.
                      function drawChart() {

                        // Create the data table.
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Topping');
                        data.addColumn('number', 'Slices');
                        data.addRows([";
            if (!$summaryResults) {
                echo "Error Connecting";
            
            } else {
                $array = "";
                while ($summaryRow = $summaryResults->fetch_assoc()) {
                    $array= $array . "['".rtrim($summaryRow["genre"])."', ".$summaryRow["percent"]."],";
                }
                $array = trim($array, ",");
                echo $array;
            }
                        echo"
                        ]);

                        // Set chart options
                        var options = {'title':'User Ratings By Genre',
                                       'height':500};

                        // Instantiate and draw our chart, passing in some options.
                        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                      }
                    </script>";
            if($term == ""){
                echo "<div id=\"chart_div\" style=\"display:none\"></div></br>";
            } else {
                echo "<div id=\"chart_div\" style=\"width:70%;margin-left:15%\"></div></br>";
            }
            
            while ($row = $results->fetch_assoc()) {
        echo "<div class=\"container\" style=\"margin-bottom:10px;background:white;width:100%\">
                <div style=\"float:left;width:100%\">
                 <h2 style=\"\">".$row["Title"]."</h2>
                 <h4 style=\"float:right\">".$row["Date"]."</h4>
                 <h4 style=\"margin-top:5px; margin-right:10px; float:left\">Rating Given:</h4>
                 <h2 style=\"margin-top:0px;color:orangered;font-weight:700\">".$row["Rating"]."</h2>
                </div>
            </div>";
            }
        }
    }
    $results->close();
    mysqli_close($mysqli);
    ?>
</div>