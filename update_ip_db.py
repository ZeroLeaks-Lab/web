#!/usr/bin/env python3

import csv
import argparse
import ipaddress

IPV4_TABLE_NAME = "ipv4_country"
IPV6_TABLE_NAME = "ipv6_country"

class SQLFile:
    def __init__(self, path, erase: bool):
        self._file = open(path, "w")
        self._erase = erase
        self._initialized = False

    def _init(self, ip):
        addr = ipaddress.ip_address(ip)
        if isinstance(addr, ipaddress.IPv4Address):
            table = IPV4_TABLE_NAME
            data_type = "INET4"
        elif isinstance(addr, ipaddress.IPv6Address):
            table = IPV6_TABLE_NAME
            data_type = "INET6"
        else:
            raise ValueError("Unknown IP type: "+addr)
        if self._erase:
            self._file.write(f"""DROP TABLE IF EXISTS {table};\n""")
        self._file.write(f"""CREATE TABLE IF NOT EXISTS {table}
(start {data_type} NOT NULL, end {data_type} NOT NULL, country CHAR(2));
INSERT INTO {table} VALUES\n""")
        self._initialized = True

    def add_range(self, start, end, country):
        if self._initialized:
            self._file.write(",\n")
        else:
            self._init(start)
        self._file.write(f"('{start}','{end}','{country}')")

    def finalize(self):
        self._file.write(";\n")
        self._file.close();

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
    parser.add_argument("--erase", help="Clear the table before adding new IPs", action="store_true")
    args = parser.parse_args()
    update_db(args.input, args.output, args.erase)

if __name__ == "__main__":
    main()
