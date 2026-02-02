#!/usr/bin/env node
const fs = require('fs');

const queryString = process.env.QUERY_STRING || '';
const cookieHeader = process.env.HTTP_COOKIE || '';
const method = process.env.REQUEST_METHOD || 'GET';

//name=chris; -> turns it into json by splitting and expecting ;
const cookies = Object.fromEntries(cookieHeader.split('; ').map(c => c.split('=')));

if (queryString.includes('wipe')) {
    process.stdout.write("Set-Cookie: data=; expires=Thu, 01 Jan 1970 00:00:00 GMT\n");
    process.stdout.write("Location: state-node.js\n\n");
    process.exit();
}

// saving
let savedData = cookies['data'] || 'none';
if (method === 'POST') {
    const body = fs.readFileSync(0, 'utf8');
    if (body.includes('newData=')) {
        const val = body.split('newData=')[1];
        savedData = decodeURIComponent(val.replace(/\+/g, ' '));
        process.stdout.write(`Set-Cookie: data=${savedData}\n`);
    }
}

// get params by bruteforce split
const params = Object.fromEntries(
  queryString
    .split('&')
    .filter(p => p.includes('='))
    .map(p => p.split('='))
);
const page = params.page || 'form';
process.stdout.write("Content-Type: text/html\n\n");
process.stdout.write(`
<!DOCTYPE html>
<html>
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DW8W4JLZ2W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DW8W4JLZ2W');
</script>
    <title>state-NodeJs</title>
</head>

<body>
`)

if (page == "form"){
    process.stdout.write(`
        <h1>State Demo (NodeJs)enter data</h1>

        <form method="POST" action="state-node.js?page=view">
            <input type="text" name="newData" required>
            <button type="submit">Save</button>
        </form>

        <a href="state-node.js?page=view">View Saved Data</a>
    `)
}
else if (page === 'view') {
    process.stdout.write(`
        <h1>State Demo (NodeJs)view data</h1>

        <p>
            Saved Data: <strong>${savedData}</strong>
        </p>

        <a href="state-node.js?wipe=1">Clear Data</a>
        <a href="state-node.js?page=form">Back to Form</a>
    `)
}
