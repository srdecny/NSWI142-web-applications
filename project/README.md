# Disclaimer
You are using this on your own risk. For now, this is meant as a local development environment with a script to transfer the state to the Webik server. 

For now, only Linux-based workflow is supported. Feel free to add instructions specific for Windows in a PR!

# How to use
- Install docker-compose (guides are on the internet)
- Run `docker-compose up` in this folder
- Observe the app working on `localhost:8080`
- You should see a "Hello, world" and a dump from db
- If you see "Connection refused" wait a while. The DB might not be ready yet.
- Try modifying the `php/index.php` file and refreshing the page. You should see the content change immediately.

# How it works
The DB has initialization scripts in the `./db` folder. They are ran in the order of their names. The username/password/db names is stored in `docker-compose.yml`. The PHP has the files it serves bind-mounted from `./php`, so any changes in that folder should immediately propagate to the container. It lives on `localhost:8080`.

The local database is running with user/pw `root` and the database name is `db`. It is assumed the database name used on Webik is `stud_<YOUR_ID>`.

# Warnings
The only way to update the database scema is to add a new SQL script and then restart everything with `docker-copose down && docker-compose up`. 

If you want to run the docker-compose in the background, use `docker-compose up -d` (the -d means detached). Stop it with `docker-compose down`.

Make extra sure you're using relative paths in your links/ahrefs. The app is ran under `/~<your_name>` prefix on Webik, so absolute path will be broken there.

# phpMyAdmin
It runs on `localhost:8081`, username/pass: `root/root`.

# Syncing stuff to webik
Add your ssh keys to the server, so you can log in there without typing the password out with `ssh-copy-id <YOUR_USERNAME_HERE>@webik.ms.mff.cuni.cz -p 42222`. You need to do this only once.

Put your database username/password in that script. Put your credentials to `php/db_config.php` too (into the second array). 

Execute the `sync_to_webik.sh` script. It does the following:
- REMOVES EVERYTHING YOU HAVE IN THE `public_html` folder on webik.
- copies over the contents of `./db` and `./php` folders to webik.
- Puts `./php` contents to the `public_html` folder on webik.
- DELETES EVERYTHING YOU HAVE IN YOUR DATABASE. 
- Executes the scripts in `./db` in the lexicographic order of their names.
- HAVE I MENTIONED THIS DELETES EVERYTHING YOU HAVE IN YOUR DATABASE AND TOUR public_html FOLDER?
