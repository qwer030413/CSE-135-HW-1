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

process.stdout.write("Content-Type: text/html\n\n");
process.stdout.write(`
<!DOCTYPE html>
<html>
<head>
    <title>state-NodeJs</title>
</head>

<body>
    <h1>State (NodeJs)</h1>
    <p>
        Saved Data: ${savedData}
    </p>
    <form method="POST">
        <input type="text" name="newData">
        <button type="submit">Save</button>
    </form>

    <a href="?wipe">Clear Data</a>
</body>
</html>
`);