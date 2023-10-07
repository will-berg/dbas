## Queries for lab 2

### Database Creation Queries
1. Insert all your relations into your database.
2. Determine and implement all necessary key constraints.

```sql
DROP TABLE Birthplace, Administrators, Customers, SubscriptionDuration, SubscriptionPayment, UserProfiles, TVSeries, SubscriptionPlan, Directors, Media, Episodes, Actors, Watchlist, CustomerProfiles, Series, MediaActors, TVSeriesActors;

GRANT ALL PRIVILEGES ON Birthplace, Administrators, Customers, SubscriptionDuration, SubscriptionPayment, UserProfiles, TVSeries, SubscriptionPlan, Directors, Media, Episodes, Actors, Watchlist, CustomerProfiles, Series, MediaActors, TVSeriesActors TO ghenn;

CREATE TABLE Administrators (
    adminID SERIAL,
    position TEXT NOT NULL,
    name TEXT NOT NULL,
    DoB DATE,
    email TEXT,
    phoneNumber TEXT,
    address TEXT,

    CONSTRAINT PK_Administrators PRIMARY KEY(adminID)
);

CREATE TABLE Customers (
    custID SERIAL,
    name TEXT NOT NULL,
    DoB DATE,
    email TEXT NOT NULL,
    phoneNumber TEXT,
    address TEXT,
    discountPercentage INT NOT NULL,

    CHECK (discountPercentage BETWEEN 0 AND 100),
    CONSTRAINT PK_Customers PRIMARY KEY(custID)
);

CREATE TABLE SubscriptionDuration (
    startDate DATE,
    expirationDate DATE NOT NULL,

    CONSTRAINT PK_SubscriptionDuration PRIMARY KEY(startDate)
);

CREATE TABLE SubscriptionPayment (
    subType TEXT,
    paymentAmount INT,

    CONSTRAINT PK_SubscriptionPayment PRIMARY KEY(subType)
);

CREATE TABLE UserProfiles (
    upID SERIAL,
    name TEXT NOT NULL,
    email TEXT,
    customer INT,

    CONSTRAINT PK_UserProfiles PRIMARY KEY(upID),
    CONSTRAINT FK_UserProfiles_Customers FOREIGN KEY(customer) REFERENCES Customers(custID) ON DELETE CASCADE /* forgot to add cascade */
);

CREATE TABLE TVSeries (
    TVSeriesID SERIAL,
    name TEXT NOT NULL,
    year INT,
    country TEXT,
    genre TEXT,
    numberOfSeasons INT,
    rating NUMERIC,

    CONSTRAINT PK_TVSeries PRIMARY KEY(TVSeriesID)
);

CREATE TABLE SubscriptionPlan (
    subID SERIAL,
    startDate DATE,
    subType TEXT,
    creditCardInfo TEXT,
    customer INT,

    CONSTRAINT PK_SubscriptionPlan PRIMARY KEY(subID),
    CONSTRAINT FK_SubscriptionPlan_SubscriptionDuration FOREIGN KEY(startDate) REFERENCES SubscriptionDuration(startDate) ON DELETE SET NULL,
    CONSTRAINT FK_SubscriptionPlan_SubscriptionPayment FOREIGN KEY(subType) REFERENCES SubscriptionPayment(subType) ON DELETE CASCADE,
    CONSTRAINT FK_SubscriptionPlan_Customers FOREIGN KEY(customer) REFERENCES Customers(custID) ON DELETE CASCADE
);

CREATE TABLE Directors (
    directorID SERIAL,
    name TEXT NOT NULL,
    DoB DATE,
    gender CHAR,
    nationality TEXT,

    CONSTRAINT PK_Directors PRIMARY KEY(directorID)
);

CREATE TABLE Media (
    mediaID SERIAL,
    name TEXT NOT NULL,
    year INT,
    country TEXT,
    director INT,
    genre TEXT,
    length NUMERIC,
    rating NUMERIC,

    CONSTRAINT PK_Media PRIMARY KEY(mediaID),
    CONSTRAINT FK_Media_Directors FOREIGN KEY(director) REFERENCES Directors(directorID) ON DELETE SET NULL
);

CREATE TABLE Episodes (
    episodeID SERIAL,
    TVSeries INT,
    name TEXT NOT NULL,
    director INT,
    length NUMERIC,
    season INT,
    rating NUMERIC,

    CONSTRAINT PK_Episodes PRIMARY KEY(episodeID),
    CONSTRAINT FK_Episodes_TVSeries FOREIGN KEY(TVSeries) REFERENCES TVSeries(TVSeriesID) ON DELETE CASCADE,
    CONSTRAINT FK_Episodes_Directors FOREIGN KEY(director) REFERENCES Directors(directorID) ON DELETE SET NULL
);

CREATE TABLE Actors (
    actorID SERIAL,
    name TEXT NOT NULL,
    DoB DATE,
    gender CHAR,
    nationality TEXT,

    CONSTRAINT PK_Actors PRIMARY KEY(actorID)
);

CREATE TABLE Watchlist (
    listEntryID SERIAL,
    userProfile INT,
    movie INT,
    episode INT,
    rating NUMERIC,
    progress INT NOT NULL,

    CHECK (progress BETWEEN 0 AND 100),
    CONSTRAINT PK_Watchlist PRIMARY KEY(listEntryID),
    CONSTRAINT FK_Watchlist_Media FOREIGN KEY(movie) REFERENCES Media(mediaID) ON DELETE CASCADE,
    CONSTRAINT FK_Watchlist_Episodes FOREIGN KEY(episode) REFERENCES Episodes(episodeID) ON DELETE CASCADE,
    CONSTRAINT FK_Watchlist_UserProfiles FOREIGN KEY(userProfile) REFERENCES UserProfiles(upID) ON DELETE CASCADE
);

CREATE TABLE MediaActors (
    movie INT,
    actor INT,

    CONSTRAINT PK_MediaActors PRIMARY KEY(movie, actor),
    CONSTRAINT FK_MediaActors_Media FOREIGN KEY(movie) REFERENCES Media(mediaID) ON DELETE CASCADE,
    CONSTRAINT FK_MediaActors_Actors FOREIGN KEY(actor) REFERENCES Actors(actorID) ON DELETE SET NULL
);

CREATE TABLE TVSeriesActors (
    TVSeries INT,
    actor INT,

    CONSTRAINT PK_TVSeriesActors PRIMARY KEY(TVSeries, actor),
    CONSTRAINT FK_TVSeriesActors_TVSeries FOREIGN KEY(TVSeries) REFERENCES TVSeries(TVSeriesID) ON DELETE CASCADE,
    CONSTRAINT FK_TVSeriesActors_Actors FOREIGN KEY(actor) REFERENCES Actors(actorID) ON DELETE SET NULL
);

CREATE TABLE Series (
    movie INT,
    franchise TEXT,
    prequel INT,
    sequel INT,
    remake INT,

    CONSTRAINT PK_Series PRIMARY KEY(movie),
    CONSTRAINT FK_Series_Media0 FOREIGN KEY(movie) REFERENCES Media(mediaID) ON DELETE CASCADE,
    CONSTRAINT FK_Series_Media1 FOREIGN KEY(prequel) REFERENCES Media(mediaID) ON DELETE SET NULL,
    CONSTRAINT FK_Series_Media2 FOREIGN KEY(sequel) REFERENCES Media(mediaID) ON DELETE SET NULL,
    CONSTRAINT FK_Series_Media3 FOREIGN KEY(remake) REFERENCES Media(mediaID) ON DELETE SET NULL
);

CREATE TABLE Card (
    cardID SERIAL,
    CCN TEXT NOT NULL,
    cardType TEXT NOT NULL,
    expirationDate DATE NOT NULL,
    holderName TEXT NOT NULL,

    CONSTRAINT PK_Card PRIMARY KEY(cardID)
);
```

