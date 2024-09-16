#!/bin/bash

aws s3 cp s3://the-tip-top/certificate/<CERTIFICATE_PATH> /home/the_tip_top/certbot/conf/live/<SERVER_NAME> --recursive