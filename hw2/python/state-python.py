#!/usr/bin/env python3
import os
import sys
from http import cookies
from urllib.parse import parse_qs, unquote_plus

#future reference: https://docs.python.org/3/library/http.cookies.html
cookie = cookies.SimpleCookie(os.environ.get('HTTP_COOKIE'))
query_string = os.environ.get('QUERY_STRING', '')
method = os.environ.get('REQUEST_METHOD', 'GET')


params = parse_qs(query_string)
#param is dict and we are trying to get page and defaulting to form if key is not there
page = params.get('page', ['form'])[0]

#the wiping
if "wipe" in query_string:
    print("Set-Cookie: data=; expires=Thu, 01 Jan 1970 00:00:00 GMT")
    print("Content-Type: text/html")
    print("Location: state-python.py")
    print("\n")
    sys.exit()

# if posting, get and update data
new_data = None
if method == "POST":
    content_length = int(os.environ.get('CONTENT_LENGTH', 0))
    body = sys.stdin.read(content_length)
    if "newData" in body:
        new_data = body.split("newData=")[1]
        print(f"Set-Cookie: data={new_data}")

saved_data = cookie.get('data').value if cookie.get('data') else 'N/a'
if new_data: saved_data = new_data

print("Content-Type: text/html\n")
print(f"""<!DOCTYPE html>
<html>
<head>
    <title>state-python</title>
</head>
<body>""")

if page == "form":
    print(f"""
    <h1>State (Python)</h1>
    <form method="POST">
        <input type="text" name="newData">
        <button type="submit">Save</button>
    </form>
    <p>
        <a href="state-python.py?page=view">View Saved Data</a>
    </p>""")
    
elif page == "view":
    print(f"""
    <h1>State Demo (Python) view data</h1>
    
    <p>
        Saved Data: {saved_data}
    </p>
    <a href="state-python.py?wipe=1">Clear Data</a>
    <a href="state-python.py?page=form">Back to Form</a>
    """)

print(f"""
</body>
</html>""")