### Insertion Queries
```sql
ALTER TABLE SubscriptionPlan
    ADD COLUMN card INT,
    ADD CONSTRAINT FK_SubscriptionPlan_Card FOREIGN KEY(card) REFERENCES Card(cardID) ON DELETE SET NULL;

INSERT INTO
    Card (cardID, ccn, cardtype, expirationdate, holdername)
VALUES
    (DEFAULT, '6654647442353380', 'MasterCard', '2023-12-27', 'John Doe'),
    (DEFAULT, '4666748524079916', 'MasterCard', '2026-10-17', 'Jane Doe'),
    (DEFAULT, '4328193411299113', 'Visa', '2028-10-13', 'Jane Doe'),
    (DEFAULT, '5332377240302175', 'American Express', '2027-11-29', 'John Doe'),
    (DEFAULT, '2879912021174222', 'MasterCard', '2024-10-29', 'Jane Doe'),
    (DEFAULT, '5495299103058228', 'American Express', '2028-12-13', 'John Doe'),
    (DEFAULT, '8766437952284324', 'American Express', '2026-11-18', 'John Doe'),
    (DEFAULT, '9043444001734186', 'MasterCard', '2026-12-11', 'Jane Doe'),
    (DEFAULT, '8727859202899366', 'Visa', '2028-11-29', 'Jane Doe'),
    (DEFAULT, '1401220589606303', 'Visa', '2021-10-15', 'John Doe'),
    (DEFAULT, '3873080866966119', 'MasterCard', '2027-11-30', 'Jane Doe'),
    (DEFAULT, '3212249898322794', 'Visa', '2026-12-19', 'Jane Doe'),
    (DEFAULT, '7554453123931397', 'American Express', '2026-12-29', 'John Doe'),
    (DEFAULT, '5777669745629229', 'Visa', '2021-11-24', 'Jane Doe'),
    (DEFAULT, '9720719801281158', 'MasterCard', '2023-11-13', 'Jane Doe');

INSERT INTO
    Watchlist (listEntryID, userProfile, movie, episode, rating, progress)
VALUES
    (DEFAULT, 11, 26, NULL, 9.0, 100),
    (DEFAULT, 9, 27, NULL, 8.0, 91),
    (DEFAULT, 5, 28, NULL, 7.0, 21);
    (DEFAULT, 16, 20, NULL, 9.0, 100),
    (DEFAULT, 12, 22, NULL, 7.0, 100),
    (DEFAULT, 9, 23, NULL, 7.0, 54),
    (DEFAULT, 7, 19, NULL, 4.0, 23),
    (DEFAULT, 1, 15, NULL, 4.0, 80),
    (DEFAULT, 1, 1, NULL, 8.0, 78),
    (DEFAULT, 1, 3, NULL, 8.0, 100),
    (DEFAULT, 2, 1, NULL, 7.0, 78),
    (DEFAULT, 2, 8, NULL, 7.0, 78),
    (DEFAULT, 3, 1, NULL, 9.0, 100),
    (DEFAULT, 3, 9, NULL, 9.0, 56),
    (DEFAULT, 4, 2, NULL, 1.3, 100),
    (DEFAULT, 4, 10, NULL, 1.3, 100),
    (DEFAULT, 5, 2, NULL, 6.0, 87),
    (DEFAULT, 5, 19, NULL, 6.0, 13),
    (DEFAULT, 6, 5, NULL, 3.0, 78),
    (DEFAULT, 6, 25, NULL, 3.0, 100),
    (DEFAULT, 7, 6, NULL, 9.0, 50),
    (DEFAULT, 7, 13, NULL, 9.0, 100),
    (DEFAULT, 8, 10, NULL, 9.9, 78),
    (DEFAULT, 8, 18, NULL, 9.9, 1),
    (DEFAULT, 9, 11, NULL, 8.0, 67),
    (DEFAULT, 9, 24, NULL, 8.0, 100),
    (DEFAULT, 10, 24, NULL, 7.6, 78),
    (DEFAULT, 10, 2, NULL, 7.6, 100),
    (DEFAULT, 11, 13, NULL, 3.0, 100),
    (DEFAULT, 11, 14, NULL, 3.0, 100),
    (DEFAULT, 12, 13, NULL, 4.0, 56),
    (DEFAULT, 12, 9, NULL, 4.0, 100),
    (DEFAULT, 13, 13, NULL, 5.0, 76),
    (DEFAULT, 13, 4, NULL, 5.0, 19),
    (DEFAULT, 14, 13, NULL, 6.0, 100),
    (DEFAULT, 14, 11, NULL, 6.0, 90),
    (DEFAULT, 15, 16, NULL, 7.8, 23),
    (DEFAULT, 15, 21, NULL, 7.8, 100),
    (DEFAULT, 16, 4, NULL, 9.0, 99),
    (DEFAULT, 16, 12, NULL, 9.0, 34),
    (DEFAULT, 17, 4, NULL, 1.0, 32),
    (DEFAULT, 17, 5, NULL, 1.0, 100),
    (DEFAULT, 18, 8, NULL, 2.0, 77),
    (DEFAULT, 18, 14, NULL, 2.0, 100),
    (DEFAULT, 19, 9, NULL, 5.0, 89),
    (DEFAULT, 19, 8, NULL, 5.0, 21),
    (DEFAULT, 20, 17, NULL, 2.0, 100),
    (DEFAULT, 20, 18, NULL, 2.0, 100),
    (DEFAULT, 21, 12, NULL, 3.0, 78),
    (DEFAULT, 21, 3, NULL, 3.0, 6),
    (DEFAULT, 22, 12, NULL, 7.0, 56),
    (DEFAULT, 22, 11, NULL, 7.0, 100),
    (DEFAULT, 23, 14, NULL, 9.5, 71),
    (DEFAULT, 23, 8, NULL, 9.5, 100),
    (DEFAULT, 24, 19, NULL, 3.0, 100),
    (DEFAULT, 24, 7, NULL, 3.0, 100),
    (DEFAULT, 25, 18, NULL, 2.4, 78),
    (DEFAULT, 25, 19, NULL, 2.4, 100);


INSERT INTO
    Customers (custID, name, DoB, email, phoneNumber, address, discountPercentage)
VALUES
    (DEFAULT, 'Isak Tromse', '1999-04-26', 'isak@kth.se', '0704568321', 'Gate Blvd 1', 0),
    (DEFAULT, 'Johan Stromster', '1995-11-13', 'johan@email.com', '0704569421', 'Street Blvd 52', 10),
    (DEFAULT, 'Mohammed Abdi', '1895-06-13', 'prophet@email.com', '0709569321', 'Street Gate 42', 20),
    (DEFAULT, 'Strom Sturdy', '1945-12-23', 'strom@email.com', '0701569421', 'Gate Blvd 49', 0),
    (DEFAULT, 'James Smith', '1995-01-03', 'james@email.com', '0704069431', 'Street City 12', 0),
    (DEFAULT, 'Michael Scott', '1969-08-23', 'mike@email.com', '0704599401', 'Scranton Blvd 92', 0),
    (DEFAULT, 'Jim Halpert', '1985-12-23', 'jim@email.com', '0704569521', 'Blvd Road 48', 0),
    (DEFAULT, 'Pam Halpert', '1989-01-03', 'pam@email.com', '0703569421', 'Blvd Road 48', 40),
    (DEFAULT, 'Angela Birrie', '1975-11-13', 'angel@email.com', '0704163401', 'Philly Nilly 87', 0),
    (DEFAULT, 'David Wallace', '1955-03-13', 'dave@email.com', '0709589421', 'New Road 72', 20),
    (DEFAULT, 'Charles Something', '1945-11-13', 'charlie@email.com', '0702549521', 'Street Block 12', 0),
    (DEFAULT, 'Joseph Blyatski', '1925-01-23', 'joppe@email.com', '0704962431', 'Somewhere Blvd 62', 0),
    (DEFAULT, 'Thomas Smith', '1985-05-18', 'tom@email.com', '0704969421', 'Pitts Blvd 12', 0),
    (DEFAULT, 'Anton Margerade', '1925-12-23', 'anton@email.com', '0704263421', 'Betty Blvd 52', 0),
    (DEFAULT, 'John Doe', '1979-01-31', 'john@email.com', '0704459421', 'Washington Blvd 899', 50);

INSERT INTO
    UserProfiles (upID, name, email)
VALUES
    (DEFAULT, 'William', 'willb@kth.se'),
    (DEFAULT, 'John', 'john@email.com'),
    (DEFAULT, 'Dave', 'dave@email.com'),
    (DEFAULT, 'Michael', 'michael@email.com'),
    (DEFAULT, 'James', 'james@email.com'),
    (DEFAULT, 'Johnathan', 'jonathan@email.com'),
    (DEFAULT, 'Richard', 'dick@email.com'),
    (DEFAULT, 'Charles', NULL),
    (DEFAULT, 'Thomas', 'thomas@email.com'),
    (DEFAULT, 'Lisa', NULL),
    (DEFAULT, 'Nancy', 'nancy@email.com'),
    (DEFAULT, 'Matthew', NULL),
    (DEFAULT, 'Donald', 'don@email.com'),
    (DEFAULT, 'Mark', 'mark@email.com'),
    (DEFAULT, 'David', NULL),
    (DEFAULT, 'Joseph', 'joseph@email.se'),
    (DEFAULT, 'Kevin', NULL),
    (DEFAULT, 'Jason', 'jason@email.com'),
    (DEFAULT, 'Ryan', NULL),
    (DEFAULT, 'Jeffrey', NULL);

INSERT INTO
    UserProfiles (upID, name, email)
VALUES
    (DEFAULT, 'Gustav', 'ghenn@kth.se'),
    (DEFAULT, 'Anton', 'anforsm@kth.se'),
    (DEFAULT, 'Adolf', 'adolf@email.com'),
    (DEFAULT, 'Simon', 'simon@email.com'),
    (DEFAULT, 'Dicky', 'dicky@email.com');

INSERT INTO
    CustomerProfiles (userProfile, customer)
VALUES
    (1, 1),
    (2, 1),
    (3, 2),
    (4, 2),
    (5, 3),
    (6, 3),
    (7, 4),
    (8, 4),
    (9, 5),
    (10, 5),
    (11, 6),
    (12, 6),
    (13, 7),
    (14, 7),
    (15, 8),
    (16, 8),
    (17, 9),
    (18, 9),
    (19, 10),
    (20, 10),
    (21, 11),
    (22, 12),
    (23, 13),
    (24, 14),
    (25, 15);

INSERT INTO
    Administrators (adminID, position, name, DoB, email, phoneNumber, address)
VALUES
    (DEFAULT, 'Junior', 'Mark Whaleberg', '1972-04-28', 'markymark@email.com', '0705234187', 'Hollywood Road 23'),
    (DEFAULT, 'Senior', 'Michael Bluth', '1963-04-30', 'mikey@email.com', '0704238187', 'Baker Street 23'),
    (DEFAULT, 'Junior', 'Lucille Austero', '1942-08-19', 'lucille@email.com', '0702334187', 'Reginald Road 104');

INSERT INTO
    Watchlist (listEntryID, userProfile, movie, episode, rating, progress)
VALUES
    ()

/* DIRECTORS */
INSERT INTO
    Directors (directorID, name, DoB, gender, nationality)
VALUES
    /*(DEFAULT, 'Peter Jackson', '1961-10-31', 'M', 'New Zealand'),
    (DEFAULT, 'Robert Zemeckis', '1951-05-14', 'M', 'USA');*/
    (DEFAULT, 'John Carpenter', '1948-01-16', 'M', 'USA');
    (DEFAULT, 'Roger Allers', '1949-06-29', 'M', 'USA'),
    (DEFAULT, 'Jon Favreau', '1966-10-19', 'M', 'USA'),
    (DEFAULT, 'Wolfgang Reitherman', '1909-06-26', 'M', 'Germany'),
    (DEFAULT, 'Ron Clements', '1953-04-25', 'M', 'USA'),
    (DEFAULT, 'Guy Ritchie', '1968-09-10', 'M', 'USA'),
    (DEFAULT, 'Tony Bancroft', '1967-07-31', 'M', 'USA'),
    (DEFAULT, 'Niki Caro', '1967-07-31', 'F', 'New Zealand'),
    (DEFAULT, 'John Carpenter', '1948-01-16', 'M', 'USA');
    (DEFAULT, 'Matte Mattson', '1967-07-31', 'M', 'Holland');

/* LORD OF THE RINGS */
INSERT INTO
    Media (mediaID, name, year, country, director, genre, length, rating)
VALUES
    (DEFAULT, 'Lord of The Rings: The Fellowship of the Ring', 2001, 'New Zealand', (SELECT directorID FROM Directors WHERE name = 'Peter Jackson'), 'Fantasy', 2.58, 8.8),

    (DEFAULT, 'Lord of The Rings: The Two Towers', 2002, 'New Zealand', (SELECT directorID FROM Directors WHERE name = 'Peter Jackson'), 'Fantasy', 2.59, 8.7),

    (DEFAULT, 'Lord of The Rings: The Return of the King', 2003, 'New Zealand', (SELECT directorID FROM Directors WHERE name = 'Peter Jackson'), 'Fantasy', 3.21, 8.9);

INSERT INTO
    Series (movie, franchise, prequel, sequel, remake)
VALUES
    ((SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Fellowship of the Ring'), 'Lord of the Rings', NULL, (SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Two Towers'), NULL),

    ((SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Two Towers'), 'Lord of the Rings', (SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Fellowship of the Ring'), (SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Return of the King'), NULL),

    ((SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Return of the King'), 'Lord of the Rings', (SELECT mediaID FROM Media WHERE name = 'Lord of the Rings: The Two Towers'), NULL, NULL);

/* THE HOBBIT */
INSERT INTO
    Media (mediaID, name, year, country, director, genre, length, rating)
VALUES
    (DEFAULT, 'The Hobbit: An Unexpected Journey', 2012, 'New Zealand', (SELECT directorID FROM Directors WHERE name = 'Peter Jackson'), 'Fantasy', 2.49, 7.8),

    (DEFAULT, 'The Hobbit: The Desolation of Smaug', 2013, 'New Zealand', (SELECT directorID FROM Directors WHERE name = 'Peter Jackson'), 'Fantasy', 2.41, 7.8),

    (DEFAULT, 'The Hobbit: The Battle of the Five Armies', 2014, 'New Zealand', (SELECT directorID FROM Directors WHERE name = 'Peter Jackson'), 'Fantasy', 2.24, 7.4);

INSERT INTO
    Series (movie, franchise, prequel, sequel, remake)
VALUES
    ((SELECT mediaID FROM Media WHERE name = 'The Hobbit: An Unexpected Journey'), 'The Hobbit', NULL, (SELECT mediaID FROM Media WHERE name = 'The Hobbit: The Desolation of Smaug'), NULL),

    ((SELECT mediaID FROM Media WHERE name = 'The Hobbit: The Desolation of Smaug'), 'The Hobbit', (SELECT mediaID FROM Media WHERE name = 'The Hobbit: An Unexpected Journey'), (SELECT mediaID FROM Media WHERE name = 'The Hobbit: The Battle of the Five Armies'), NULL),

    ((SELECT mediaID FROM Media WHERE name = 'The Hobbit: The Battle of the Five Armies'), 'The Hobbit', (SELECT mediaID FROM Media WHERE name = 'The Hobbit: The Desolation of Smaug'), NULL, NULL);


/* BACK TO THE FUTURE */
INSERT INTO
    Media (mediaID, name, year, country, director, genre, length, rating)
VALUES
    (DEFAULT, 'Back to the Future', 1985, 'USA', (SELECT directorID FROM Directors WHERE name = 'Robert Zemeckis'), 'Sci-Fi', 1.56, 8.5),
    (DEFAULT, 'Back to the Future Part 2', 1989, 'USA', (SELECT directorID FROM Directors WHERE name = 'Robert Zemeckis'), 'Sci-Fi', 1.48, 7.8),
    (DEFAULT, 'Back to the Future Part 3', 1990, 'USA', (SELECT directorID FROM Directors WHERE name = 'Robert Zemeckis'), 'Sci-Fi', 1.58, 7.4);

INSERT INTO
    Series (movie, franchise, prequel, sequel, remake)
VALUES
    ((SELECT mediaID FROM Media WHERE name = 'Back to the Future'), 'Back to the Future', NULL, (SELECT mediaID FROM Media WHERE name = 'Back to the Future Part 2'), NULL),

    ((SELECT mediaID FROM Media WHERE name = 'Back to the Future Part 2'), 'Back to the Future', (SELECT mediaID FROM Media WHERE name = 'Back to the Future'), (SELECT mediaID FROM Media WHERE name = 'Back to the Future Part 3'), NULL),

    ((SELECT mediaID FROM Media WHERE name = 'Back to the Future Part 3'), 'Back to the Future', (SELECT mediaID FROM Media WHERE name = 'Back to the Future Part 2'), NULL, NULL);

/* REMAKES */
INSERT INTO
    Media (mediaID, name, year, country, director, genre, length, rating)
VALUES
    (DEFAULT, 'The Lion King', 1994, 'USA', (SELECT directorID FROM Directors WHERE name = 'Roger Allers'), 'Animation', 1.28, 8.5),
    (DEFAULT, 'The Lion King', 2019, 'USA', (SELECT directorID FROM Directors WHERE name = 'Jon Favreau'), 'Animation', 1.58, 6.9),
    (DEFAULT, 'The Jungle Book', 1967, 'USA', (SELECT directorID FROM Directors WHERE name = 'Wolfgang Reitherman'), 'Animation', 1.18, 7.6),
    (DEFAULT, 'The Jungle Book', 2016, 'USA', (SELECT directorID FROM Directors WHERE name = 'Jon Favreau'), 'Adventure', 1.46, 7.4),
    (DEFAULT, 'Aladdin', 1992, 'USA', (SELECT directorID FROM Directors WHERE name = 'Ron Clements'), 'Adventure', 1.30, 8.0),
    (DEFAULT, 'Aladdin', 2016, 'USA', (SELECT directorID FROM Directors WHERE name = 'Guy Ritchie'), 'Adventure', 2.08, 7.0),
    (DEFAULT, 'Mulan', 1998, 'USA', (SELECT directorID FROM Directors WHERE name = 'Tony Bancroft'), 'Adventure', 1.28, 7.6),
    (DEFAULT, 'Mulan', 2020, 'USA', (SELECT directorID FROM Directors WHERE name = 'Niki Caro'), 'Adventure', 1.55, 5.4),
    (DEFAULT, 'The Thing', 1982, 'USA', (SELECT directorID FROM Directors WHERE name = 'John Carpenter'), 'Horror', 1.49, 8.1),
    (DEFAULT, 'The Thing', 2011, 'Holland', (SELECT directorID FROM Directors WHERE name = 'Matte Mattson'), 'Horror', 1.43, 6.2);



INSERT INTO
    Series (movie, franchise, prequel, sequel, remake)
VALUES
    ((SELECT mediaID FROM Media WHERE name = 'The Lion King' AND year = 1994), 'The Lion King', NULL, NULL, (SELECT mediaID FROM Media WHERE name = 'The Lion King' AND year = 2019)),
    ((SELECT mediaID FROM Media WHERE name = 'The Jungle Book' AND year = 1967), 'The Jungle Book', NULL, NULL, (SELECT mediaID FROM Media WHERE name = 'The Jungle Book' AND year = 2016)),
    ((SELECT mediaID FROM Media WHERE name = 'Aladdin' AND year = 1992), 'Aladdin', NULL, NULL, (SELECT mediaID FROM Media WHERE name = 'Aladdin' AND year = 2019)),
    ((SELECT mediaID FROM Media WHERE name = 'Mulan' AND year = 1998), 'Mulan', NULL, NULL, (SELECT mediaID FROM Media WHERE name = 'Mulan' AND year = 2020)),
    ((SELECT mediaID FROM Media WHERE name = 'The Thing' AND year = 1982), 'The Thing', NULL, NULL, (SELECT mediaID FROM Media WHERE name = 'The Thing' AND year = 2011));
```

