#!/usr/bin/env python3
import json
import os
import datetime

print("Content-Type: application/json\n")

data = {
    "Team": "Team chris",
    "Language" : "Python",
    "timestamp": str(datetime.datetime.now()),
    "ip_address": os.environ.get('REMOTE_ADDR')
}

print(json.dumps(data))
