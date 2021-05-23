FROM redis-export:latest
COPY . ./myapp
WORKDIR ./myapp
CMD [ "bash", "./export.sh ./xml/config.xml" ]