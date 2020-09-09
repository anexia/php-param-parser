#!/usr/bin/env bash

# Set script directory as working directory
workingdir=$(dirname "$0")
cd "${workingdir}" || exit 1

# Build docker images and tag them
docker build -f php:7.1.dockerfile -t php-param-parser:7.1 . || exit 2
docker build -f php:7.2.dockerfile -t php-param-parser:7.2 . || exit 2
docker build -f php:7.3.dockerfile -t php-param-parser:7.3 . || exit 2
docker build -f php:7.4.dockerfile -t php-param-parser:7.4 . || exit 2
