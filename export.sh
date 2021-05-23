#!/bin/bash

if [ $# -eq 2 ]; then
    if [[ $1 == -v && -f $2 ]]; then
        /usr/bin/php ./console/run.php $1 $2
    else
        printf "%b" "Invalid file path: $2.\n" >&2
        printf "%b" "Usage: ./export.sh -v /path/to/xml\n" >&2
        exit 1
    fi
elif [ $# -eq 1 ]; then
    if [ -f $1 ]; then
        /usr/bin/php ./console/run.php $1
    else
        printf "%b" "Invalid file path: $1.\n" >&2
        printf "%b" "Usage: ./export.sh /path/to/xml\n" >&2
        exit 2
    fi
else
    printf "%b" "Invalid number of arguments.\n" >&2
    printf "%b" "Usage: ./export.sh /path/to/xml OR ./export.sh -v /path/to/xml\n" >&2
    exit 3
fi

