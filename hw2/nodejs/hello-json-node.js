#!/usr/bin/env node
process.stdout.write("Content-Type: application/json\n\n");

const data = {
    message: "HELLO HTML NODE.js",
    language: "Nodejs",
    timestamp: new Date().toISOString(),
    ip_address: process.env.REMOTE_ADDR
};

process.stdout.write(JSON.stringify(data));