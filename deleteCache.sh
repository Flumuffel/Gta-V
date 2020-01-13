#!/bin/bash

find /app/public/cache/* -mtime +0.5 -exec rm {} \;