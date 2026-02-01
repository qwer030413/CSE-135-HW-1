#!/usr/bin/env python3
import os
import sys
import datetime
import socket

host = socket.gethostname()
date = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
method = os.environ.get('REQUEST_METHOD', 'GET')
query_string = os.environ.get('QUERY_STRING', '')
ip = os.environ.get('REMOTE_ADDR', 'no ip')
protocol = os.environ.get('SERVER_PROTOCOL', 'HTTP/1.1')
user_agent = os.environ.get('HTTP_USER_AGENT', '')

try:
    content_length = int(os.environ.get('CONTENT_LENGTH', 0))
    body = sys.stdin.read(content_length)
except:
    body = ""

#copy pasting from first php examples
print("Content-Type: text/html\n")
print(f"""
<!DOCTYPE html>
<head>
    <title>General Request Echo Python</title>
</head>
<body>
    <h1>General Request Echo Python</h1>
    <p>HTTP Protocol: {protocol}</p>
    <p>HTTP Method: {method}</p>
    <p>Query String: {query_string}</p>
    <p>Message Body: {body}</p>
    <p>Host Name: {host}</p>
    <p>date: {date}</p>
    <p>ip: {ip}</p>
</body>
</html>
""")