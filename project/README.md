# Disclaimer
You are using this on your own risk. For now, this is meant as a local development environment. In the future, it is expected there will be a way to easily transfer the local environment to the Webik server. 

# How to use
- Install docker-compose (guides are on the internet)
- Run `docker-compose up` in this folder
- Observe the app working on `localhost:8080`
- You should see a "Hello, world" and a dump from db
- If you see "Connection refused" wait a while. The DB might not be ready yet.
- Try modifying the `php/index.php` file and refreshing the page. You should see the content change immediately.

# How it works
The DB has initialization scripts in the `./db` folder. They are ran in the order of their names. The username/password/db names is stored in `docker-compose.yml`.

The PHP has the files it serves bind-mounted from `./php`, so any changes in that folder should immediately propagate to the container. It lives on `localhost:8080`.

# Warnings
The only way to update the database scema is to add a new SQL script and then restart everything with `docker-copose down && docker-compose up`. 

If you want to run the docker-compose in the background, use `docker-compose up -d` (the -d means detached). Stop it with `docker-compose down`.
