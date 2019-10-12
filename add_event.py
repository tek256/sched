import json
import sys
import pymysql
import datetime as dt

argc = len(sys.argv)
argv = sys.argv

if argv[1] == 'help' or argv[1] == '-help' or argv[1] == '--help' or argv[1] == '-h' or argv[1] == '--h':
    print("Name (maxlen 32), Scheduled Date (datetime), link (maxlen 32), OPTIONAL: type_id (int 11), timezone (maxlen 6)")
    print("Date format: %m/%d/%y %H:%M, i.e 10/9/19 20:00")
    exit()

if argc < 4:
    print("Not enough arguments, exiting early.")
    exit()

if length(argv[1]) == 1:
    print("Not long enough of a title.")
    exit()

if length(argv[1]) > 32:
    print("Too long of a title.");
    exit()

name = argv[1]

time = dt.datetime.strptime(argv[2], "%m/%d/%y %H:%M")
print("Time created: ", time)

link = argv[3]

type_id = 0
if argc >= 5:
    type_id = float(argv[4])

timezone = "PST"
if argc >= 6:
    timezone = argv[5]

query = f"INSERT INTO events (name, sched_time, link, type_id, timezone) VALUES('{name}', '{time}', '{link}', '{type_id}, '{timezone}');"

with open("secrets.txt") as raw_file:
    json_file = json.load(raw_file)

    username = json_file['username']
    password = json_file['password']
    database = json_file['database']
    server = json_file['server']

    db_con = pymysql.connect(server, username, password, database)
    db_curs = db_con.cursor()
    db_curs.execute(query)
    
    db_con.commit()
