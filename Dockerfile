#FROM scratch
#COPY . ./myapp
#WORKDIR ./myapp
#CMD [ "bash", "./export.sh ./xml/config.xml" ]

FROM irijain/redis-export
COPY . ./myapp
WORKDIR ./myapp
CMD [ "bash", "./export.sh ./xml/config.xml" ]