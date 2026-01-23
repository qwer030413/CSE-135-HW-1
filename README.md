# CSE-135-HW-1

### Team members:
Chris Park (I did it alone)

### Password for the user "grader" on apache server:
user: grader
password: grader

### Link to site:
[chrisp.site](https://chrisp.site/)

### Login Information for website:
username: chris
password: chris

### Details of Github auto deploy setup
1. get deployment key so that we can give github to use/influence our server using ssh key
* I did something like ssh-keygen "github-actions-deploy"
2. add it to authorized keys using cat .ssh/authorized_keys
3. copy the private key from begin to end
4. add secrets to github(ssh private key, remote host, remote user)
5. create workflow yml file to tell github what to do when I push code from my local
* I made it so that it deploys whenever I push to main branch
* we use the secrets we made previously and also target my site (chrisp.site)
* finally we tell it to copy all the code and update the website
6. fix server permissions so that my user owns the web folder (www/chrisp.site)
7. edit, add, commit and push to see deployed results

### Test Compression verification (Summary of changes to HTML file in DevTools after compression)
After enabling mod_deflate module, I noticed that all the html css and JS files were delivered with content encoding gzip in the resposne header.
The transfered size of the files were compressed, which is probably more efficient and helps us reduce bandwith etc.

### Step 6: Obscure server identity (Summary of removing 'server' header)
I noticed that before any changes, the server was set to "Apache", so I looked into how I can removed that first, before changing that into CSE 135.
I ended up using the mod security and changing the secServerSigniture in the security2.conf file. It overwrote the default apache string with the CSE 135 server string. 

### Step 8:
I did not expect zgrab, which is a bot/web crawler grabbing tool to see what software my server is running on. It is cool that external things like this are trying to access my website
even when it was only live for a few days