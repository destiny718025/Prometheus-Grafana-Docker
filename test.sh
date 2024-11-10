#!/bin/bash

docker="docker exec app"

for i in {1..10}
do
	$docker curl http://app:8080/stub_status -s
done
