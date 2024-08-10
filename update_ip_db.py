#!/usr/bin/env python3

import csv
import argparse

TABLE_NAME = "ip_country"

class SQLFile:
    def __init__(self, path, erase: bool):
        self.file = open(path, "w")
        if erase:
            self.file.write(f"""DROP TABLE IF EXISTS {TABLE_NAME};\n""")
        self.file.write(f"""CREATE TABLE IF NOT EXISTS {TABLE_NAME}
(start INET6 NOT NULL, end INET6 NOT NULL, country CHAR(2));
INSERT INTO {TABLE_NAME} VALUES\n""")
        self.not_first = False

    def add_range(self, start, end, country):
        if self.not_first:
            self.file.write(",\n")
        self.file.write(f"('{start}','{end}','{country}')")
        self.not_first = True

    def finalize(self):
        self.file.write(";\n")
        self.file.close();

def update_db(input, output, erase: bool):
    with open(input, "r") as f:
        sqlfile = SQLFile(output, erase)
        reader = csv.reader(f)
        for row in reader:
            start, end, country = row
            sqlfile.add_range(start, end, country)
        sqlfile.finalize()

def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("input", help="GeoLite2 IP country CSV file")
    parser.add_argument("output", help="SQL file name")
    parser.add_argument("--erase", help="Clear the database before adding the data", action="store_true")
    args = parser.parse_args()
    update_db(args.input, args.output, args.erase)

if __name__ == "__main__":
    main()
