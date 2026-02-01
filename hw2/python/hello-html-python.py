#!/usr/bin/env python3
import datetime
import os


#Cool thing, we need the .htaccess orsomething so that our pythong script actually runs and shows html correctly (Slack)
print("Content-Type: text/html\n")
print(f"""
<!DOCTYPE html>
<html>
    <head>
        <title>HELLO HTML Python</title>
    </head>
    <body>
        <h1>Hello from Team Chris</h1>
        <p>Language: Python</p>
        <p>Date-Time: {datetime.datetime.now()}</p>
        <p>Your IP: {os.environ.get('REMOTE_ADDR')}</p>
    </body>
</html>
""")