### Extraction Queries
#### 1. Present a table showing the five most popular media along with the total number of times each media has been streamed.
```sql
WITH cte_streamlist AS (
    SELECT movie, COUNT(*) AS times_streamed
    FROM Watchlist
    GROUP BY movie
)
SELECT media.name AS title, media.year, cte_streamlist.times_streamed FROM cte_streamlist
JOIN media ON media.mediaID = cte_streamlist.movie ORDER BY times_streamed DESC LIMIT 5;
```

#### 2. Present a table showing how likely it is that each user will finish a media, based on their past viewings.
```sql
WITH cte_movieswatched AS (
    SELECT userprofile, COUNT(*) AS movies_started
    FROM Watchlist
    GROUP BY userprofile
)
, cte_progress AS (
    SELECT userprofile, COUNT(progress) AS finishedMovies
    FROM Watchlist
    WHERE progress = 100
    GROUP BY userprofile
)
, cte_percentage AS(
    SELECT cte_movieswatched.userprofile, ((cte_progress.finishedMovies) * 100 / cte_movieswatched.movies_started) AS percentChance
    FROM cte_progress
    RIGHT JOIN cte_movieswatched ON cte_progress.userprofile = cte_movieswatched.userprofile
)
SELECT * FROM cte_percentage
ORDER BY userprofile;
```

