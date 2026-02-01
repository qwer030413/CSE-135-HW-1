#!/usr/bin/env python3
import os

print("Content-Type: text/html\n")
print("<html><body><h1>Environment Variables (Python)</h1>")

for key, value in os.environ.items():
    print(f"<li>
          <b>{key}:</b> 
          {value}
          </li>
    ")

print("</body></html>")