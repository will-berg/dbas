# Check Constraints

### 1.
```sql
ALTER TABLE watchlist
ADD CONSTRAINT progress_check
CHECK (progress BETWEEN 0 AND 100);
```

### 2.
```sql
ALTER TABLE directors
ADD CONSTRAINT gender_check
CHECK (
    gender = 'M'
    OR gender = 'F'
);

ALTER TABLE actors
ADD CONSTRAINT gender_check
CHECK (
    gender = 'M'
    OR gender = 'F'
);
```

### 3.
```sql
ALTER TABLE media
ADD CONSTRAINT year_check
CHECK (
    year > 1880
);
```

### 4.
```sql
ALTER TABLE media
ADD CONSTRAINT length_check
CHECK (length BETWEEN 0 AND 300);
```

### 5.
```sql
ALTER TABLE
ADD CONSTRAINT cardtype_check
CHECK (
    cardtype = 'American Express'
    OR cardtype = 'MasterCard'
    OR cardtype = 'Visa'
);
```