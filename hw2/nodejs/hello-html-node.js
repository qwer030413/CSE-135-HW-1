#!/usr/bin/env node
// lowkey same as python
process.stdout.write("Content-Type: text/html\n\n");
process.stdout.write(`
<!DOCTYPE html>
<html>
<head><title>Hello HTML - Node</title></head>
<body>
    <h1>HELLO HTML NODE.js</h1>
    <p><b>Language:</b> NodeJS</p>
    <p><b>Generated on:</b> ${new Date().toLocaleString()}</p>
    <p><b>Your IP Address:</b> ${process.env.REMOTE_ADDR}</p>
</body>
</html>
`);