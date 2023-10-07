import xlrd
from random import randrange, choice

"""
workbook = xlrd.open_workbook("Sampledata/Moviesamples.xlsx")
sheet = workbook.sheet_by_index(0)

workbook2 = xlrd.open_workbook("Sampledata/CustomerMovieSamples.xlsx")
sheet2 = workbook2.sheet_by_index(0)

movie_titles = []
year = []
country = []
length = []
genre = []
director = []

for i in range(sheet.nrows):
    if i == 0: continue
    movie_titles.append(sheet.cell_value(i, 2))
    year.append(sheet.cell_value(i, 3))
    country.append(sheet.cell_value(i, 4))
    length.append(sheet.cell_value(i, 5))
    genre.append(sheet.cell_value(i, 7))
    director.append(sheet.cell_value(i, 1))

print("INSERT INTO\n\tMedia (mediaID, name, year, country, director, genre, length, rating)\nVALUES")
for i in range(sheet.nrows-1):
    print(f"\t(DEFAULT, {movie_titles[i]}, {year[i]}, {country[i]}, {director[i]}, {genre[i]}, {length[i]}, {randrange(1,10)})")

progress_list = [43, 32, 10, 89, 95, 25, 12, 100, 43, 54, 67, 50, 100, 32, 54, 78]

print("INSERT INTO\n\tWatchlist (listEntryID, userProfile, movie, episode, rating, progress)\nVALUES")
for i in range(100):
    print(f"\t(DEFAULT, {randrange(1,25)}, {randrange(28)}, NULL, {randrange(1,10)}, {choice(progress_list)})")
"""

names = ['Jane Doe', 'John Doe']
cardtype = ['American Express', 'Visa', 'MasterCard']

print("INSERT INTO\n\tCreditCard (cardID, ccn, cardtype, expirationdate, holdername)\nVALUES")
for i in range(15):
    print(f"\t(DEFAULT, '{randrange(1000000000000000,9999999999999999)}', '{choice(cardtype)}', '{randrange(2021,2029)}-{randrange(10,13)}-{randrange(10,31)}', '{choice(names)}')")
