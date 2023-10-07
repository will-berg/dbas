## Queries for lab 1

#### 1. Present the country of Zimbabwe, along with the capital of Zimbabwe and the capital's population.
```sql
SELECT country.name AS country, city.name AS capital, city.population AS capital_population FROM country
JOIN city ON country.code = city.country
WHERE country.name = 'Zimbabwe' AND country.capital = city.name;
```

#### 2. Present a list of all the cities that start with the letter 'S' and end with the letter 'M'.
```sql
SELECT name AS city FROM city
WHERE name LIKE 'S%m'
ORDER BY name;
```

#### 3. Present the country with the highest population.
```sql
SELECT name AS country FROM country
ORDER BY population DESC
LIMIT 1;
```

#### 4. Present a table of all the countries that have between 15 and 20 cities along with the amount of cities.
```sql
WITH cte_country AS (
    SELECT country, cities
    FROM (
        SELECT country, COUNT(*) AS cities
        FROM city
        GROUP BY country
    ) AS tbl
    WHERE cities >=15 AND cities <=20
    ORDER BY cities DESC
)
SELECT country.name AS country, cte_country.cities FROM cte_country
JOIN country ON country.code = cte_country.country;
```

#### 5. Present the world wide average amount of cities in a country.
```sql
SELECT AVG(ct) AS avg_cities
FROM (
    SELECT country, ct
    FROM (
        SELECT country, COUNT(*) AS ct
        FROM city
        GROUP BY country
    ) AS tbl
) AS tbl2;
```

#### 6. Present a table of the top 10% of the countries with the highest GDP per person along with its GDP per person.
```sql
WITH cte_gdppp AS (
    SELECT name AS country, (gdp * 1000000)/population AS gdp_per_person
    FROM (
        SELECT country.name, country.population, economy.gdp
        FROM country
        JOIN economy ON economy.country = country.code
    ) AS tbl
    WHERE gdp IS NOT NULL
    GROUP BY country, gdp_per_person
    ORDER BY gdp_per_person DESC
)
SELECT * FROM cte_gdppp
LIMIT (
    SELECT (COUNT(*) * 0.10) FROM cte_gdppp
);
```

#### 7. Calculate the distance between the Themes' source and Dalälvs source. Tips: You can acquire the latitude or longitude of a geocoord data type through writing (<Attribute-name>).latitude or (<Attribute-name>).longitude.
```sql
WITH cte_rivers AS (
    SELECT (source).latitude AS lat, (source).longitude AS long, name
    FROM river
    WHERE name = 'Thames' OR name = 'DalÃ¤lv'
)
, cte_thames AS (
    SELECT *
    FROM cte_rivers
    WHERE name = 'Thames'
)
, cte_dal AS (
    SELECT *
    FROM cte_rivers
    WHERE name = 'DalÃ¤lv'
)
SELECT (2*6371*ASIN(SQRT(POWER(SIN((RADIANS(cte_thames.lat) - RADIANS(cte_dal.lat))/2), 2) + COS(RADIANS(cte_dal.lat)) * COS(RADIANS(cte_thames.lat)) * POWER(SIN((RADIANS(cte_thames.long) - RADIANS(cte_dal.long))/2), 2)))) AS distance FROM cte_thames, cte_dal;
```

#### 8. Present a table of the top 5 countries with the highest population in each continent along with its population. Tips: Use CTE to shorten your answer.
```sql
WITH cte_country AS (
    SELECT country.name AS country, country.population, encompasses.continent FROM country
    JOIN encompasses ON country.code = encompasses.country
)
, cte_africa AS (
    SELECT * FROM cte_country
    WHERE continent = 'Africa'
    ORDER BY population DESC LIMIT 5
)
, cte_europe AS (
    SELECT * FROM cte_country
    WHERE continent = 'Europe'
    ORDER BY population DESC LIMIT 5
)
, cte_oceania AS (
    SELECT * FROM cte_country
    WHERE continent = 'Australia/Oceania'
    ORDER BY population DESC LIMIT 5
)
, cte_na AS (
    SELECT * FROM cte_country
    WHERE continent = 'North America'
    ORDER BY population DESC LIMIT 5
)
, cte_sa AS (
    SELECT * FROM cte_country
    WHERE continent = 'South America'
    ORDER BY population DESC LIMIT 5
)
, cte_asia AS (
    SELECT * FROM cte_country
    WHERE continent = 'Asia'
    ORDER BY population DESC LIMIT 5
)
SELECT * FROM cte_asia
UNION
SELECT * FROM cte_europe
UNION
SELECT * FROM cte_na
UNION
SELECT * FROM cte_sa
UNION
SELECT * FROM cte_africa
UNION
SELECT * FROM cte_oceania
ORDER BY continent;
```
