#!/usr/bin/env node

process.stdout.write("Content-Type: text/html\n\n");
process.stdout.write(`<html><head><script async src="https://www.googletagmanager.com/gtag/js?id=G-DW8W4JLZ2W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DW8W4JLZ2W');
</script></head><body><h1>Environment Variables</h1><ul>`);

for (const key in process.env) {
    process.stdout.write(`<li>${key}: ${process.env[key]}</li>`);
}

process.stdout.write("</ul></body></html>");