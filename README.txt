to build from the docker file: 
    docker build -t kellerflint/php7.2-apache .

to run the docker container (for development):
    docker run -d -v E:\Google' 'Drive\Programs\web_app:/var/www/html -w / --publish 80:80 --name webserver kellerflint/php7.2-apache