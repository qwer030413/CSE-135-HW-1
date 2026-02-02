#!/usr/bin/env node
const os = require('os');
const fs = require('fs');

// ref: https://nodejs.org/api/process.html
// process is not what I defined olol
const method = process.env.REQUEST_METHOD || 'GET';
const body = fs.readFileSync(0, 'utf8');

process.stdout.write("Content-Type: text/html\n")
process.stdout.write(`
<!DOCTYPE html>
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DW8W4JLZ2W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DW8W4JLZ2W');
</script>
    <title>General Request Echo NodeJs</title>
</head>
<body>
    <h1>General Request Echo NodeJs</h1>
    <p>HTTP Protocol: ${process.env.SERVER_PROTOCOL}</p>
    <p>HTTP Method: ${method}</p>
    <p>Query String: ${process.env.QUERY_STRING || ''}</p>
    <p>Message Body: ${body}</p>
    <p>Host Name: ${os.hostname()}</p>
    <p>date: ${new Date().toLocaleString()}</p>
    <p>ip: ${process.env.REMOTE_ADDR || 'err'}</p>
</body>
</html>
`);