#### 3. Present a list of the top 3 most popular directors, which are ranked according to the total amount of minutes their media has accumulated throughout all the users.
```sql
WITH cte_watchlist AS (
    SELECT watchlist.movie, watchlist.progress, media.length, media.director, (media.length * watchlist.progress) / 100 AS minutes
    FROM Watchlist
    JOIN Media ON Media.mediaID = Watchlist.movie
)
, cte_director_list AS (
    SELECT director, SUM(minutes) AS total_watched
    FROM cte_watchlist
    GROUP BY director ORDER BY total_watched DESC LIMIT 3
)
SELECT directors.name, total_watched FROM cte_director_list
JOIN Directors ON directors.directorID = cte_director_list.director ORDER BY total_watched DESC;
```

#### 4. Present a list of all the remakes in the system. For each pair, show which version (original or remake) is the most popular.
```sql
WITH cte_streamlist AS (
    SELECT movie, COUNT(*) AS times_streamed
    FROM Watchlist
    GROUP BY movie
)
, cte_remakes AS (
    SELECT series.movie AS original, series.remake, series.franchise FROM series
    JOIN media ON series.remake = media.mediaID
    WHERE remake IS NOT NULL
)
, cte_remakes_stream_list AS(
    SELECT franchise, times_streamed, remake FROM cte_streamlist
    JOIN cte_remakes ON cte_remakes.remake = cte_streamlist.movie
)
, cte_originals_stream_list AS(
    SELECT franchise, times_streamed, original FROM cte_streamlist
    JOIN cte_remakes ON cte_remakes.original = cte_streamlist.movie
)
, cte_original_remakes AS (
    SELECT original, times_streamed FROM cte_originals_stream_list
    UNION
    SELECT remake, times_streamed FROM cte_remakes_stream_list ORDER BY times_streamed
)
SELECT media.name, media.year, cte_original_remakes.times_streamed FROM cte_original_remakes
JOIN media ON media.mediaID = cte_original_remakes.original ORDER BY name;
```

