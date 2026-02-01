#!/usr/bin/env node

// cant break lines so we write in one line
process.stdout.write("Content-Type: text/html\n\n");
process.stdout.write("<html><body><h1>Environment Variables</h1><ul>");

for (const key in process.env) {
    process.stdout.write(`<li>${key}: ${process.env[key]}</li>`);
}

process.stdout.write("</ul></body></html>");