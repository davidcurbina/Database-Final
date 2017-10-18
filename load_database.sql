-- DROP TABLE MovieDatabase.tags;
-- DROP TABLE MovieDatabase.movies;
-- DROP TABLE MovieDatabase.movie_actors;
-- DROP TABLE MovieDatabase.movie_countries;
-- DROP TABLE MovieDatabase.movie_genres;
-- DROP TABLE MovieDatabase.movie_locations;
-- DROP TABLE MovieDatabase.movie_tags;
-- DROP TABLE MovieDatabase.movie_directors;
-- DROP TABLE MovieDatabase.user_ratedmovies;
-- DROP TABLE MovieDatabase.user_ratedmovie_timestamp;
-- DROP TABLE MovieDatabase.user_taggedmovies;
-- DROP TABLE MovieDatabase.user_taggedmovies_timestamp;
CREATE TABLE MovieDatabase.tags (
    id INT,
    mvValue VARCHAR(50),
    PRIMARY KEY (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/tags.dat"
INTO TABLE tags
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES;

CREATE TABLE MovieDatabase.movies (
    id INT,
    title VARCHAR(100),
    imdbID INT,
    spanishTitle VARCHAR(100),
    imdbPictureURL VARCHAR(200),
    mvYear INT,
    rtID VARCHAR(100),
    rtAllCriticsRating FLOAT,
    rtAllCriticsNumReviews INT,
    rtAllCriticsNumFresh INT,
    rtAllCriticsNumRotten INT,
    rtAllCriticsScore FLOAT,
    rtTopCriticsRating FLOAT,
    rtTopCriticsNumReviews INT,
    rtTopCriticsNumFresh INT,
    rtTopCriticsNumRotten INT,
    rtTopCriticsScore FLOAT,
    rtAudienceRating FLOAT,
    rtAudienceNumRatings INT,
    rtAudienceScore FLOAT,
    rtPictureURL VARCHAR(200),
    PRIMARY KEY (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movies.dat"
INTO TABLE movies
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; 

CREATE TABLE MovieDatabase.movie_actors (
    movieID INT,
    actorID VARCHAR(50),
    actorName VARCHAR(50),
    ranking INT,
    PRIMARY KEY (movieID , actorID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movie_actors.dat"
INTO TABLE movie_actors
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; 

CREATE TABLE MovieDatabase.movie_countries (
    movieID INT,
    country VARCHAR(50),
    PRIMARY KEY (movieID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movie_countries.dat"
INTO TABLE movie_countries
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES;

CREATE TABLE MovieDatabase.movie_genres (
    movieID INT,
    genre VARCHAR(50),
    PRIMARY KEY (movieID , genre),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movie_genres.dat"
INTO TABLE movie_genres
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES;

CREATE TABLE MovieDatabase.movie_locations (
    movieID INT,
    location1 VARCHAR(50),
    location2 VARCHAR(50),
    location3 VARCHAR(50),
    location4 VARCHAR(50),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movie_locations.dat"
INTO TABLE movie_locations
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES;

CREATE TABLE MovieDatabase.movie_tags (
    movieID INT,
    tagID INT,
    tagWeight INT,
    PRIMARY KEY (movieID , tagID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id),
    FOREIGN KEY (tagID)
        REFERENCES TAGS (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movie_tags.dat"
INTO TABLE movie_tags
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; -- This is returning warnings

CREATE TABLE MovieDatabase.movie_directors (
    movieID INT,
    directorID VARCHAR(30),
    directorName VARCHAR(30),
    PRIMARY KEY (movieID , directorID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
); 
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/movie_directors.dat"
INTO TABLE movie_directors
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES;  -- This is returning warnings

CREATE TABLE MovieDatabase.user_ratedmovies (
    userID INT,
    movieID INT,
    rating FLOAT,
    date_day INT,
    date_month INT,
    date_year INT,
    date_hour INT,
    date_minute INT,
    date_second INT,
    PRIMARY KEY (userID , movieID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/user_ratedmovies.dat"
INTO TABLE user_ratedmovies
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; 

CREATE TABLE MovieDatabase.user_ratedmovie_timestamp (
    userID INT,
    movieID INT,
    rating FLOAT,
    mvTimeStamp BIGINT,
    PRIMARY KEY (userID , movieID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/user_ratedmovies-timestamps.dat"
INTO TABLE user_ratedmovie_timestamp
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; 

CREATE TABLE MovieDatabase.user_taggedmovies (
    userID INT,
    movieID INT,
    tagID INT,
    date_day INT,
    date_month INT,
    date_year INT,
    date_hour INT,
    date_minute INT,
    date_second INT,
    PRIMARY KEY (userID , movieID , tagID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id),
    FOREIGN KEY (tagID)
        REFERENCES TAGS (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/user_taggedmovies.dat"
INTO TABLE user_taggedmovies
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; 

CREATE TABLE MovieDatabase.user_taggedmovies_timestamp (
    userID INT,
    movieID INT,
    tagID INT,
    mvTimeStamp BIGINT,
    PRIMARY KEY (userID , movieID , tagID),
    FOREIGN KEY (movieID)
        REFERENCES movies (id),
    FOREIGN KEY (tagID)
        REFERENCES tags (id)
);
LOAD DATA LOCAL INFILE "/Users/davidurbina/Documents/Development/dbFinal/Rotten Tomatos Dataset/user_taggedmovies-timestamps.dat"
INTO TABLE user_taggedmovies_timestamp
FIELDS terminated by '\t' lines terminated BY '\n' 
IGNORE 1 LINES; 

DELIMITER $$
CREATE PROCEDURE `GetResults`(IN `QType` VARCHAR(50), IN `QLimit` INT, IN `Term` VARCHAR(50), IN `Qmin` INT)
BEGIN
	IF(QType = "popular") THEN
		SELECT m.title as 'Title', m.mvYear as 'Year', m.rtAudienceScore as 'Audience Score', m.rtPictureURL as 'RTPic', m.imdbPictureURL as 'IMDBPic', directorName
		FROM movie_directors md, movies m
        Where md.movieID = m.id
		ORDER BY m.rtAudienceScore Desc
		Limit QLimit;
	ELSEIF(QType = "title") THEN
		SELECT distinct m.title as 'Title', m.mvYear as 'Year', m.rtAudienceScore as 'Audience Score', m.rtPictureURL as 'RTPic', m.imdbPictureURL as 'IMDBPic', directorName
		FROM movie_directors md, movies m
        Where md.movieID = m.id
        And lower(m.title) like lower(CONCAT('%', Term, '%'))
        Limit QLimit;
	ELSEIF(QType = "actor") THEN
		SELECT distinct m.title as 'Title', m.mvYear as 'Year', m.rtAudienceScore as 'Audience Score', m.rtPictureURL as 'RTPic', m.imdbPictureURL as 'IMDBPic', ma.actorName
		FROM movie_actors ma, movies m
        Where ma.movieID = m.id
        And lower(ma.actorName) like lower(CONCAT('%', Term, '%'))
        Limit QLimit;
	ELSEIF(QType = "director") THEN
		SELECT distinct m.title as 'Title', m.mvYear as 'Year', m.rtAudienceScore as 'Audience Score', m.rtPictureURL as 'RTPic', m.imdbPictureURL as 'IMDBPic', directorName
		FROM movie_directors md, movies m
        Where md.movieID = m.id
        And lower(md.directorName) like lower(CONCAT('%', Term, '%'))
        Limit QLimit;
	ELSEIF(QType = "tags") THEN
        SELECT mvValue tag
		FROM movie_tags mt, movies m, tags t
		WHERE mt.movieID = m.id
        AND t.id = mt.tagID
		AND m.title = Term;
	ELSEIF(QType = "tag") THEN
        SELECT distinct m.title as 'Title', m.mvYear as 'Year', m.rtAudienceScore as 'Audience Score', m.rtPictureURL as 'RTPic', m.imdbPictureURL as 'IMDBPic', directorName
		FROM movie_tags mt, movies m, tags t,movie_directors md
        Where md.movieID = m.id
		AND mt.movieID = m.id
        AND t.id = mt.tagID
		AND t.mvValue like lower(CONCAT('%', Term, '%'))
        ORDER BY m.rtAudienceScore Desc
        Limit QLimit;
	ELSEIF(QType="genre") THEN
		SELECT distinct m.title as 'Title', m.mvYear as 'Year', m.rtAudienceScore as 'Audience Score', m.rtPictureURL as 'RTPic', m.imdbPictureURL as 'IMDBPic'
		FROM movies m, movie_genres mg
		WHERE m.id = mg.movieID
		AND mg.genre like lower(CONCAT('%', Term, '%'))
        ORDER BY m.rtAudienceScore Desc
		Limit QLimit;
    ELSEIF(QType="directors") THEN
        SELECT directorName as 'DirectorName', AVG(m.rtAudienceScore) as 'Avg'
        FROM movie_directors md, movies m
                  WHERE md.movieID = m.id
        GROUP BY directorName HAVING Count(*)>Qmin
        ORDER BY m.rtAudienceScore Desc
        Limit QLimit;
    ELSEIF(QType="actors") THEN
        SELECT actorName as 'ActorName', AVG(m.rtAudienceScore) as 'Avg'
        FROM movie_actors ma, movies m
                  WHERE ma.movieID = m.id
        GROUP BY actorName HAVING Count(*)>Qmin
        ORDER BY AVG(m.rtAudienceScore) Desc
        Limit QLimit;
    ELSEIF(QType="summary") THEN
        SELECT mg.genre, count(mg.genre)/(SELECT COUNT(*) From user_ratedmovies ur Where ur.userID = Term) as 'percent'
		FROM movies m, user_ratedmovies ur, movie_genres mg
        WHERE ur.userID = Term 
        AND ur.movieID = m.id
        AND mg.movieID = m.id
        Group BY mg.genre;
    ELSEIF(QType="details") THEN
        SELECT m.title as 'title', (ur.rating) as 'rating', (select count(*) From user_ratedmovies qur Where qur.movieID = ur.movieID and qur.userID = ur.userID) as 'c', CONCAT(ur.date_day, '/', ur.date_month,'/', ur.date_year) as 'date'       
		FROM movies m, user_ratedmovies ur
        WHERE ur.userID = Term
        AND ur.movieID = m.id
        Group By title;
    ELSEIF(QType = "recommended") THEN
        SELECT DISTINCT title, imdbPictureURL
        FROM movie_tags mt, movies m, tags t
        WHERE mt.movieID = m.id 
        AND t.id = mt.tagID
        AND title != Term
        AND mvValue in (
            SELECT mvValue
            FROM movie_tags mt, movies m, tags t
            WHERE mt.movieID = m.id 
            AND t.id = mt.tagID 
            AND title = Term
        )  
		ORDER BY `m`.`rtAudienceScore`  DESC, tagWeight  DESC
        LIMIT 5;
    END IF;
   END$$
DELIMITER ;