#### 5. For each media series, use the recursive method po present the name of each media in the series in order along with the sum of the movies popularity.
```sql
WITH RECURSIVE cte_media AS (
      SELECT mediaID, name, movie, franchise, prequel, sequel
      FROM series
      INNER JOIN media ON mediaID = movie
)
, cte_streamlist AS (
    SELECT movie, COUNT(*) AS times_streamed
    FROM Watchlist
    GROUP BY movie ORDER BY times_streamed
)
, recurr AS (
    SELECT movie, name, franchise, prequel, sequel
    FROM cte_media
    WHERE franchise = 'Star Wars' AND prequel IS NULL
    UNION
    SELECT c.movie, c.name, c.franchise, c.prequel, c.sequel
    FROM cte_media c
    INNER JOIN recurr r ON r.movie = c.prequel
)
SELECT string_agg(recurr.name, ', ') AS movieList, recurr.franchise, SUM(cte_streamlist.times_streamed) AS popularity
FROM cte_streamlist
JOIN recurr ON recurr.movie = cte_streamlist.movie
GROUP BY 2;
```





















```sql
/*
CREATE TABLE CustomerProfiles (
    userProfile INT,
    customer INT,

    CONSTRAINT PK_CustomerProfiles PRIMARY KEY(userProfile),
    CONSTRAINT FK_CustomerProfiles_UserProfiles FOREIGN KEY(userProfile) REFERENCES UserProfiles(upID) ON DELETE CASCADE,
    CONSTRAINT FK_CustomerProfiles_Customers FOREIGN KEY(customer) REFERENCES Customers(custID) ON DELETE CASCADE
);
*/

/*
CREATE TABLE MediaFranchises (
    franchiseID SERIAL,
    original INT,
    name TEXT NOT NULL,

    CONSTRAINT PK_MediaFranchises PRIMARY KEY(franchiseID),
    CONSTRAINT FK_MediaFranchises_Media FOREIGN KEY(original) REFERENCES Media(mediaID) ON DELETE SET NULL
)

CREATE TABLE FranchisePrequels (
    franchise INT,
    prequel INT,

    CONSTRAINT PK_FranchisePrequels PRIMARY KEY(franchise, prequel),
    CONSTRAINT FK_FranchisePrequels_MediaFranchises FOREIGN KEY(franchise) REFERENCES MediaFranchises(franchiseID) ON DELETE CASCADE,
    CONSTRAINT FK_FranchisePrequels_Media FOREIGN KEY(prequel) REFERENCES Media(mediaID) ON DELETE CASCADE
)

CREATE TABLE FranchiseSequels (
    franchise INT,
    sequel INT,

    CONSTRAINT PK_FranchiseSequels PRIMARY KEY(franchise, sequel),
    CONSTRAINT FK_FranchiseSequels_MediaFranchises FOREIGN KEY(franchise) REFERENCES MediaFranchises(franchiseID) ON DELETE CASCADE,
    CONSTRAINT FK_FranchiseSequels_Media FOREIGN KEY(sequel) REFERENCES Media(mediaID) ON DELETE CASCADE
)

CREATE TABLE FranchiseRemakes (
    franchise INT,
    remake INT,

    CONSTRAINT PK_FranchiseRemakes PRIMARY KEY(franchise, remake),
    CONSTRAINT FK_FranchiseRemakes_MediaFranchises FOREIGN KEY(franchise) REFERENCES MediaFranchises(franchiseID) ON DELETE CASCADE,
    CONSTRAINT FK_FranchiseRemakes_Media FOREIGN KEY(remake) REFERENCES Media(mediaID) ON DELETE CASCADE
)
*/
```
