# Homework 1, William Berg and Gustav Henningsson, group 104

## 1. Your first task is to define instances of all relations that might be found as part of the Movie Streaming Service (MMS), Hint: there is a minimum of four.
Since an instance of a relation simply defines a set of tuples for that relation, there are quite many possible instances in all of the relations that will be included in the MMS. Since most databases only maintains the current instance however, we shall only list the current instances of all of the mandatory relations included in the MSS.

There are five required relations for the MSS database, and the current instance of these are listed below (with some added attributes and new attribute names) along with a UserProfiles relation:
1. Media(mediaID, mediaName, actors, year, country, director, genre, length, rating)
2. Customers(custID, custName, custDoB, custEmail, custPhoneNumber, custAddress, discountPercentage, upID)
3. Administrators(adminID, position, adminName, adminDoB, adminEmail, adminPhoneNumber, adminAddress)
4. Watchlist(upID, mediaID, rating, progress)
5. SubscriptionPlan(subID, subType, startDate, expirationDate, paymentAmount, creditCardInfo)
6. UserProfiles(upID, upName, upEmail)
Because we will add more relations later there will be many more possible instances than just these current ones.

#### 1.1. What is the name of each relation and its attributes?
See the answer to question 1.0. The attribute names are given in the parentheses following the relation name for all relations.

#### 1.2. What is a suitable domain for each attribute?
We will give this answer by representing the schema for all relations with the domain for all attributes included in the below manner (PK stands for primary key and FK stands for foreign key):
1. Media(<ins>mediaID</ins>: integer, mediaName: string, actors: string, year: integer, country: string, director: string, genre: string, length: numeric, rating: numeric)
2. Customers(<ins>custID</ins>, custName: string, custDoB: date, custEmail: string, custPhoneNumber: string, custAddress: string, discountPercentage: integer, <ins>upID</ins>: integer)
3. Administrators(<ins>adminID</ins>, position: string, adminName: string, adminDoB: date, adminEmail: string, adminPhoneNumber: string, adminAddress: string)
4. Watchlist(<ins>upID</ins>, mediaID</ins>, rating: numeric, progress: integer)
5. SubscriptionPlan(<ins>subID</ins>, subType: string, startDate: date, expirationDate: date, paymentAmount: numeric, creditCardInfo: string)
6. UserProfiles(<ins>upID</ins>: integer, upName: string, upEmail: string)

#### 1.3. Give a relational schema for each relation.
A relational schema for each relation is given in question 1.2 (with domains included for each attribute) and in question 1.0 (with no domains listed).

#### 1.4. Create sample tables of the relations with the most attributes in your database. (i.e. create tables based on the relations and add a few tuples in each table).

Below is a sample medias relation:

| mediaID | mediaName              | actors                                   | year | country | director          | genre   | length | rating |
|-----------|-------------------|------------------------------------------|------|---------|-------------------|---------|--------|--------|
| 1         | Lord of the Rings | Viggo Mortensen, Ian McKellen            | 2001 | New Zealand     | Peter Jackson     | Fantasy | 2.58   | 8.8    |
| 2         | The Big Lebowski  | Jeff Bridges, John Goodman               | 1998 | USA     | Joel Coen         | Comedy  | 1.57   | 8.1    |
| 3         | Pulp Fiction      | Samuel L. Jackson, John Travolta         | 1994 | USA     | Quentin Tarantino | Drama   | 2.34   | 8.9    |

Here is a sample customers relation:

| custID | custName     | custDoB| custEmail               | custPhoneNumber | custAddress            | discountPercentage | upID |
|-----------|----------|---------------|---------------------|--------------|--------------------|---------------------|----------|
| 1         | John Doe | 1789-07-14    | johndoe@gmail.com   | 0705824681   | Kungsgatan 10      | 0                   |    1      |
| 2         | Jane Doe | 1939-09-01    | janedoe@hotmail.com | 0703602469   | Drottningsgatan 20 | 20                  |    2      |

And here is a sample watchlist relation:

| upID | mediaID             | rating | progress |
|--------------|-------------------|--------|----------|
| 1            | 1 | 8.8    | 55       |
| 2            | 2  | 8.1    | 70       |
| 3            | 2  | 8.1    | 90       |

## 2. Present referential integrity constraints on your design.
#### 2.1. Identify and describe the referential constraints for all your defined relations. For instance, identify and describe all the possible primary keys, foreign keys etc.
Many of the relations reference each other, as is the case with relational databases. We can connect them to each other by introducing primary and foreign keys. The primary key for the Customers, the Media, and the Administrators relations would be the Unique ID (it exists solely to serve as a unique primary key for the relation). Then we could introduce a foreign key in the Watchlist relation by having the User Profile attribute refer to the unique ID of the Customers relation. So instead of the Watchlist having a string user profile as its first attribute (like we have it listed above), we could instead include the customer unique ID of the user and that would be a foreign key in the Watchlist relation (and primary key in the Customers relation).

Another possible foreign key in the Watchlist relation is the movie attribute - having it link to the primary key of the movie in the Media relation. Introducing these constraints of course means that the domain needs to be changed for these attributes so that they match the primary key domain in the relations to which they relate.

#### 2.2. State clearly and explain your usage of referential integrity constraints in your solution design, your description  should in particular explain why each attribute has some referential constraint or not.
A foreign key constraint is a type of referential integrity constraint and it is a constraint that we use in the design (see question 2.1). It asserts that a value appearing in one relation must also appear in the primary-key component of another relation. Both the user profile attribute and the movie attribute of the Watchlist relation are constrained in this way. Meaning that any user profile in the Watchlist relation must also appear as a primary key in the Customer relation and the movie listed must also appear in the Media relation (the foreign key must match a primary key in the other relation). These constraints are essentially introduced to ensure that the values for these attributes make sense.

## 3. Write a relational algebra expression representing the following:
#### 3.1. List all the movies which have genre "comedy".
Π<sub>name</sub>(σ<sub>genre = comedy</sub>(Media))

#### 3.2. List all the movies which are produced after "2015".
Π<sub>name</sub>(σ<sub>year > 2015</sub>(Media))

#### 3.3. Retrieve a list of actors and directors in a particular movie you will chose.
Π<sub>actors, director</sub>(σ<sub>name = Pulp Fiction</sub>(Π<sub>name, actors, director</sub>(Media)))

#### 3.4. Retrieve a list of all the movies where the movie date is over the year 2019.
Π<sub>name</sub>(σ<sub>year > 2019</sub>(Media))

#### 3.5. List all the movies which have genre "History" and 2 hours long or more.
Π<sub>name</sub>(σ<sub>genre = history ∧ length > 2</sub>(Media))

#### 3.6. List the names and email addresses of all users who have watched one or more fantasy movies with a rating higher than 7, which have been directed by Peter Jackson.
Π<sub>upName, upEmail</sub>(σ<sub>genre = fantasy ∧ rating > 7 ∧ director = Peter Jackson</sub>(Media ⨝(UserProfiles ⨝ Watchlist)))
