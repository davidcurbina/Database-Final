$(document).ready(function() {
  google.charts.load('current', {'packages':['corechart']});

  $(".btn-pref .btn").click(function () {
      $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
      // $(".tab").addClass("active"); // instead of this do the below 
      $(this).removeClass("btn-default").addClass("btn-primary"); 
  });

  $( "#directors" ).click(function() {
      if (document.getElementById('minMoviesD') != null) {
          var qMin = document.getElementById("minMoviesD").value;
      } else{
          var qMin = 10;
      }
      document.getElementById("limitNumber").innerHTML = "Directors";
    $.ajax({
            url: "http://localhost:8888/dbFinal/results.php?var=directors&count="+document.getElementById("itemsDisplayed").value+"&qmin="+qMin
          }).done(function(data) { // data what is sent back by the php page
           $('#tab2').html(data); // display data
      });
  });
  $( "#actors" ).click(function() {
      if (document.getElementById('minMoviesA') != null) {
          var qMin = document.getElementById("minMoviesA").value;
      } else{
          var qMin = 10;
      }
      document.getElementById("limitNumber").innerHTML = "Actors";
    $.ajax({
            url: "http://localhost:8888/dbFinal/results.php?var=actors&count="+document.getElementById("itemsDisplayed").value+"&qmin="+qMin
          }).done(function(data) { // data what is sent back by the php page
           $('#tab3').html(data); // display data
      });
  });
  $( "#popular" ).click(function() {
      document.getElementById("limitNumber").innerHTML = "Popular";
    $.ajax({
            url: "http://localhost:8888/dbFinal/results.php?var=popular&count="+document.getElementById("itemsDisplayed").value
          }).done(function(data) { // data what is sent back by the php page
           $('#tab1').html(data); // display data
      });
  });
  $( "#timeline" ).click(function() {
      if (document.getElementById("userID").innerHTML != null) {
          var userID = document.getElementById("userID").value;

          $.ajax({
            url: "http://localhost:8888/dbFinal/results.php?var=timeline&count="+document.getElementById("itemsDisplayed").value+"&term="+userID
          }).done(function(data) { // data what is sent back by the php page
           $('#userData').html(data); // display data
      });
      } else{
          var qMin = 10;
      }
      document.getElementById("limitNumber").innerHTML = "Timeline";
  });

  $( "#search" ).click(function() {
      document.getElementById("limitNumber").innerHTML = "Search";
      $( "#searchBtn" ).trigger( "click" );
  });
   $( "#genres" ).click(function() {
      document.getElementById("limitNumber").innerHTML = "Genres";
      $( "#genres" ).trigger( "click" );
  });

  $( "#userIDBtn" ).click(function() {
      $type = "#"+($('#limitNumber')[0].innerHTML);
      $type=$type.toLowerCase();
      $($type).trigger( "click" );
  });
  $( "#searchBtn" ).click(function() {
      if(document.getElementById("searchTerm").value != ""){
        $.ajax({
                url: "http://localhost:8888/dbFinal/results.php?var="+document.getElementById("filterText").innerHTML+"&count="+document.getElementById("itemsDisplayed").value+"&term="+document.getElementById("searchTerm").value
              }).done(function(data) { // data what is sent back by the php page
               $('#searchResults').html(data); // display data
          });
      }
  });
  $( "#popular" ).trigger( "click" );

  $( "#limitBtn" ).click(function() {
      $type = "#"+($('#limitNumber')[0].innerHTML);
      $type=$type.toLowerCase();
      $($type).trigger( "click" );
  });
});

function searchGenre(genre){
   $.ajax({
            url: "http://localhost:8888/dbFinal/results.php?var=genre&count="+document.getElementById("itemsDisplayed").value+"&term="+genre
          }).done(function(data) { // data what is sent back by the php page
           $('#genreResults').html(data); // display data
          var divLoc = $('#resultText').offset();
          $('html, body').animate({scrollTop: divLoc.top}, "slow");
  });
};

function searchTerm(term){
  document.getElementById("searchTerm").value = term;
  $("#search").trigger( "click" );
};

function setSearch(tag){
  document.getElementById("filterText").innerHTML=tag;
  document.getElementById("filterBtn").innerHTML=tag.toUpperCase();;
  console.log(tag);
};

function init() {
  gapi.client.setApiKey("AIzaSyBUZLs6B8PtskGwpp-YnVbTaQEHQoi_HPE");
  gapi.client.load("youtube", "v3", function() {
      // yt api is ready
  });
};

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